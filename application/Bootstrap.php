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
        return Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');
        //Zend_Controller_Action_HelperBroker::addPrefix("Application_Controller_Helper");
    }

}

