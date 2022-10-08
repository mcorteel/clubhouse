<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class AdminPartnersController extends Controller
{
    public function all($page = 1)
    {
        if(!$this->isGranted($this->getUser(), 'admin')) {
            return $this->redirectTo('/actualites');
        }
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(*) FROM partners');
        
        $itemsPerPage = 10;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('admin/partner/list.php', array(
            'partners' => $this->query('SELECT * FROM partners LIMIT ' . $firstItem . ', ' . $itemsPerPage),
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
            $partner = $this->querySingle('SELECT * FROM partners WHERE id = ?', array($id));
        } else {
            $partner = array(
                'id' => null,
                'name' => '',
                'description' => '',
            );
        }
        
        if(isset($_POST['description'])) {
            $data = array(
                'name' => $_POST['name'],
                'description' => $_POST['description'],
            );
            if($partner['id']) {
                $this->update('partners', $partner['id'], $data);
            } else {
                $this->insert('partners', $data);
            }
            
            return $this->redirectTo('/admin/partenaires');
        }
        
        return $this->render('admin/partner/edit.php', array(
            'partner' => $partner,
        ));
    }
    
    public function remove($id)
    {
        if(!$this->isGranted($this->getUser(), 'admin')) {
            return $this->redirectTo('/actualites');
        }
        
        $partner = $this->querySingle('SELECT * FROM partners WHERE id = ?', array($id));
        
        $this->delete('partners', array('id' => $partner['id']));
        
        return $this->redirectTo('/admin/partenaires');
    }
}
