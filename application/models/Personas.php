<?php

class Application_Model_Personas extends Zend_Db_Table_Abstract
{
    protected $_name = 't_personas';
    protected $_primary = 'idPersona';
    
    public function getCertificacionLaboralInformacion($tipoDocumento, $numeroDocumento) {
        $db = $this->getAdapter();                
        $sql = "SELECT p.idPersona, p.tipoDocumento, p.numeroDocumento, p.primerNombre, p.segundoNombre, p.primerApellido, p.segundoApellido, p.salario, p.fechaIngreso
                    , c.idCargo, c.nombreCargo 
                    , tc.idTipoContrato, tc.nombreTipoContrato
                FROM t_personas p
                JOIN t_cargos c ON p.idCargo = c.idCargo
                JOIN t_tipo_contratos tc ON p.idTipoContrato = tc.idTipoContrato
                WHERE 1
                AND p.tipoDocumento = '{$tipoDocumento}'
                AND p.numeroDocumento = '{$numeroDocumento}'";                        
        $filaPersona = $db->fetchRow($sql);                
        return $filaPersona;
    }

}

