<?php

class IndexController extends Zend_Controller_Action
{

    private $sesion = null;

    public function init()
    {
        $this->sesion = new Zend_Session_Namespace('global');
    }

    public function indexAction()
    {
        
    }

    public function loginAction()
    {   
        $user = "amendez";
        $pwd = "123";
        $post = $this->getRequest()->getPost();
        if($user == $post['in_user'] && $pwd == $post['in_pass']){
            $this->session->logueado = true;            
            $this->_forward("inicio");
        }else{
            $this->_forward("index");        
        }
    }

    public function logoutAction()
    {
        if (isset($this->session->logueado)) 
            Zend_Session::destroy (true);            
        $this->_redirect("/index/index");
    }

    public function inicioAction()
    {
        // action body
    }


}
