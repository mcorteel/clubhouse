<?php

include_once 'controller.php';

class ErrorController extends Controller
{
    public function notfound()
    {
        return $this->render('error/404.php', array(
            
        ));
    }
}
