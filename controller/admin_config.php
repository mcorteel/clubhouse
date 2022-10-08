<?php

include_once 'controller.php';

class AdminConfigController extends Controller
{
    public function index()
    {
        if(!$this->isGranted($user = $this->getUser(), 'admin')) {
            return $this->redirectTo('/actualites');
        }
        
        $configs = isset($_POST['config']) ? $_POST['config'] : array();
        foreach($configs as $key => $value) {
            $this->setConfig($key, $value);
        }
        
        $config = array();
        foreach($this->getDefaultConfig() as $key => $defaultValue) {
            $config[$key] = $this->getConfig($key, $defaultValue);
        }
        
        return $this->render('admin/config/index.php', array(
            'config' => $config,
        ));
    }
}
