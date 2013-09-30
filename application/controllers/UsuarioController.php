<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $usuarioModel = new Application_Model_DbTable_Usuario();
        $this->view->usuarios = $usuarioModel->fetchAll()->toArray();
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Usuario_Usuario();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $model = new Application_Model_DbTable_Usuario();
                $ExisteUsuario = $model->fetchRow('login = "' . $values['login'] . '"');
                if (!isset($ExisteUsuario)) {
                    $model->insert($values);
                    $mensagens = "Usuário criado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O login ' " . $values['login'] . " ' já existe.";
                    $erro = true;
                }
            } else {
                $mensagens = "Não foi possível criar usuário.";
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
        $form2 = new Application_Form_Usuario_Usuario();
        $form2->setAction('/usuario/update');
        $form2->submit->setLabel('Alterar');
        $form2->login
                ->setAttribs(array('readonly' => true, 'class' => 'disabled'))
                ->setIgnore(true);
        $usuario = new Application_Model_DbTable_Usuario();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form2->isValid($data)) {
                $values = $form2->getValues();
                $usuario->update($values, 'idUsuario = ' . $values['idUsuario']);
                $mensagens = "Usuário alterado com sucesso.";
                $erro = false;
            } else {
                $form2->populate($form2->getValues());
                $mensagens = "Não foi possível criar usuário.";
                $erro = true;
                $this->view->form = $form2;
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
        $usuario = new Application_Model_DbTable_Usuario();
        $id = $this->_getParam('idUsuario');
        $usuario->delete("idUsuario = $id");
        $this->_redirect('usuario/index');
    }

}

