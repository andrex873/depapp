<?php

class Zend_View_Helper_JavascriptDinamicoHelper extends Zend_View_Helper_Abstract
{            
    /**
     * Helper que permite cargar dinamicamente los archivos javascript según el Controller y View.
     * @return String Retorna una etiqueta script, de lo contrario retorna una cadena vacia. 
     */
    function javascriptDinamicoHelper() {
                
        $request    = Zend_Controller_Front::getInstance()->getRequest(); 
        $module     = $request->getModuleName(); 
        $controller = $request->getControllerName(); 
        $view       = $request->getActionName(); 
        
        $rutaBase   = APPLICATION_PATH . "/../public";
        $archivo    = "/js/scripts/{$controller}_{$view}.js"; 
        $rutaTotal  = $rutaBase . $archivo;
        $str = "";
        if(file_exists($rutaTotal)){
            $str = "<script type='text/javascript'>
                        $(document).on('ready', function(){
                            var script = document.createElement('script');
                            script.type = 'text/javascript';
                            script.src = '{$archivo}';
                            document.getElementsByTagName('head')[0].appendChild(script); 
                        });
                    </script>";
        } 
        return $str; 
    }
}

?>
