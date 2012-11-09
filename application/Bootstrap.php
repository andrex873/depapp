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
        
    protected function _initCargarConfiguracion()
    {           
        $configuracionApp = new Zend_Config_Ini(APPLICATION_PATH . "/configs/global-config.ini", 'general');
        Zend_Registry::set("configuracionApp", $configuracionApp);                            
        
        date_default_timezone_set($configuracionApp->TIMEZONE);
        setlocale(LC_ALL, $configuracionApp->LOCALE);        
        defined('__CRYP_KEY__')
            || define('__CRYP_KEY__', $configuracionApp->ENCRIPTAR_KEY);        
    }
    
    protected function _initSessionTimeOut()
    {           
        if(Zend_Auth::getInstance()->hasIdentity()){
            $authSession = new Zend_Session_Namespace('Zend_Auth');
            // La Sesion expira a los 5 minutos.
            $authSession->setExpirationSeconds(5*60);
        }
    }

}
