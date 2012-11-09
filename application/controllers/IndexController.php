<?php

class IndexController extends Zend_Controller_Action
{
    
    const PATH_INDEX = '/index';

    private $session = null;

    public function init()
    {
        $this->session = new Zend_Session_Namespace(NS_SESSION);        
    }

    public function indexAction()
    {
        $this->_forward("login");
    }

    public function loginAction()
    {                
        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect("/index/inicio");
        }
        $this->view->error = false;
        $form = new Application_Form_Login();                
        if ($this->getRequest()->isPost()) {                        
            $post = $this->getRequest()->getPost();             
            if($form->isValid($post)){
                $auAdapter = new Zend_Auth_Adapter_DbTable();
                $auAdapter->setTableName('t_usuarios')
                        ->setIdentityColumn('nombreUsuario')
                        ->setCredentialColumn('clave');

                $auAdapter->setIdentity($post['nombreusuario'])
                        ->setCredential(md5($post['claveusuario']));
                $auInstance = Zend_Auth::getInstance();
                $resultado = $auInstance->authenticate($auAdapter);                        

                if ($resultado->isValid()) {
                    $usuario = $auAdapter->getResultRowObject(null, 'clave');

                    $tPersona = new Application_Model_Personas();
                    $persona = $tPersona->fetchRow("idPersona = '".$usuario->idPersona."'");                

                    $this->session->usuario = $usuario;                 
                    $this->session->persona = $persona;                                                 

                    $this->_redirect("/index/inicio");
                } else {
                    $this->view->error = true;
                    $this->view->mensaje = "Error en el nombre de Usuario o Clave, por favor verifique.";                
                }
            }else{            
                $this->view->error = true;
                $this->view->mensaje = "Error en los datos de ingreso, los campos no pueden estar vacios.";                 
            }        
        }
        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy(true);
        return $this->_redirect('/'); 
    }

    public function inicioAction()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            return $this->_redirect('/'); 
        }
        $t_menu = new Application_Model_Menu();
        $dMenu = $t_menu->getMenuByIdPadre(0)->toArray();
        $this->view->dMenu = $dMenu;                         
    }
}


