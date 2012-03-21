<?php

class CertificadosController extends Zend_Controller_Action
{

    private $msg    = null;

    public function init()
    {
        //$this->msg = $this->_helper->FlashMessenger;
    }

    public function indexAction()
    {
        // action body
    }

    public function laboralAction()
    {        
        if($this->getRequest()->isPost()){
            
            $post = $this->getRequest()->getPost();
            $t_personas = new Application_Model_Personas();

            $condicion = sprintf( "1 %s %s"
                    , !empty($post['tipoDocumento']) ? "AND tipoDocumento = '{$post['tipoDocumento']}'": ""
                    , !empty($post['numeroDocumento']) ? "AND numeroDocumento = '{$post['numeroDocumento']}'": ""                    
                    );
            $filaPersona = $t_personas->fetchRow($condicion);
            if($filaPersona == null){
                $msg = array('status' => 'E', 'msg' => 'El usuario no existe');
                $this->_helper->FlashMessenger("error");
            }else{
                $msg = array('status' => 'S', 'msg' => 'El usuario correcto');
                $this->_helper->FlashMessenger("correcto");
            }
            $this->view->filaPersona = $filaPersona;
        }
    }


}



