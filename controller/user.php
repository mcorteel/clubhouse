<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class UserController extends Controller
{
    public function index()
    {
        return $this->render('user/index.php', array(
            
        ));
    }
    
    public function profile()
    {
        $user = $this->getUser();
        
        $redirect = false;
        if(isset($_POST['email']) && $_POST['email'] !== $user['email']) {
            $this->update('users', $user['id'], array(
                'email' => $_POST['email'],
            ));
            $this->flash('Votre e-mail a bien été mis à jour', 'success');
            $redirect = true;
        }
        if(isset($_POST['password']) && $_POST['password']) {
            $password = $_POST['new_password'];
            $hasher = new PasswordHash(8, false);
            
            if(!$hasher->CheckPassword($_POST['password'], $user['password'])) {
                $this->flash('Mot de passe incorrect.' . $user['password'], 'warning');
            } elseif(strlen($password) < 8) {
                $this->flash('Veuillez définir un mot de passe d\'au moins 8 caractères.', 'warning');
            } elseif($password !== $_POST['password_confirmation']) {
                $this->flash('Les mots de passe ne correspondent pas.', 'warning');
            } else {
                $this->update('users', $user['id'], array(
                    'password' => $hasher->HashPassword($password),
                ));
                
                $this->flash('Votre mot de passe a bien été mis à jour', 'success');
                
                $redirect = true;
            }
        }
        
        if($redirect) {
            return $this->redirectTo('/utilisateur');
        }
        
        return $this->render('user/profile.php', array(
            
        ));
    }
    
    public function reservations($page = 1)
    {
        $user = $this->getUser();
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(DISTINCT p.reservation) FROM reservation_players p JOIN reservations r ON p.reservation = r.id WHERE p.user = ? AND r.recurrence = ?', array($user['id'], 'none'));
        
        $itemsPerPage = 10;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        $reservations = $this->query('SELECT r.* FROM reservation_players p JOIN reservations r ON p.reservation = r.id WHERE p.user = ? AND r.recurrence = ? ORDER BY r.date_start DESC LIMIT ' . $firstItem . ', ' . $itemsPerPage, array($user['id'], 'none'));
        foreach($reservations as $i => $reservation) {
            $reservations[$i]['players'] = $this->query('SELECT u.id AS id, CONCAT(COALESCE(u.first_name, ""), " ", COALESCE(u.last_name, "")) AS name, p.team FROM reservation_players p JOIN users u ON p.user = u.id WHERE p.reservation = ?', array($reservation['id']));
        }
        
        return $this->render('user/reservations.php', array(
            'reservations' => $reservations,
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
        ));
    }
}
