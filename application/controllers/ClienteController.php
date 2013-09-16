<?php

class ClienteController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $Model = new Application_Model_DbTable_Cliente();

        $this->view->clientes = $Model->fetchAll("status = 1")->toArray();
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Cliente_Cliente();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                
                if ($data['tipo'] == "F") {
                    $validaCPF_CNPJ = new Zend_Validate_Cpf();
                } else {
                    $validaCPF_CNPJ = new Zend_Validate_Cpf();
                };
                
                $model = new Application_Model_DbTable_Cliente();
                $model->insert($data);
                $mensagens = "Cliente criado com sucesso.";
                $erro = false;
            } else {
                $mensagens = "Não foi possível criar cliente.";
                $erro = true;
                $form->populate($data);
                $this->view->formulario = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $this->view->formulario = $form;
        }
    }

    public function updateAction() {/* do cliente */
        $erro = true;
        $form = new Application_Form_Cliente_Cliente();
        $form->setAction('/cliente/update');
        $form->submit->setLabel('Alterar');
//        $form->getElement('tipo')->getValue();
        $this->view->form = $form;
        $model = new Application_Model_DbTable_Cliente();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $values = $form->getValues();
                /* and idCliente <> '.$data['idCliente'] */
                $ExisteCPF_CNPJ = $model->fetchRow('CPF_CNPJ = "' . $data['CPF_CNPJ'] . '"and idCliente <> ' . (int) $this->_getParam('idCliente'));
                if (count($ExisteCPF_CNPJ) == 0) {
                    $model->update($values, 'idCliente = ' . $values['idCliente']);
                    $mensagens = "Cliente criado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "ja existe cliente com o CPF '" . $data['CPF_CNPJ'] . "'";
                    $erro = true;
                }
            } else {
                $mensagens = "Não foi possível criar cliente.";
                $erro = true;
                $form->populate($data);
                $this->view->formulario = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $id = $this->_getParam('idCliente');
            $cliente = $model->fetchRow("idCliente =" . $id)->toArray();

            $form->populate($cliente);
            $form->getElement('cidade')->addMultiOption('', $cliente['cidade']);
        }
        $this->view->formulario = $form;
    }

    public function deleteAction() {
        $usuario = new Application_Model_Usuario();
        $id = $this->_getParam('idUsuario');
        $usuario->delete("idUsuario = $id");
        $this->_redirect('usuario/index');
    }

}

