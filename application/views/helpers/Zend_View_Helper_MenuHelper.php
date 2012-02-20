<?php
class Zend_View_Helper_MenuHelper extends Zend_View_Helper_Abstract
{
    function menuHelper() {
        
        
        
        $db = Zend_Registry::get("db");
        
        
        
        
        $request = Zend_Controller_Front::getInstance()->getRequest();
        
        $file_uri = 'media/css/' . $request->getControllerName() . '/' . $request->getActionName() . '.css';
       
        if (file_exists($file_uri)) {
            $this->view->headLink()->appendStylesheet('/' . $file_uri);
        }
       
        return $this->view->headLink();
       
    }
}