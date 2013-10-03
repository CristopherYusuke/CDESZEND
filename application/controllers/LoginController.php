<?php

class LoginController extends Zend_Controller_Action {
   

    public function indexAction() {
        $form = new Application_Form_Usuario_Login();
        if ($this->getRequest()->isPost()) {
            $dados = $this->getRequest()->getParams();
            if ($form->isValid($dados)) {
                
                $value = $form->getValues();
                $conexao = Zend_Db_Table::getDefaultAdapter();
                
                $dbAdapter = new Zend_Auth_Adapter_DbTable($conexao);
                $dbAdapter
                        ->setTableName('usuario')
                        ->setIdentityColumn('login')
                        ->setCredentialColumn('senha')
                        ->setIdentity($value['login'])
                        ->setCredential($value['senha'])
                ;
                $auth = Zend_Auth::getInstance();
                $autenticado = $auth->authenticate($dbAdapter);

                if ($autenticado->isValid()) {
                    $valorArmazenado = $dbAdapter->getResultRowObject();
                    $auth->getStorage()->write($valorArmazenado);
                    $this->_redirect("/");
                } else {
                    echo'errado';
                    
                }
            }
        }
        $this->view->form = $form;
    }
    public function logoutAction(){
      Zend_Auth::getInstance()->clearIdentity();
      $this->_helper->redirector('index');
         
}

}