<?php

/**
 * Description of Mensajes
 *
 * @author amendez
 */
class Zend_Controller_Action_Helper_Mensajes extends Zend_Controller_Action_Helper_Abstract
{
        
    function direct($tipo, $mensaje)
    {        
        return $this->setMensaje($tipo, $mensaje);
    }
    
    public function setMensaje($tipo, $mensaje) {
        $session = new Zend_Session_Namespace(NS_SESSION);        
        $session->MENSAJES[] = array(
            'status' => $tipo,
            'msg' => $mensaje
            );        
    }
    
    public function getMensajes($limpiar = TRUE) {
        $session = new Zend_Session_Namespace(NS_SESSION);                        
        $mensajes = $session->MENSAJES;
        if($limpiar)
            $session->MENSAJES = array();
        return $mensajes;
    }
}