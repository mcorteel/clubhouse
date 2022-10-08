<?php

include_once 'controller.php';

class AdminNewsController extends Controller
{
    public function all($page = 1)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'news_admin');
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(*) FROM news');
        
        $itemsPerPage = 10;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('admin/news/list.php', array(
            'news' => $this->query('SELECT * FROM news ORDER BY date DESC LIMIT ' . $firstItem . ', ' . $itemsPerPage),
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
        ));
    }
    
    public function edit($id = null)
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'news_admin');
        
        if($id !== null) {
            $news = $this->querySingle('SELECT * FROM news WHERE id = ?', array($id));
        } else {
            $news = array(
                'id' => null,
                'title' => '',
                'content' => '',
                'posteur' => null,
            );
        }
        
        if(isset($_POST['title'])) {
            $data = array(
                'title' => $_POST['title'],
            );
            if($news['posteur']) {
                $data['message'] = $_POST['content'];
            } else {
                $data['content'] = $_POST['content'];
            }
            if($news['id']) {
                $this->update('news', $news['id'], $data);
            } else {
                $data['user'] = $user['id'];
                $data['date'] = date('Y-m-d H:i:s');
                $this->insert('news', $data);
            }
            
            return $this->redirectTo('/admin/actualites');
        }
        
        return $this->render('admin/news/edit.php', array(
            'news' => $news,
        ));
    }
    
    public function remove($id)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'news_admin');
        
        $partner = $this->querySingle('SELECT * FROM news WHERE id = ?', array($id));
        
        $this->delete('news', array('id' => $partner['id']));
        
        return $this->redirectTo('/admin/actualites');
    }
}
