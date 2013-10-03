<?php

class VendaController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Venda_Busca();
        $model = new Application_Model_DbTable_Venda();
        $this->view->venda = $model;
        $this->view->form = $form;
    }

    public function createAction() {
        $form = new Application_Form_Venda_Venda();
        if ($this->_getParam('idCliente') != null) {
            $model = new Application_Model_DbTable_Cliente();
            $id = (int) $this->_getParam('idCliente');
            $cliente = $model->fetchRow("idCliente =" . $id)->toArray();
            $modelVenda = new Application_Model_DbTable_Venda();
            $form->cliente->setValue($cliente['nome']);
            $form->dataVenda->setValue(date('d/m/Y'));
        }
        if ($this->_request->isPost()) {
            echo"foi post";
        }


        $this->view->form = $form;
    }

    public function addVendaAction() {
        
    }

    public function updateAction() {
        
    }

}

