<?php

class Zend_View_Helper_CssDinamicoHelper extends Zend_View_Helper_Abstract
{            
    /**
     * Helper que permite cargar dinamicamente los archivos de estilos css según el Controller y View.
     * @return String Retorna una etiqueta link con el css si existe, de lo contrario retorna una cadena vacia. 
     */
    function cssDinamicoHelper() {
                
        $request    = Zend_Controller_Front::getInstance()->getRequest(); 
        $module     = $request->getModuleName(); 
        $controller = $request->getControllerName(); 
        $view       = $request->getActionName(); 
                
        $rutaBase   = APPLICATION_PATH . "/../public";
        $archivo    = "/css/scripts/{$controller}_{$view}.css";        
        $rutaTotal  = $rutaBase . $archivo;        
        $str = "";
        if(file_exists($rutaTotal)){
            $str = "<link type='text/css' rel='stylesheet' href='{$archivo}'>";
        }                
        return $str; 
    }
}

?>
