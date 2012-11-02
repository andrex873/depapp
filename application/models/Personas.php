<?php

class Application_Model_Personas extends Zend_Db_Table_Abstract
{
    protected $_name = 't_personas';
    protected $_primary = 'idPersona';
    
    /**
     * Método que obtiene los datos necesarios para generar una certificación laboral.
     * @param String $tipoDocumento Tipo de identificación de la persona a la cual se le genera la certificación.
     * @param Integer $numeroDocumento Número de identificación de la persona a la cual se le genera la certificación.
     * @return Array Con los datos consultados en la base de datos.
     */
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
    
    /**
     * Método encargado de verificar la existencia de una persona filtrando por el tipo y número de identificación.
     * @param String $tipoDocumento Tipo de documento a verificar.
     * @param Int $numeroDocumento Número de documento a verificar.
     * @return boolean <b>TRUE</b> en caso que se encuentre el registro o <b>FALSE</b> en cualquier otro caso.
     */
    public function existeIdentificacion($tipoDocumento, $numeroDocumento){
        $return = false;
        $row = $this->fetchRow("tipoDocumento = '{$tipoDocumento}' AND numeroDocumento = '{$numeroDocumento}' ");
        if($row != null){
            $return = true;
        }
        return $return;
    }

}

