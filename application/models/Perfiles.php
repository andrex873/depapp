<?php

class Application_Model_Perfiles  extends Zend_Db_Table_Abstract
{
    
    protected $_name = 't_perfiles';
    protected $_primary = 'idPerfil';
    
    /**
     * Constante que identifica el id del perfil Administrador. 
     */
    const ADM = 1;
    
    /**
     * Constante que identifica el id del perfil Consulta.  
     */
    const CON = 2;
    
    /**
     * Constante que identifica el id del perfil Coordinador. 
     */
    const COO = 3;
        
}

