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
        if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect("/index/inicio");
        }
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();            
            $auAdapter = new Zend_Auth_Adapter_DbTable();
            $auAdapter->setTableName('t_usuarios')
                    ->setIdentityColumn('nombreUsuario')
                    ->setCredentialColumn('clave');

            $auAdapter->setIdentity($post['in_user'])
                    ->setCredential(md5($post['in_pass']));
            $auInstance = Zend_Auth::getInstance();
            $resultado = $auInstance->authenticate($auAdapter);                        
            
            if ($resultado->isValid()) {
                $usuario = $auAdapter->getResultRowObject(null, 'clave');
                
                $tPersona = new Application_Model_Personas();
                $persona = $tPersona->fetchRow("idPersona = '".$usuario->idPersona."'")->toArray();                
                $persona['nombreTotal'] = trim($persona['primerNombre']." ".$persona['segundoNombre']." ".$persona['primerApellido']." ".$persona['segundoApellido']);
                
                $this->session->usuario = $usuario;                 
                $this->session->persona = $persona;                                                 
                
                $this->_redirect("/index/inicio");
            } else {
                //$this->_redirect("/index/index");
            }
        }
        //$this->_helper->multiples(30);
    }

    public function logoutAction()
    {     
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy(true);
        return $this->_redirect('/index/login');                
    }

    public function inicioAction()
    {   
        $sesion = new Zend_Session_Namespace(NS_SESSION);        
        $this->view->usuario = $sesion->usuario;
        $this->view->persona = $sesion->persona;
        if($this->getRequest()->isPost()){
            $post = $this->getRequest()->getPost();            
            $post['texto2'] = "Esto es ótrá caden con eñe y mas coás ú.";
            $this->_helper->json->sendJson($post);
        }
    }


}
