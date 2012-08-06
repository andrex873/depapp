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
            !empty($htmlError)? $html .= "<div class='alert alert-error alert-margin'><ul class='app-no-margin'>".$htmlError."</ul></div>": false;
            !empty($htmlSusess)? $html .= "<div class='alert alert-success alert-margin'><ul class='app-no-margin'>".$htmlSusess."</ul></div>": false;            
        }
        $respuesta = array('html' => $html, 'count' => count($mensajes));
        return $respuesta; 
    }
}

?>
