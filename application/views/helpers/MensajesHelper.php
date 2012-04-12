<?php

class Zend_View_Helper_MensajesHelper extends Zend_View_Helper_Abstract
{            

    function mensajesHelper() {                        
        $html = "";
        $mensajes = $this->view->mensajes;
        if($mensajes){            
            $htmlError = "";
            $htmlSusess = "";
            foreach ($mensajes as $key => $mensaje) {
                if( strtolower($mensaje['status']) == 'e'){
                    $htmlError .= "<li class='m-error'>{$mensaje['msg']}</li>";
                }else{
                    $htmlSusess .= "<li class='m-exito'>{$mensaje['msg']}</li>";
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
