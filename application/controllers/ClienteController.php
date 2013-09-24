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
                /*
                  if ($data['tipo'] == "F") {
                  $validaCPF_CNPJ = new Zend_Validate_Cpf();
                  } else {
                  $validaCPF_CNPJ = new Zend_Validate_Cpf();
                  };
                 */



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
        $this->view->form = $form;
        $model = new Application_Model_DbTable_Cliente();
        $modelCid = new Application_Model_Cidade();
        $form->CPF_CNPJ
                ->removeValidator('Db_NoRecordExists')

        ;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $model->update($values, 'idCliente = ' . $values['idCliente']);
                $mensagens = "Cliente Atualizado com sucesso.";
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
            $id = $this->_getParam('idCliente');
            $cliente = $model->fetchRow("idCliente =" . $id)->toArray();
            $cidades = $modelCid->fetchAll("UF = ".$cliente['uf'])->toArray();
            $form->populate($cliente);
            unset($cidades['uf']);
            unset($cidades['id']);
            foreach ($cidades as $id ) {
                $form->cidade->addMultiOption($id);
            }
            $form->cidade->setValue($cliente['cidade']);
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

