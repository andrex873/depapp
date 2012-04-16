<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initDatabase()
    {
        $this->bootstrap("db");
        $db = $this->getResource("db");        
        Zend_Registry::set("db", $db);
        return $db;
    }       
    
    protected function _initRutahelpers()
    {        
        return Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/controllers/helpers');        
    }
    
    protected function _initLayout()
    { 
        Zend_Layout::startMvc(array("layoutPath"=> APPLICATION_PATH . "/layouts/scripts/"));
        $layout = Zend_Layout::getMvcInstance();                        
        if(Zend_Auth::getInstance()->hasIdentity()){
            $layout->setLayout("appiclation");
        }else{ 
            $layout->setLayout("layout");            
        }
    }
    
    protected function _initVerificarPermisos()
    { 
        
    }
    
    protected function _initCargarFunciones()
    {
        Zend_Loader::loadFile('funciones.php', APPLICATION_PATH . '/../library/util');
    }
    
    protected function _initConfiguracionRegional()
    {        
        $var = setlocale(LC_ALL, "es_ES.ISO_8859-1");
        date_default_timezone_set('America/Bogota');
    }
    
    protected function _initCargarConfiguracion()
    {           
        $configuracionPersonal = new Zend_Config_Ini(APPLICATION_PATH . "/configs/config-custom.ini", 'general');
        Zend_Registry::set("configuracionPersonal", $configuracionPersonal);                            
    }

}
