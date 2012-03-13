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

}

