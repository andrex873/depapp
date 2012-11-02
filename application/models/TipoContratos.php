<?php

class Application_Model_TipoContratos extends Zend_Db_Table_Abstract
{
    protected $_name = 't_tipo_contratos';
    protected $_primary = 'idTipoContrato';        
    
    /**
     * Metodo que obtiene todos los registros de la tabla y los retorna en parejas clave-valor.
     * @param String $estado Estado de los registros que se quieren obtener, por defecto trae los ACT.
     * @return Array Array con los registros de la tabla.  
     */
    public function getAllClaveValor($estado = 'ACT') {
        $tipoContratos = array();
        $filas = $this->fetchAll("estadoTipoContrato = '{$estado}'");
        foreach ($filas as $tipoContrato) {
            $tipoContratos[$tipoContrato->idTipoContrato] = $tipoContrato->nombreTipoContrato;
        }
        return $tipoContratos;
    }
}

