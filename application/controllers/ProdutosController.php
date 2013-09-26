<?php

class ProdutosController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $form = new Application_Form_Produto_Busca();
        $model = new Application_Model_DbTable_Produto();
        $this->view->form = $form;
        $this->view->produtos = $model;
    }

    public function createAction() {
        $form = new Application_Form_Produto_Produto();
        $this->view->form = $form;
    }

    public function updateAction() {
        $form = new Application_Form_Produto_Produto();
        $this->view->form = $form;
    }

}

?>
