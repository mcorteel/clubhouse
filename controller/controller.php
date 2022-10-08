<?php

include_once 'lib/authorization.php';
include_once 'lib/renderer.php';
include_once 'lib/router.php';

class Controller
{
    private $database = null;
    private $user = null;
    private $authorization = null;
    private $router = null;
    
    public function generateUrl($path, $arguments = array())
    {
        if($this->router === null) {
            $this->router = new Router();
        }
        return $this->router->generateUrl($path, $arguments);
    }
    
    protected function render($file, $arguments = array())
    {
        $renderer = new Renderer();
        $arguments['app'] = array(
            'user' => $this->getUser(),
        );
        return $renderer->render($file, $arguments);
    }
    
    protected function renderModal($file, $arguments = array())
    {
        $renderer = new Renderer();
        $arguments['app'] = array(
            'user' => $this->getUser(),
        );
        return $renderer->renderModal($file, $arguments);
    }
    
    protected function redirectTo($path)
    {
        session_write_close();
        header('Location: ' . $this->generateUrl($path));
        return null;
    }
    
    private function getDatabase()
    {
        $setup = include 'config/setup.php';
        $db = $setup['database'];
        try {
            return new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['name'], $db['user'], $db['password']);
        } catch(PDOException $e) {
            throw new Exception('Impossible de se connecter à la base de données');
        }
    }
    
    protected function execute($query, $parameters = array())
    {
        if($this->database === null) {
            $this->database = $this->getDatabase();
        }
        
        $statement = $this->database->prepare($query);
        return $statement->execute($parameters);
    }
    
    public function query($query, $parameters = array())
    {
        if($this->database === null) {
            $this->database = $this->getDatabase();
        }
        
        $statement = $this->database->prepare($query);
        $statement->execute($parameters);
        return $statement->fetchAll();
    }
    
    public function querySingle($query, $parameters = array())
    {
        $result = $this->query($query, $parameters);
        
        return isset($result[0]) ? $result[0] : null;
    }
    
    public function querySingleScalar($query, $parameters = array())
    {
        $result = $this->query($query, $parameters);
        
        return isset($result[0][0]) ? $result[0][0] : null;
    }
    
    public function getDatabaseVersion()
    {
        return $this->database->getAttribute(PDO::ATTR_SERVER_VERSION);
    }
    
    
    private function _mapUpdate($key) {
        return $key . ' = ?';
    }
    
    private function _mapInsert() {
        return '?';
    }
    
    protected function insert($table, $values)
    {
        $result = $this->execute('INSERT INTO ' . $table . '(' . implode(', ', array_keys($values)) . ') VALUES (' . implode(', ', array_map(array($this, '_mapInsert'), $values)) . ')', array_values($values));
        
        if($result) {
            return $this->database->lastInsertId();
        }
        
        return false;
    }
    
    protected function update($table, $id, $values)
    {
        return $this->execute('UPDATE ' . $table . ' SET ' . implode(', ', array_map(array($this, '_mapUpdate'), array_keys($values))) . ' WHERE id = ?', array_merge(array_values($values), array($id)));
    }
    
    
    protected function delete($table, $values)
    {
        return $this->execute('DELETE FROM ' . $table . ' WHERE ' . implode(', ', array_map(array($this, '_mapUpdate'), array_keys($values))), array_values($values));
    }
    
    public function getUser()
    {
        if($this->user === null && isset($_SESSION['auth_user'])) {
            $this->user = $this->querySingle('SELECT * FROM users WHERE id = ?', array((int)$_SESSION['auth_user']));
        }
        
        return $this->user;
    }
    
    protected function flash($message, $level = 'info')
    {
        if(!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = array();
        }
        $_SESSION['flash'][] = array('level' => $level, 'message' => $message);
    }
    
    public function getFlash()
    {
        if(!isset($_SESSION['flash'])) {
            return array();
        }
        $flash = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flash;
    }
    
    public function isGranted($user, $role)
    {
        if($this->authorization === null) {
            $this->authorization = new Authorization();
        }
        
        return $this->authorization->isGranted($user, $role);
    }
    
    protected function denyAccess()
    {
        header('X-PHP-Response-Code: 403', true, 403);
        return $this->render('helper/403.php');
    }
    
    protected function denyAccessUnlessGranted($user, $role)
    {
        if(!$this->isGranted($user, $role)) {
            // header('X-PHP-Response-Code: 403', true, 403);
            throw new \Exception('Désolé, l\'accès à cette page est interdit !');
        }
    }
    
    protected function getDefaultConfig()
    {
        return include 'config/config.php';
    }
    
    public function getConfig($key, $override = array())
    {
        if(isset($override[$key])) {
            return $override[$key];
        }
        
        $value = $this->querySingleScalar('SELECT value FROM config WHERE identifier = ? LIMIT 0, 1', array($key));
        
        if($value !== null) {
            return json_decode($value);
        }
        
        $defaultConfig = $this->getDefaultConfig();
        return $defaultConfig[$key];;
    }
    
    protected function setConfig($key, $value)
    {
        $this->delete('config', array('identifier' => $key));
        $this->insert('config', array('identifier' => $key, 'value' => json_encode($value)));
    }
}
