<?php
class Application_Form_Login extends Zend_Form
{
    
    public function init() {
                
        $this->clearDecorators();
//        $username = new Zend_Form_Element_Text('username');
//        $username
//            ->setLabel('Username:')
//            ->addDecorator('Label', array('class' => 'req-username'))
//            ->addDecorator('Errors', array('class' => 'err-username'));

        
        
        $this->addElement('text', 'nombreusuario', array(
            'label' => 'Usuario',
            'class' => 'frm_label'
        ));
        $this->addElement('password', 'claveusuario', array(
            'label' => 'Clave'
        ));
        $this->addElement('submit', 'enviar', array(
            'label' => 'Ingrasar'            
        ));
    }
}