<?php

class PersonasController extends Zend_Controller_Action {

    public function init() {
        //$this->_redirect("/");
    }

    public function indexAction() {
        $tPersonas = new Application_Model_Personas();
        $personas = $tPersonas->fetchAll()->toArray();
        $this->view->personas = $personas;
    }

    public function crearAction() {
        $form = new Application_Form_CrearPersona();
        if ($this->getRequest()->ispost()) {
            $post = $this->getRequest()->getPost();
            if ($form->isValid($post)) {
                $tPersonas = new Application_Model_Personas();
                $persona = $tPersonas->fetchRow("tipoDocumento = '{$post['tipoDocumento']}' AND numeroDocumento = '{$post['numeroDocumento']}' ");
                if ($persona == null) {
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
                        $this->_redirect('/personas/');
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

    public function eliminarAction() {
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $tPersonas = new Application_Model_Personas();
            $persona = $tPersonas->fetchRow("idPersona = '{$id}' ");
            if ($persona) {
                if ($persona->delete()) {
                    $this->_helper->mensajes('S', "Persona eliminada correctamente.");
                } else {
                    $this->_helper->mensajes('E', "Error eliminando la persona.");
                }
            } else {
                $this->_helper->mensajes('E', "La persona que intenta borrar no existe.");
            }
        } else {
            $this->_helper->mensajes('E', "Error recuperando los parametros.");
        }
        $this->_redirect('/personas/');
    }

}

