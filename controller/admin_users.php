<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class AdminUsersController extends Controller
{
    private function getRoles()
    {
        return include 'config/permissions.php';
    }
    
    public function all($page = 1)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'user_admin');
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(*) FROM users');
        
        $itemsPerPage = 10;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('admin/user/list.php', array(
            'users' => $this->query('SELECT * FROM users ORDER BY active ASC, last_name ASC, first_name ASC LIMIT ' . $firstItem . ', ' . $itemsPerPage),
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
            'roles' => $this->getRoles(),
        ));
    }
    
    public function edit($id = null)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'user_admin');
        
        if($id !== null) {
            $user = $this->querySingle('SELECT * FROM users WHERE id = ?', array($id));
        } else {
            $user = array(
                'id' => null,
                'active' => true,
                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'roles' => '',
                'reservation_type' => 'normal',
            );
        }
        
        if(isset($_POST['first_name'])) {
            $data = array(
                'active' => isset($_POST['active']) ? 1 : 0,
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'roles' => implode(',', array_unique(isset($_POST['roles']) ? $_POST['roles'] : array())),
                'reservation_type' => $_POST['reservation_type'],
            );
            if($password = $_POST['password']) {
                $hasher = new PasswordHash(8, false);
                
                $data['password'] = $hasher->HashPassword($password);
            }
            if($user['id']) {
                $this->update('users', $user['id'], $data);
                return $this->redirectTo('/admin/utilisateurs/' . $user['id']);
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->insert('users', $data);
                
                return $this->redirectTo('/admin/utilisateurs');
            }
        }
        
        return $this->render('admin/user/edit.php', array(
            'user' => $user,
            'roles' => $this->getRoles(),
            'reservationTypes' => include 'config/reservation_types.php',
        ));
    }
}
