<?php

class ProdutoController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
       
        $model = new Application_Model_Produto();
        $this->view->produtos = $model;
    }

    public function createAction() {
        $form = new Application_Form_Produto();
        $this->view->form = $form;
    }

    public function updateAction() {
        
    }

    public function deleteAction() {
        
    }

}

?>
