<?php
class Zend_View_Helper_MenuHelper extends Zend_View_Helper_Abstract
{
    function menuHelper() {
        
        $sesion = new Zend_Session_Namespace(NS_SESSION);        
        // Cache del menu para no consultarlo cada vez q se actualiza la pagina
        if(isset($sesion->htmlMenu)){
            return $sesion->htmlMenu;
        }                        
        $usuario = $sesion->usuario;
        $idPerfil = $usuario->idPerfil; 
        
        $tMenu = new Application_Model_Menu();
        $dMenu = $tMenu->getMenu($idPerfil);                 
        $gMenu = array();
        foreach($dMenu as $key => $value){
            $gMenu[$value['idPadre']][] = $value;
        } 
        $html = $this->getHtmlMenu($gMenu); 
        $sesion->htmlMenu = $html;
        return $html;
    }        

    private function getHtmlMenu($gMenu, $idPadre = 0) {
        $html = "";
        $gPadre = $gMenu[$idPadre];
        $html .= "<ul>";
        foreach($gPadre as $key => $value){                                    
            $html .= "<li>";            
            $html .= "<a href='{$value['ruta']}'>{$value['nombre']}</a>";
            if( count($gMenu[$value['idMenu']]) > 0 ){
                $html .= $this->getHtmlMenu($gMenu, $value['idMenu']);
            }
            $html .= "</li>";
        }
        $html .= "</ul>";
        return $html;
    }
    
    private function getArrayMenu(){
        
    }
}
?>