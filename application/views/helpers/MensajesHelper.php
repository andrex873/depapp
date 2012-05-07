<?php

class Zend_View_Helper_MensajesHelper extends Zend_View_Helper_Abstract
{            

    function mensajesHelper() {                        
        $html = "";
        $obj = Zend_Controller_Action_HelperBroker::getStaticHelper('mensajes');        
        $mensajes = $obj->getMensajes();
        
        //$mensajes = $this->view->mensajes;
        if($mensajes){            
            $htmlError = "";
            $htmlSusess = "";
            foreach ($mensajes as $key => $mensaje) {
                if( strtolower($mensaje['status']) == 'e'){
                    $htmlError .= "<li class='mError'>{$mensaje['msg']}</li>";
                }else{
                    $htmlSusess .= "<li class='mExito'>{$mensaje['msg']}</li>";
                }                
            }
            $html .= "<ul id='list_mensajes'>";
            $html .= $htmlSusess.$htmlError;
            $html .= "</ul>";
        }
        $respuesta = array('html' => $html, 'count' => count($mensajes));
        return $respuesta; 
    }
}

?>
