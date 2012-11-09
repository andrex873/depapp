<?php

class PersonasController extends Zend_Controller_Action {

    const PATH_INDEX = '/personas';

    public function init() {
        //$this->_redirect("/");
    }

    public function indexAction() {
        $tPersonas = new Application_Model_Personas();
        $personas = $tPersonas->fetchAll(null, null, 20)->toArray();
        $this->view->personas = $personas;
    }

    public function crearAction() {
        $form = new Application_Form_CrearPersona();
        if ($this->getRequest()->ispost()) {
            $post = $this->getRequest()->getPost();
            if ($form->isValid($post)) {
                $tPersonas = new Application_Model_Personas();
                if (!$tPersonas->existeIdentificacion($post['tipoDocumento'], $post['numeroDocumento'])) {
                    $data = array(
                        'idCargo' => $post['idCargo'],
                        'idTipoContrato' => $post['idTipoContrato'],
                        'tipoDocumento' => $post['tipoDocumento'],
                        'numeroDocumento' => $post['numeroDocumento'],
                        'primerNombre' => $post['primerNombre'],
                        'segundoNombre' => $post['segundoNombre'],
                        'primerApellido' => $post['primerApellido'],
                        'segundoApellido' => $post['segundoApellido'],
                        'estado' => $post['estado'],
                        'fechaNacimiento' => fn2yyyymmdd($post['fechaNacimiento']),
                        'fechaIngreso' => fn2yyyymmdd($post['fechaIngreso']),
                        'salario' => $post['salario'],
                        'fechaRetiro' => fn2yyyymmdd($post['fechaRetiro'])
                    );
                    if ($tPersonas->insert($data)) {
                        $this->_helper->mensajes('S', "Los datos fueron ingresados correctamente.");
                        $this->_redirect(self::PATH_INDEX);
                    } else {
                        $this->_helper->mensajes('S', "No fue posible guardar los datos.");
                    }
                } else {
                    $this->_helper->mensajes('E', "El tipo y número de documento ya existen.");
                }
            } else {
                $this->_helper->mensajes('E', "Error en los datos del formulario.");
            }
        }
        $this->view->form = $form;
    }

    public function modificarAction() {
        // Se obtiene el parametro uk (Unique Key).
        $id = $this->getRequest()->getParam('uk');
        // Validar que el contenido del $id.
        if (empty($id)) {
            $this->_helper->mensajes('E', "Error recuperando los parametros de modificación.");
            return $this->_redirect(self::PATH_INDEX);
        }
        // Se des encripta el valor para obtener el id.
        $id = fnDesEncriptar($id, __CRYP_KEY__);
        $tPersonas = new Application_Model_Personas();
        $form = new Application_Form_CrearPersona();
        $persona = $tPersonas->fetchRow("idPersona = '{$id}' ");
        if ($persona == null) {
            $this->_helper->mensajes('E', "La persona que intenta modificar no existe.");
            return $this->_redirect(self::PATH_INDEX);
        }
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if ($form->isValid($post)) {
                $data = $form->getValues();
                $data['fechaNacimiento'] = fn2yyyymmdd($data['fechaNacimiento']);
                $data['fechaIngreso'] = fn2yyyymmdd($data['fechaIngreso']);
                $data['fechaRetiro'] = fn2yyyymmdd($data['fechaRetiro']);
                $persona->setFromArray($data);
                if($persona->save()){
                    $this->_helper->mensajes('S', "La persona se ha modificado exitosamente.");
                } else {
                    $this->_helper->mensajes('E', "No se pudo modificar la persona.");
                }
            } else {
                $this->_helper->mensajes('E', "Error en los datos del formulario.");
            }
        } else {
            $personaInfo = $persona->toArray();
            $personaInfo['fechaNacimiento'] = fn2ddmmyyyy($personaInfo['fechaNacimiento']);
            $personaInfo['fechaIngreso'] = fn2ddmmyyyy($personaInfo['fechaIngreso']);
            $personaInfo['fechaRetiro'] = fn2ddmmyyyy($personaInfo['fechaRetiro']);
            $form->setDefaults($personaInfo);
        }
        $this->view->id = $id;
        $this->view->form = $form;
    }

    public function eliminarAction() {
        // Se obtiene el parametro uk (Unique Key).
        $id = $this->getRequest()->getParam('uk');
        if (!empty($id)) {
            // Se des encripta el valor para obtener el id.
            $id = fnDesEncriptar($id, __CRYP_KEY__);
            $tPersonas = new Application_Model_Personas();
            $persona = $tPersonas->fetchRow("idPersona = '{$id}' ");
            if ($persona) {
                if ($persona->delete()) {
                    $this->_helper->mensajes('S', "La persona fue eliminada correctamente.");
                } else {
                    $this->_helper->mensajes('E', "No fue posible eliminar la persona.");
                }
            } else {
                $this->_helper->mensajes('E', "La persona que intenta borrar no existe.");
            }
        } else {
            $this->_helper->mensajes('E', "Error recuperando los parametros.");
        }
        $this->_redirect(self::PATH_INDEX);
    }

}

