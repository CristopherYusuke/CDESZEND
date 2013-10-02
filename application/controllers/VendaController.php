<?php

class VendaController extends Zend_Controller_Action {

    public function init() {
        $form = new Application_Form_Venda_Busca();
        $model = new Application_Model_DbTable_Venda();
        $this ->view->venda = $model;
        $this->view->form = $form;
    }

    public function indexAction() {
        
    }

    public function createAction() {
        $form = new Application_Form_Venda_Venda();
        $this->view->form = $form;
    }

    public function updateAction() {
        
    }

}

