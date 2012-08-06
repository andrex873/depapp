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
                    $htmlError .= "<li>{$mensaje['msg']}</li>";
                }else{
                    $htmlSusess .= "<li>{$mensaje['msg']}</li>";
                }                
            }
            $html .= "<div class='alert alert-error msgError'><ul>".$htmlError."</ul></div>";
            $html .= "<div class='alert alert-success msgError'><ul>".$htmlSusess."</ul></div>";
        }
        $respuesta = array('html' => $html, 'count' => count($mensajes));
        return $respuesta; 
    }
}

?>
