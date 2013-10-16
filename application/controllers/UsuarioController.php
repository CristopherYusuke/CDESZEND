<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $usuarioModel = new Application_Model_DbTable_Usuario();
        $usuarios = $usuarioModel->fetchAll()->toArray();
        $this->view->usuarios = $usuarios;
        $this->view->qtdeLinhas = count($usuarios);
    }

    public function createAction() {
        $erro = true;
        $form = new Application_Form_Usuario_Usuario();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $model = new Application_Model_DbTable_Usuario();
                $ExisteUsuario = $model->fetchRow('login = "' . $values['login'] . '"');
                if (!isset($ExisteUsuario)) {
                    $id = $model->insert($values);
                    $mensagens = "Usuário $id criado com sucesso.";
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
        } 
        $this->view->form = $form;
    }

    public function updateAction() {
        $form2 = new Application_Form_Usuario_Usuario();
        $form2->setAction('/usuario/update');
        $form2->submit->setLabel('Alterar');
        $usuario = new Application_Model_DbTable_Usuario();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form2->isValid($data)) {
                $values = $form2->getValues();
                $existCC = $usuario
                        ->fetchRow("idUsuario != " . $values['idUsuario']
                        . " and login = '" . $values['login'] . "'");
                if (count($existCC) <= 0) {
                    $usuario->update($values, 'idUsuario = ' . $values['idUsuario']);
                    $mensagens = "Usuário alterado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O Login : " . $values['login'] . " já existe";
                    $erro = true;
                }
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

