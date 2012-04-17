<?php
class Application_Form_Login extends Zend_Form
{
    
    public function init() {

        $this->setMethod('post')
             ->setAction('/index/login');        
        
        $nombreusuario = new Zend_Form_Element_Text('nombreusuario');
        $nombreusuario
            ->setLabel('Usuario')
            ->setRequired()                
            ->setAttribs(array(
                'placeholder' => 'Nombre de usuario',            
                'class' => 'frm_input',
                'required' => ''
                ));    
        $this->addElement($nombreusuario);
        
        $claveusuario = new Zend_Form_Element_Password('claveusuario');
        $claveusuario
            ->setLabel('Clave')
            ->setRequired()                
            ->setAttribs(array(                
                'class' => 'frm_input',                
                'required' => ''                
                ));    
        $this->addElement($claveusuario);
        
        $enviar = new Zend_Form_Element_Submit('enviar');
        $enviar
            ->setLabel('Ingresar')            
            ->setAttribs(array(                
                'class' => 'btnGeneral' 
                ));    
        $this->addElement($enviar);                                         
    }
}