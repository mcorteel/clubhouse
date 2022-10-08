<?php

include_once 'controller.php';

class AdminConfigController extends Controller
{
    public function index()
    {
        $this->denyAccessUnlessGranted($user = $this->getUser(), 'admin');
        
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
