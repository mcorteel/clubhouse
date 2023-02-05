<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class LoginController extends Controller
{
    public function index()
    {
        $loginError = null;
        
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $hasher = new PasswordHash(8, false);
            
            $user = $this->querySingle('SELECT * FROM users WHERE email = ?', array($_POST['email']));
            
            if($user && !$user['active']) {
                $loginError = 'Compte inactif';
            } elseif($user && $hasher->CheckPassword($_POST['password'], $user['password'])) {
                $_SESSION['auth_user'] = $user['id'];
            } else {
                $loginError = 'Identifiants incorrects';
            }
        }
        
        if($this->getUser()) {
            return $this->redirectTo('/');
        }
        
        return $this->render('login/index.php', array(
            'loginError' => $loginError,
            'registration' => $this->getConfig('user_registration_allow'),
            'registrationError' => null,
            'recaptchaKey' => $this->getConfig('recaptcha_key'),
        ));
    }
    
    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->redirectTo('/login');
        }
        
        if($this->getUser() || !$this->getConfig('user_registration_allow')) {
            return $this->redirectTo('/');
        }
        
        if(!isset($_POST['email']) || !isset($_POST['password'])) {
            return $this->redirectTo('/');
        }
        
        $registrationError = null;
        
        if(isset($_POST['g-recaptcha-response'])) {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $data = array('secret' => $this->getConfig('recaptcha_secret'), 'response' => $_POST['g-recaptcha-response']);
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context = stream_context_create($options);
            if(false === $result = file_get_contents($url, false, $context)) {
                $registrationError = 'Le service reCAPTCHA a renvoyé une erreur. Veuillez contacter l\'administrateur.';
            } else {
                $data = json_decode($result, true);
                if(!$data['success']) {
                    $registrationError = 'Vous êtes probablement un robot. Si ce n\'est pas le cas, il est peut-être temps de vous remettre en question !';
                }
            }
        }
        
        if((int)$this->querySingleScalar('SELECT COUNT(*) FROM users WHERE email = ?', array($_POST['email'])) > 0) {
            $registrationError = 'Ce nom d\'utilisateur est déjà pris.';
        }
        if(!$registrationError) {
            $data = array(
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'active' => $this->getConfig('user_registration_verify') ? 0 : 1,
                'roles' => $this->getConfig('user_registration_roles'),
                'reservation_type' => 'normal',
            );
            if($password = $_POST['password']) {
                $hasher = new PasswordHash(8, false);
                
                $data['password'] = @$hasher->HashPassword($password);
            }
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->insert('users', $data);
        }
        
        return $this->render('login/index.php', array(
            'loginError' => null,
            'registration' => $this->getConfig('user_registration_allow'),
            'registrationError' => $registrationError,
            'registered' => true,
            'verify' => $this->getConfig('user_registration_verify'),
            'recaptchaKey' => $this->getConfig('recaptcha_key'),
        ));
    }
    
    public function logout()
    {
        unset($_SESSION['auth_user']);
        
        return $this->redirectTo('/');
    }
}
