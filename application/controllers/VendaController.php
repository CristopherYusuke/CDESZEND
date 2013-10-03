<?php

class VendaController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if(!Zend_auth::getInstance()->hasIdentity()){
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Venda_Busca();
        $model = new Application_Model_DbTable_Venda();
        $this ->view->venda = $model;
        $this->view->form = $form;
    }

    public function createAction() {
        $form = new Application_Form_Venda_Venda();
        $this->view->form = $form;
    }

    public function updateAction() {
        
    }

}

