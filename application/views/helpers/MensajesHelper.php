<?php

class Zend_View_Helper_MensajesHelper extends Zend_View_Helper_Abstract
{            

    function mensajesHelper() {
                        
        $mensajes = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();        
        $mensajes = $mensajes? $mensajes: '';
        return $mensajes; 
    }
}

?>
