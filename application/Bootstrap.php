<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function _initConfig() {
        $config = new Zend_Config($this->getApplication()->getOptions(), true);
        Zend_Registry::set('config', $config);
    }

    
    
    public function _initSession() {
        $session = new Zend_Session_Namespace('CDES');
        Zend_Registry::set('session', $session);
    }

    public function _initDb() {
        $db = $this->getPluginResource('db')->getDbAdapter();
        Zend_Db_Table::setDefaultAdapter($db);
        Zend_Registry::set('db', $db);
    }

    protected function _initTranslate() {
        try {
            $translate = new Zend_Translate('Array', APPLICATION_PATH . '/languages/pt_BR/Zend_Validate.php', 'pt_BR');
            Zend_Validate_Abstract::setDefaultTranslator($translate);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}

