<?php

class ClienteController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $Model = new Application_Model_Cliente();
        $this->view->clientes = $Model->fetchAll()->toArray();
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Cliente();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $model = new Application_Model_Cliente();
                $ExisteCPF_CNPJ = $model->fetchRow('CPF_CNPJ = "' . $data['CPF_CNPJ'] . '"');
                if (!isset($ExisteCPF_CNPJ)) {
                    $data["status"] = A;
                    $model->insert($data);
                    $mensagens = "Cliente criado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O cliente com o ' " . $data['CPF_CNPJ'] . " ' já existe.";
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
            $this->view->formulario = $form;
        }
    }

    public function updateAction() {/* do cliente */
        $erro = true;
        $form = new Application_Form_Cliente();
        $form->setAction('/cliente/update');
        $form->submit->setLabel('Alterar');
//        $form->getElement('tipo')->getValue();
        $this->view->form = $form;
        $model = new Application_Model_Cliente();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $values = $form->getValues();
                /* and idCliente <> '.$data['idCliente']*/
                $ExisteCPF_CNPJ = $model->fetchRow('CPF_CNPJ = "' . $data['CPF_CNPJ'] . '"and idCliente <> '.(int) $this->_getParam('idCliente'));
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
            $cliente = $model->fetchRow("idCliente =".$id)->toArray();
            
            $form->populate($cliente);
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

