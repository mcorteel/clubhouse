<?php

include_once 'controller.php';

class AdminController extends Controller
{
    public function index($page = 1)
    {
        if(!$this->isGranted($user = $this->getUser(), 'admin')) {
            return $this->redirectTo('/');
        }
        
        return $this->render('admin/index.php', array(
            'permissions' => array(
                'users' => $this->isGranted($user, 'user_admin'),
                'config' => $this->isGranted($user, 'admin'),
                'partners' => $this->isGranted($user, 'admin'),
                'news' => $this->isGranted($user, 'news_admin'),
                'pictures' => $this->isGranted($user, 'admin'),
                'resources' => $this->isGranted($user, 'admin'),
            ),
            'db_version' => $this->getDatabaseVersion(),
        ));
    }
}
