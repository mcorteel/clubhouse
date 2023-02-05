<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class LoginController extends Controller
{
    public function index()
    {
        $error = null;
        
        if(isset($_POST['email']) && isset($_POST['password'])) {
            $hasher = new PasswordHash(8, false);
            
            $user = $this->querySingle('SELECT * FROM users WHERE email = ?', array($_POST['email']));
            
            if($user && $hasher->CheckPassword($_POST['password'], $user['password'])) {
                $_SESSION['auth_user'] = $user['id'];
            } else {
                $error = 'Identifiants incorrects';
            }
        }
        
        if($this->getUser()) {
            return $this->redirectTo('/');
        }
        
        return $this->render('login/index.php', array(
            'error' => $error,
        ));
    }
    
    public function logout()
    {
        unset($_SESSION['auth_user']);
        
        return $this->redirectTo('/');
    }
}
