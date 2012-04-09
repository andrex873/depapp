<?php
class Application_Form_Login extends Zend_Form
{
    
    public function init() {
        
        $this->addElement('text', 'nombreusuario', array(
            'label' => 'Usuario',
            'class' => 'una dos tres'
        ));
        $this->addElement('password', 'claveusuario', array(
            'label' => 'Clave'
        ));
        $this->addElement('submit', 'enviar', array(
            'label' => 'Ingrasar'            
        ));
    }
}