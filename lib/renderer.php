<?php

include_once 'router.php';
include_once 'authorization.php';

class Renderer
{
    public function __construct()
    {
        $this->router = new Router();
        $this->authorization = new Authorization();
    }
    
    public function render($file, $arguments)
    {
        // NOTE This is relative to the front controller
        $_file = 'templates/' . $file;
        
        if(!is_file($_file)) {
            return '<h1 class="text-danger">ERROR</h1><p>Template ' . $file . ' does not exist.</p>';
        }
        
        foreach($arguments as $key => $value) {
            ${$key} = $value;
        }
        
        ob_start();
        
        include $_file;
        
        return ob_get_clean();
    }
    
    public function renderModal($file, $arguments)
    {
        // NOTE This is relative to the front controller
        $_file = 'templates/' . $file;
        
        if(!is_file($_file)) {
            return '<h1 class="text-danger">ERROR</h1><p>Template ' . $file . ' does not exist.</p>';
        }
        
        foreach($arguments as $key => $value) {
            ${$key} = $value;
        }
        
        ob_start();
        
        include $_file;
        
        echo ob_get_clean();
        
        exit;
    }
    
    protected function pagination($path, $pagination)
    {
        $pagination['path'] = $path;
        
        return $this->render('helper/pagination.php', $pagination);
    }
    
    protected function path($route, $arguments = array())
    {
        return $this->router->generateUrl($route, $arguments);
    }
    
    protected function isGranted($user, $role)
    {
        return $this->authorization->isGranted($user, $role);
    }
    
    protected function date($date, $includeTime = false)
    {
        $date = new DateTime($date);
        if($includeTime) {
            return $date->format('d/m/Y à H\hi');
        } else {
            return $date->format('d/m/Y');
        }
    }
}
