<?php

/**
 * Description of SesionActual
 *
 * @author amendez
 */
class Zend_Controller_Action_Helper_SesionActual extends Zend_Controller_Action_Helper_Abstract
{
        
    function direct($key)
    {        
        return $this->getValor($key);
    }
    
    public function getValor($key) {
        $session = new Zend_Session_Namespace(NS_SESSION);        
        return $session->$key;        
    }
    
    public function setValor($key, $value) {
        if(empty($key)){
            return;
        }
        $session = new Zend_Session_Namespace(NS_SESSION);                        
        $session->$key = $value;        
    }
}

