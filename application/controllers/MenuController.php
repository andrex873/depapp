<?php

class MenuController extends Zend_Controller_Action
{

    public function init()
    {        
    }

    public function indexAction()
    {
        $sesion = new Zend_Session_Namespace(NS_SESSION);                
        // Cache del menu para no consultarlo cada vez q se actualiza la pagina
        if(isset($sesion->menuAgrupado)){
            $this->_helper->json->sendJson($sesion->menuAgrupado);
        } 
        $idPerfil = $sesion->usuario->idPerfil;                 
        $tMenu = new Application_Model_Menu();
        $dMenu = $tMenu->getMenu($idPerfil);                 
        $gMenu = array();
        foreach($dMenu as $key => $value){
            $gMenu[$value['idPadre']][] = $value;
        }                                 
        $sesion->menuAgrupado = $gMenu;
        $this->_helper->json->sendJson($gMenu);    
    }
    
    /*
     * Formas de generar el Menu recorriendolo de forma dinamica
     * 
    private function getArrayMenu($gMenu, $idPadre = 0){
        $menu = Array();
        $gPadre = $gMenu[$idPadre];
        foreach($gPadre as $key => $value){                                    
            $obj = new stdClass();
            $obj->text = $value['nombre'];
            $obj->ruta = $value['ruta'];            
            if( count($gMenu[$value['idMenu']]) > 0 ){                
                $obj->menu = $this->getArrayMenu($gMenu, $value['idMenu']);                
            }            
            $menu[] = $obj;
        }
        return $menu;
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
    
    */

}

