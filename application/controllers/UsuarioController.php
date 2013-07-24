<?php

class UsuarioController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        $usuarioModel = new Application_Model_Usuario();
        $this->view->usuarios = $usuarioModel->fetchAll()->toArray();
    }

    public function createAction() {
        $form = new Application_Form_Usuario();
        $this->view->form = $form;
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $model = new Application_Model_Usuario();
                unset($data['submit']);
                $model->insert($data);
            } else {
                $form->populate($data);
                $this->view->formulario = $form;
            }
        } else {
            $this->view->formulario = $form;
        }
    }

}

