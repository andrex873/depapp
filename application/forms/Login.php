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
                'placeholder' => 'Digite su nombre de usuario...',            
                'class' => 'span3',
                'required' => ''
                ));    
        $this->addElement($nombreusuario);
        
        $claveusuario = new Zend_Form_Element_Password('claveusuario');
        $claveusuario
            ->setLabel('Clave')
            ->setRequired()                
            ->setAttribs(array(                
                'class' => 'span3',                
                'required' => ''                
                ));    
        $this->addElement($claveusuario);
        
        $enviar = new Zend_Form_Element_Submit('enviar');
        $enviar
            ->setLabel('Ingresar')            
            ->setAttribs(array(                
                'class' => 'btn btn-primary' 
                ));    
        $this->addElement($enviar);                                         
    }
}