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
        $form = new Application_Form_Usuario();
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
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
        $form = new Application_Form_Usuario();
      
        $form->submit->setLabel('Alterar');
        $posts = new Application_Model_Usuario();

        if ($this->_request->isPost()) {

            if ($form->isValid($this->_request->getPost())) {
                $values = $form->getValues();
                $posts->update($values, 'idUsuario = ' . $values['idUsuario']);
            }
            else { 
                $form->populate($form->getValues());
            }
        } else { 
            $id = $this->_getParam('idUsuario');
            
            $post = $posts->fetchRow("idUsuario = $id")->toArray();
            $form->populate($post);
        }
        $this->view->form = $form;
    }

}

