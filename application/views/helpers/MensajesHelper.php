<?php

class Zend_View_Helper_MensajesHelper extends Zend_View_Helper_Abstract
{            

    function mensajesHelper() {
                        
//        $mensajes = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger')->getMessages();        
//        $mensajes = $mensajes? $mensajes: '';
        $html = "";
        $mensajes = $this->view->mensajes;
        if($mensajes){            
            $htmlError = "";
            $htmlSusess = "";
            foreach ($mensajes as $key => $mensaje) {
                if( strtolower($mensaje['status']) == 'e'){
                    $htmlError .= "<li class='mensaje-e'>{$mensaje['msg']}</li>";
                }else{
                    $htmlSusess .= "<li class='mensaje-s'>{$mensaje['msg']}</li>";
                }                
            }
            $html .= '<ul id="mesajes_global">';
            $html .= $htmlSusess.$htmlError;
            $html .= "</ul>";
        }
        $res = Array('html' => $html, 'count' => count($mensajes) );
        return $res; 
    }
}

?>
