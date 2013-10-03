<?php

class FornecedorController extends Zend_Controller_Action {

   public function init() {
        parent::init();
        if(!Zend_auth::getInstance()->hasIdentity()){
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Fornecedor_Busca();
        $Model = new Application_Model_DbTable_Fornecedor();
        $where = array("status = 1 ");
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $where[0] = "status = " . $data['status'];
                $where[] = "NOME like('%" . $data['nome'] . "%')";
                $this->view->fornecedores = $Model->fetchAll($where)->toArray();
            } else {
                $form->populate($data);
                $this->view->form = $form;
            }
        } else {
            $this->view->fornecedores = $Model->fetchAll($where)->toArray();
            $this->view->form = $form;
        }
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Fornecedor_Fornecedor();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $validaCPF_CNPJ = ($values['tipo'] == "F") ? new Zend_Validate_Cpf() : new Zend_Validate_Cnpj();
                if ($validaCPF_CNPJ->isValid($values['CPF_CNPJ'])) {
                    $model = new Application_Model_DbTable_Fornecedor();
                    $model->insert($values);
                    $mensagens[] = "Fornecedor criado com sucesso.";
                    $erro = false;
                    $form->getElement('cidade')->addMultiOption('', $data['cidade']);
                } else {
                    $mensagens = $validaCPF_CNPJ->getMessages();
                    if (isset($data['cidade'])) {
                        $form->getElement('cidade')->addMultiOption('', $values['cidade']);
                    }
                }
            } else {
                $mensagens[] = "Não foi possível criar cliente.";
                $erro = true;
                $form->populate($data);
                $this->view->form = $form;
                if (isset($data['cidade'])) {
                    $form->getElement('cidade')->addMultiOption('', $data['cidade']);
                }
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $this->view->form = $form;
        }
    }

    public function updateAction() {
        $mensagens = array();
        $erro = true;
        $form = new Application_Form_Fornecedor_Fornecedor();
        $form->setAction('/fornecedor/update');
        $form->submit->setLabel('Alterar');
        $this->view->form = $form;
        $model = new Application_Model_DbTable_Fornecedor();
        $modelCid = new Application_Model_DbTable_TbCidades();
        $form->CPF_CNPJ
                ->removeValidator('Db_NoRecordExists');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $validaCPF_CNPJ = ($values['tipo'] == "F") ? new Zend_Validate_Cpf() : new Zend_Validate_Cnpj();
                if ($validaCPF_CNPJ->isValid($values['CPF_CNPJ'])) {
                    $existCC = $model
                            ->fetchRow("idFornecedor != " . $values['idFornecedor']
                            . " and CPF_CNPJ = '" . $values['CPF_CNPJ'] . "'");
                    if (count($existCC) <= 0) {
                        $model->update($values, 'idFornecedor = ' . $values['idFornecedor']);
                        $mensagens[] = "Fornecedor Atualizado com sucesso.";
                        $erro = false;
                        $form->getElement('cidade')->addMultiOption('', $data['cidade']);
                    } else {
                        $mensagens[] = "Não foi possível atualizar fornecedor.";
                        $erro = true;
                        $form->getElement('cidade')->addMultiOption('', $data['cidade']);
                    }
                } else {
                    $mensagens = $validaCPF_CNPJ->getMessages();
                    if (isset($values['cidade'])) {
                        $form->getElement('cidade')->addMultiOption('', $values['cidade']);
                    }
                }
            } else {
                $mensagens[] = "Não foi possível atualizar fornecedor.";
                $erro = true;
                $form->populate($data);
                $form->getElement('cidade')->addMultiOption('', $data['cidade']);
                $this->view->form = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $id = (int) $this->_getParam('idFornecedor');
            $fornecedor = $model->fetchRow("idFornecedor =" . $id)->toArray();
            $cidades = $modelCid->fetchAll("uf = '" . $fornecedor['UF'] . "'")->toArray();
            $form->populate($fornecedor);
            foreach ($cidades as $id => $data) {
                $form->cidade->addMultiOption($data['nome'], $data['nome']);
            }
            $form->getElement('cidade')->setValue($fornecedor['cidade']);
        }
        $this->view->form = $form;
    }

}

