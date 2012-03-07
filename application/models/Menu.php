<?php

class Application_Model_Menu extends Zend_Db_Table_Abstract
{
    protected $_name = 't_menu';
    protected $_primary = 'idMenu';         
    
    
    function getMenu($idPerfil){
        $db = $this->getAdapter();        
        $sql = "SELECT m.idMenu, m.idPadre, m.nombre, m.ruta, m.orden, mp.idPerfil, m.icon 
                FROM t_menu m
                LEFT JOIN t_menu_perfil mp ON m.idMenu = mp.idMenu
                WHERE 1
                AND mp.idPerfil = '{$idPerfil}'
                ORDER BY m.orden";       
       $dMenu = $db->fetchAll($sql);         
       return $dMenu;                 
    }
}

