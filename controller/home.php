<?php

include_once 'controller.php';

class HomeController extends Controller
{
    public function index($page = 1)
    {
        $count = $this->querySingleScalar('SELECT COUNT(*) FROM news');
        
        $itemsPerPage = 5;
                
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('home/index.php', array(
            'articles' => $this->query('SELECT n.id, n.content, n.title, TRIM(CONCAT(COALESCE(u.first_name, ""), " ", COALESCE(u.last_name, ""))) AS name, n.date FROM news n LEFT JOIN users u ON n.user = u.id ORDER BY n.date DESC LIMIT ' . $firstItem  . ',' . $itemsPerPage),
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
            'canEdit' => $this->isGranted($this->getUser(), 'admin'),
        ));
    }
}
