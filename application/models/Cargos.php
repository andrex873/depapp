<?php

class Application_Model_Cargos extends Zend_Db_Table_Abstract
{
    protected $_name = 't_cargos';
    protected $_primary = 'idCargo';        
    
    /**
     * Metodo que obtiene todos los registros de la tabla y los retorna en parejas clave-valor.
     * @param String $estado Estado de los registros que se quieren obtener, por defecto trae los ACT.
     * @return Array Array con los registros de la tabla. 
     */
    public function getAllClaveValor($estado = 'ACT') {
        $cargos = array();
        $filas = $this->fetchAll("estadoCargo = '{$estado}'");
        foreach ($filas as $cargo) {
            $cargos[$cargo->idCargo] = $cargo->nombreCargo;
        }
        return $cargos;
    }
}

