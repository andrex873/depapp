<?php

class IndexController extends Zend_Controller_Action
{

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
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();            
            $auAdapter = new Zend_Auth_Adapter_DbTable();
            $auAdapter->setTableName('t_usuarios')
                    ->setIdentityColumn('nombreUsuario')
                    ->setCredentialColumn('clave');

            $auAdapter->setIdentity($post['in_user'])
                    ->setCredential(md5($post['in_pass']));
            $autenticacion = Zend_Auth::getInstance();
            $res = $autenticacion->authenticate($auAdapter);                        
            
            if ($res->isValid()) {
                $usuario = $auAdapter->getResultRowObject(null, 'clave');
                
                $tPersona = new Application_Model_Personas();
                $persona = $tPersona->fetchRow("idPersona = '".$usuario->idPersona."'")->toArray();                
                $persona['nombreTotal'] = $persona['primerNombre']." ".$persona['segundoNombre']." ".$persona['primerApellido']." ".$persona['segundoApellido'];
                
                $this->session->usuario = $usuario;                 
                $this->session->persona = $usuario;                 
                
                $this->view->usuario = $usuario;
                $this->view->persona = $persona;
                
                $this->_forward("inicio");
            } else {
                //$this->_redirect("/index/index");
            }
        }                                
    }

    public function logoutAction()
    {     
        Zend_Auth::getInstance()->clearIdentity();
        return $this->_redirect('/index/login');                
    }

    public function inicioAction()
    {          
        
    }


}
