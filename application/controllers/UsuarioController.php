<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $usuarioModel = new Application_Model_Usuario();
        $this->view->usuarios = $usuarioModel->fetchAll()->toArray();
    }

    public function createAction() {
        $erro = true;
        $form2 = new Application_Form_Usuario();
        $this->view->form = $form2;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form2->isValid($data)) {
                $model = new Application_Model_Usuario();
                unset($data['submit']);
                $where = $model->select()->where('login = ?', $data['LOGIN']);
                $ExisteUsuario = $model->fetchRow($where);
                if (!isset($ExisteUsuario)) {
                    $model->insert($data);
                    $mensagens = "Usuário criado com sucesso.";
                    $erro = false;
                } else {
                    $mensagens = "O login ' " . $data['LOGIN'] . " ' já existe.";
                    $erro = true;
                }
            } else {
                $mensagens = "Não foi possível criar usuário.";
                $erro = true;
                $form2->populate($data);
                $this->view->formulario = $form2;
            }
            $this->view->erro = $erro;
            $this->view->mensagens = $mensagens;
        } else {
            $this->view->formulario = $form2;
        }
    }

    public function updateAction() {
        $form2 = new Application_Form_Usuario();
        $form2->setAction('/usuario/update');
        $form2->submit->setLabel('Alterar');
        $usuario = new Application_Model_Usuario();
        if ($this->_request->isPost()) {
            if ($form2->isValid($this->_request->getPost())) {
                $values = $form2->getValues();
                $usuario->update($values, 'idUsuario = ' . $values['idUsuario']);
                $this->_redirect('usuario/index');
            } else {
                $form2->populate($form2->getValues());
            }
        } else {
            $id = $this->_getParam('idUsuario');
            $usu = $usuario->fetchRow("idUsuario =" . $id)->toArray();
//            var_dump($usu);exit();
            $form2->populate($usu);
        }
        $this->view->form = $form2;
    }

    

}

