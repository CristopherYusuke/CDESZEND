<?php

class ClienteController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $usuarioModel = new Application_Model_Cliente();
        $this->view->usuarios = $usuarioModel->fetchAll()->toArray();
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Cliente();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            unset($data['submit']);
            if ($form->isValid($data)) {
                $model = new Application_Model_Usuario();
                $where = $model->select()->where('login = ?',$data['login']);
                $ExisteUsuario = $model->fetchRow($where);
                if (!isset($ExisteUsuario)) {
                    $model->insert($data);
                    $mensagens = "Usuário criado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O login ' " . $data['login'] . " ' já existe.";
                    $erro = true;
                }
            } else {
                $mensagens = "Não foi possível criar usuário.";
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

    public function updateAction() {
        $form2 = new Application_Form_Usuario();
        $form2->setAction('/usuario/update');
        $form2->submit->setLabel('Alterar');
        $usuario = new Application_Model_Usuario();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form2->isValid($data)) {
                $values = $form2->getValues();
                unset($data['submit']);
                $where = $usuario->select()->where('login = ?', $data['login']);
                $ExisteUsuario = $usuario->fetchRow($where);
                if (!isset($ExisteUsuario)) {
                    $usuario->update($values, 'idUsuario = ' . $values['idUsuario']);
                    $mensagens = "Usuário alterado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O login ' " . $data['login'] . " ' já existe.";
                    $erro = true;
                }
            } else {
                $form2->populate($form2->getValues());
                $mensagens = "Não foi possível criar usuário.";
                $erro = true;
                $this->view->formulario = $form;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $id = $this->_getParam('idUsuario');
            $usu = $usuario->fetchRow("idUsuario =" . $id)->toArray();
            $form2->populate($usu);
        }
        $this->view->form = $form2;
    }

    public function deleteAction() {
        $usuario = new Application_Model_Usuario();
        $id = $this->_getParam('idUsuario');
        $usuario->delete("idUsuario = $id");
        $this->_redirect('usuario/index');
    }

}

