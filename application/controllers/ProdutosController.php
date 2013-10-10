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
        $this->view->form = $form;
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Produto_Produto();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $values['precoCusto'] = str_replace(',', '.', $values['precoCusto']);
                $values['precoVenda'] = str_replace(',', '.', $values['precoVenda']);
                if ($values['precoCusto'] > 0) {
                    if ($values['precoCusto'] < $values['precoVenda']) {
                        $model = new Application_Model_DbTable_Produto();
                        $id = $model->insert($values);
                        $mensagens = "Produto $id  criado com sucesso.";
                        $erro = false;
                    } else {
                        $mensagens = "Preço de custo não pode ser maior que o preço da venda.";
                        $erro = true;
                    }
                } else {
                    $mensagens = "Preço de custo não pode ser negativo ";
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
        $form->getElement('estoque')->setAttribs(array('readonly' => true,
        'class' => 'disabled'));
        $Produto = new Application_Model_DbTable_Produto();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $values['precoCusto'] = str_replace(',', '.', $values['precoCusto']);
                $values['precoVenda'] = str_replace(',', '.', $values['precoVenda']);
                if ($values['precoCusto'] > 0) {
                    if ($values['precoCusto'] < $values['precoVenda']) {
                        $Produto->update($values, 'idProduto = ' . $values['idProduto']);
                        $mensagens = "Produto alterado com sucesso.";
                        $erro = false;
                    } else {
                        $mensagens = "Preço de custo não pode ser maior que o preço da venda.";
                        $erro = true;
                    }
                } else {
                    $mensagens = "Preço não pode ser negativo ";
                    $erro = true;
                }
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
            $usu['precoVenda'] = str_replace('.', ',', $usu['precoVenda']);
            $form->populate($usu);
        }
        $this->view->form = $form;
    }

    public function getnomeprodutoAction() {
        $Model = new Application_Model_DbTable_Produto();
        $id = $this->_getParam('idProduto');
        $produto = json_encode($Model->fetchRow(" idProduto = $id ")->toArray());
        echo $produto;
        exit();
    }

}

?>
