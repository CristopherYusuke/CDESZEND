<?php

class VendaController extends Zend_Controller_Action {

    public function init() {
        
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

