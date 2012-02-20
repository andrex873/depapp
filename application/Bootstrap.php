<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
      protected function _initDatabase()
    {
        $this->bootstrap("db");
        $db = $this->getResource("db");        
        Zend_Registry::set("db", $db);
        return $db;
    }

}

