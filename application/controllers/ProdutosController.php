<?php

class ProdutosController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Produto_Busca();
        $model = new Application_Model_DbTable_Produto();
        $where = array('status = 1');
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $where[0] = "status = " . $data['status'];
                $where[] = "descricao like('%" . $data['descricao'] . "%')";
                $this->view->produtos = $model->fetchAll($where)->toArray();
            } else {
                $form->populate($data);
                $this->view->form = $form;
            }
        } else {
            $this->view->produtos = $model->fetchAll($where)->toArray();
            $this->view->form = $form;
        }
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Produto_Produto();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                if ($values['precoCusto'] > 0) {
                    $model = new Application_Model_DbTable_Produto();
                    $values['precoCusto'] = str_replace(',', '.', $values['precoCusto']);
                    $id = $model->insert($values);
                    $mensagens = "Produto $id criado com sucesso.";
                    $erro = false;
                }else{
                    $mensagens = "Preço não pode ser negativo ";
                    $erro = true;
                }
            } else {
                $mensagens = "Não foi possível criar produto.";
                $erro = true;
                $form->populate($data);
                $this->view->form = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $this->view->form = $form;
        }
    }

    public function updateAction() {
        $form = new Application_Form_Produto_Produto();
        $form->setAction('/produtos/update');
        $form->submit->setLabel('Alterar');
        $this->view->form = $form;
        $Produto = new Application_Model_DbTable_Produto();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $Produto->update($values, 'idProduto = ' . $values['idProduto']);
                $mensagens = "Produto alterado com sucesso.";
                $erro = false;
            } else {
                $form->populate($form->getValues());
                $mensagens = "Não foi possível alterado produto.";
                $erro = true;
                $this->view->form = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $id = $this->_getParam('idProduto');
            $usu = $Produto->fetchRow("idProduto =" . $id)->toArray();
            $usu['precoCusto'] = str_replace('.', ',', $usu['precoCusto']);
            $form->populate($usu);
        }
    }

}

?>
