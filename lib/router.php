<?php

class Router
{
    public function generateUrl($route, $arguments = array())
    {
        $url = $route;
        
        $_arguments = array();
        foreach($arguments as $key => $value) {
            $_arguments[] = $key . '=' . $value;
        }
        if(!empty($arguments)) {
            $url .= '?' . implode('&', $_arguments);
        }
        
        return $url;
    }
}
