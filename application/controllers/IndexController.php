<?php

class IndexController extends Zend_Controller_Action {

     public function init() {
        parent::init();
        if(!Zend_auth::getInstance()->hasIdentity()){
            $this->_redirect('/login');
        }
    }
    public function indexAction() {
       
    }

}

