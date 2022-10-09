<?php

include_once 'controller.php';
require(dirname(__FILE__) . '/../vendor/phpass/PasswordHash.php');

class AdminPicturesController extends Controller
{
    const EXTENSIONS = 'jpg,png,jpeg';
    
    public function all($page = 1)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'admin');
        
        $count = (int)$this->querySingleScalar('SELECT COUNT(*) FROM pictures');
        
        $itemsPerPage = 24;
        
        $pages = ceil($count / $itemsPerPage);
        
        $page = max(1, min((int)$page, $pages));
        
        $firstItem = ((int)$page - 1) * $itemsPerPage;
        
        return $this->render('admin/picture/list.php', array(
            'pictures' => $this->query('SELECT * FROM pictures ORDER BY created_at DESC, id DESC LIMIT ' . $firstItem . ', ' . $itemsPerPage),
            'pagination' => array(
                'page' => $page,
                'pages' => $pages,
            ),
        ));
    }
    
    public function edit($id = null)
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'admin');
        
        $dir = $this->getConfig('picture_dir');
        
        if($id !== null) {
            $picture = $this->querySingle('SELECT * FROM pictures WHERE id = ?', array($id));
            $oldfile = $picture['file'];
        } else {
            $picture = array(
                'id' => null,
                'title' => '',
                'file' => null,
                'created_at' => null
            );
            $oldfile = false;
        }
        
        if(isset($_POST['title'])) {
            $data = array(
                'title' => $_POST['title'],
                'file' => $picture['file'],
                'created_at' => $picture['created_at'] ? $picture['created_at'] : date('Y-m-d H:i:s'),
                'user' => $user['id'],
            );
            if(isset($_FILES['file']) && $_FILES['file']['size']) {
                $root_dir = realpath(getcwd());
                if(!$root_dir) {
                    $this->flash('Le répertoire de téléversement n\'existe pas.', 'danger');
                    $data['file'] = null;
                } else {
                    $filename = basename($_FILES['file']['name']);
                    $target_dir = $root_dir . '/' . $dir . '/';
                    $target_file = $target_dir . $filename;
                    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $allowed_extensions = explode(',', self::EXTENSIONS);
                    $filename = uniqid() . '.' . $extension;
                    $target_file = $target_dir . $filename;
                    $data['file'] = $dir . '/' . $filename;
                    if(!$_FILES['file']['tmp_name']) {
                        $this->flash('Le fichier n\'a pas pu être téléversé.', 'danger');
                        $data['file'] = null;
                    } elseif(getimagesize($_FILES['file']['tmp_name']) === false) {
                        $this->flash('Ce n\'est pas une image.', 'danger');
                        $data['file'] = null;
                    } elseif(file_exists($target_file)) {
                        $this->flash('Un fichier du même nom existe déjà.', 'danger');
                        echo "Sorry, file already exists.";
                        $data['file'] = null;
                    } elseif($_FILES['file']['size'] > 5 * 1024 * 1024) {
                        $this->flash('La taille du fichier dépasse les 5 Mo.', 'danger');
                        echo "Sorry, your file is too large.";
                        $data['file'] = null;
                    } elseif(!in_array($extension, $allowed_extensions)) {
                        $this->flash('Seuls les extensions jpg et png sont permis.', 'danger');
                        $data['file'] = null;
                    } elseif(!move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                        $this->flash('Une erreur s\'est produite lors du téléversement du fichier.', 'danger');
                        $data['file'] = null;
                    } else {
                        if($oldfile && !unlink($root_dir . '/' . $oldfile)) {
                            $this->flash('Impossible de supprimer l\'ancien fichier.', 'info');
                        }
                    }
                }
            }
            if($data['file']) {
                if($picture['id']) {
                    $this->update('pictures', $picture['id'], $data);
                } else {
                    $this->insert('pictures', $data);
                }
                
                return $this->redirectTo('/admin/images');
            }
        }
        
        return $this->render('admin/picture/edit.php', array(
            'picture' => $picture,
        ));
    }
    
    public function remove($id)
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'admin');
        
        $picture = $this->querySingle('SELECT * FROM pictures WHERE id = ?', array($id));
        
        $root_dir = realpath(getcwd());
        if(!$root_dir) {
            $this->flash('Le répertoire de téléversement n\'existe pas.', 'danger');
            return $this->redirectTo('/admin/images/' . $picture['id']);
        } else {
            $filename = basename($_FILES['file']['name']);
            $root_dir = $root_dir . '/';
            $this->delete('pictures', array('id' => $picture['id']));
        
            if(!unlink($root_dir . $picture['file'])) {
                $this->flash('Impossible de supprimer le fichier.', 'info');
            }
        }
        
        return $this->redirectTo('/admin/images');
    }
    
    public function scan()
    {
        $this->denyAccessUnlessGranted($this->getUser(), 'admin');
        
        $target_dir = realpath(getcwd());
        
        $dir = isset($_GET['dir']) ? $_GET['dir'] : $this->getConfig('picture_dir');
        $create = isset($_GET['confirm']) && $_GET['confirm'] === '1';
        $allowed_extensions = explode(',', self::EXTENSIONS);
        
        $pictures = array();
        $date = date('Y-m-d H:i:s');
        foreach(glob($target_dir . '/' . $dir . '/*') as $file) {
            $_file = str_replace($target_dir . '/', '', $file);
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if(!in_array($extension, $allowed_extensions)) {
                continue;
            }
            
            $pictures = $this->query('SELECT * FROM pictures WHERE file = ?', array($_file));
            $exists = !empty($pictures);
            
            $pictures[] = array(
                'file' => $file,
                'exists' => $exists || $create,
            );
            if(!$exists && $create) {
                $this->insert('pictures', array(
                    'file' => $_file,
                    'title' => basename($_file),
                    'created_at' => $date,
                ));
            }
        }
        
        return $this->render('admin/picture/scan.php', array(
            'pictures' => $pictures,
            'dir' => $dir,
        ));
    }
}
