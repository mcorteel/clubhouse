<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class AdminResourcesController extends Controller
{
    public function all($page = 1)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'admin');
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(*) FROM resources');
        
        $itemsPerPage = 10;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('admin/resource/list.php', array(
            'resources' => $this->query('SELECT * FROM resources LIMIT ' . $firstItem . ', ' . $itemsPerPage),
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
        ));
    }
    
    public function edit($id = null)
    {
        if(!$this->isGranted($this->getUser(), 'admin')) {
            return $this->redirectTo('/actualites');
        }
        
        if($id !== null) {
            $resource = $this->querySingle('SELECT * FROM resources WHERE id = ?', array($id));
        } else {
            $resource = array(
                'id' => null,
                'name' => '',
                'group_name' => '',
                'short_name' => '',
            );
        }
        
        if(isset($_POST['name'])) {
            $data = array(
                'name' => $_POST['name'],
                'group_name' => $_POST['group_name'],
                'short_name' => $_POST['short_name'],
            );
            if($resource['id']) {
                $this->update('resources', $resource['id'], $data);
            } else {
                $this->insert('resources', $data);
            }
            
            return $this->redirectTo('/admin/ressources');
        }
        
        return $this->render('admin/resource/edit.php', array(
            'resource' => $resource,
        ));
    }
    
    public function remove($id)
    {
        if(!$this->isGranted($this->getUser(), 'admin')) {
            return $this->redirectTo('/actualites');
        }
        
        $resource = $this->querySingle('SELECT * FROM resources WHERE id = ?', array($id));
        
        $this->delete('resources', array('id' => $resource['id']));
        
        return $this->redirectTo('/admin/ressources');
    }
}
