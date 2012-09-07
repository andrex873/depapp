<?php

class PersonasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $tPersonas = new Application_Model_Personas();
        $personas = $tPersonas->fetchAll()->toArray();        
        $this->view->personas = $personas;
    }

    public function crearAction()
    {
        $form = new Application_Form_CrearPersona();
        
        if($this->getRequest()->ispost()){
            $post = $this->getRequest()->getPost();
            if($form->isValid($post)){
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
                $tPersonas = new Application_Model_Personas();
                if($tPersonas->insert($data)){
                    $this->_helper->mensajes('S', "Los datos fueron ingresados correctamente.");
                }else{
                    $this->_helper->mensajes('S', "No fue posible guardar los datos.");
                }
            }else{
                $this->_helper->mensajes('E', "Error en los datos del formulario.");
            }
        }
        $this->view->form = $form;
    }

    public function eliminarAction()
    {
        // action body
    }


}





