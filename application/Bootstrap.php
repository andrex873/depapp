<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initLoadSession(){ 
        $session = new Zend_Session_Namespace('global');                        
        if(isset($session->logueado)){ 
        }
    }

}

