<?php

class CidadeController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function cidadeufAction() {
        $cidadeModel = new Application_Model_DbTable_TbCidades();
        
        $uf = $this->_getParam('uf');
        echo json_encode ($cidadeModel->fetchAll('UF = "'.$uf.'"')->toArray());      
        exit();
    }

}

?>