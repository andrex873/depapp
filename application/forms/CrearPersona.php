<?php

class Application_Form_CrearPersona extends Zend_Form {

    private $cargos = array();
    
    private $tipoContratos = array();
    
    public function init() {

        $this->setMethod('post')
                ->setAction('/personas/crear');
        
        $this->initData();
        $this->initElements();
    }    

    private function initElements() {
        $tipoDocumento = new Zend_Form_Element_Select('tipoDocumento');
        $tipoDocumento
                ->setMultiOptions(fnTiposIdentificacion())
                ->setLabel('Tipo Documento')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2'
                ));
        $this->addElement($tipoDocumento);

        $numeroDocumento = new Zend_Form_Element_Text('numeroDocumento');
        $numeroDocumento
                ->setLabel('Número Documento')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2',
                    'required' => 'required'
                ));
        $this->addElement($numeroDocumento);
        
        $primerNombre = new Zend_Form_Element_Text('primerNombre');
        $primerNombre
                ->setLabel('Primer Nombre')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span3',
                    'required' => 'required'
                ));
        $this->addElement($primerNombre);
        
        $segundoNombre = new Zend_Form_Element_Text('segundoNombre');
        $segundoNombre
                ->setLabel('Segundo Nombre')                
                ->setAttribs(array(
                    'class' => 'span3',                    
                ));
        $this->addElement($segundoNombre);
        
        $primerApellido = new Zend_Form_Element_Text('primerApellido');
        $primerApellido
                ->setLabel('Primer Apellido')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span3',
                    'required' => 'required'
                ));
        $this->addElement($primerApellido);
        
        $segundoApellido = new Zend_Form_Element_Text('segundoApellido');
        $segundoApellido
                ->setLabel('Segundo Apellido')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span3',
                    'required' => 'required'
                ));
        $this->addElement($segundoApellido);

        $fechaNacimiento = new Zend_Form_Element_Text('fechaNacimiento');
        $fechaNacimiento                
                ->setLabel('Fecha Nacimiento')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2',
                    'data-type' => 'dateCalendar',
                    'required' => 'required'
                ));                
        $this->addElement($fechaNacimiento);

        $estado = new Zend_Form_Element_Select('estado');
        $estado
                ->setMultiOptions(fnEstadosPersonas())
                ->setLabel('Estado')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2'
                ));
        $this->addElement($estado);
        
        $fechaIngreso = new Zend_Form_Element_Text('fechaIngreso');
        $fechaIngreso                
                ->setLabel('Fecha Ingreso')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2',
                    'data-type' => 'dateCalendar',
                    'required' => 'required'
                ));
        $this->addElement($fechaIngreso);
        
        $fechaRetiro = new Zend_Form_Element_Text('fechaRetiro');
        $fechaRetiro                
                ->setLabel('Fecha Retiro')                
                ->setAttribs(array(
                    'class' => 'span2',
                    'data-type' => 'dateCalendar'                  
                ));
        $this->addElement($fechaRetiro);
        
        $salario = new Zend_Form_Element_Text('salario');
        $salario
                ->setLabel('Salario')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2',
                    'required' => 'required'
                ));
        $this->addElement($salario);
        
        $idCargo = new Zend_Form_Element_Select('idCargo');
        $idCargo
                ->setMultiOptions($this->cargos)
                ->setLabel('Cargo')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span2'
                ));
        $this->addElement($idCargo);
        
        $idTipoContrato = new Zend_Form_Element_Select('idTipoContrato');
        $idTipoContrato
                ->setMultiOptions($this->tipoContratos)
                ->setLabel('Tipo Contrato')
                ->setRequired()
                ->setAttribs(array(
                    'class' => 'span3'
                ));
        $this->addElement($idTipoContrato);        
        
        $grabar = new Zend_Form_Element_Submit('grabar');
        $grabar
                ->setLabel('Grabar')
                ->setAttribs(array(
                    'class' => 'btn btn-primary app-btn-form'
                ));
        $this->addElement($grabar);
        
        $limpiar = new Zend_Form_Element_Reset('limpiar');
        $limpiar
                ->setLabel('Limpiar')
                ->setAttribs(array(
                    'class' => 'btn app-btn-form'
                ));
        $this->addElement($limpiar);
    }
    
    private function initData() {
        // Obtener de la base de datos los cargos.
        $tCargos = new Application_Model_Cargos();
        $cargos = $tCargos->fetchAll("estadoCargo = 'ACT'")->toArray();
        foreach ($cargos as $clave => $valor) {
            $this->cargos[$valor['idCargo']] = $valor['nombreCargo'];
        }
        // Obtener de la base de datos los tipos de contrato.
        $tTipoContratos = new Application_Model_TipoContratos();
        $tipoContratos = $tTipoContratos->fetchAll("estadoTipoContrato = 'ACT'")->toArray();
        foreach ($tipoContratos as $clave => $valor) {
            $this->tipoContratos[$valor['idTipoContrato']] = $valor['nombreTipoContrato'];
        }
    }
}
