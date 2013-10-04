<?php

class VendaController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Venda_Busca();
        $model = new Application_Model_DbTable_Venda();
        $this->view->venda = $model->fetchAll()->toArray();
        $this->view->form = $form;
    }

    public function createAction() {
        $form = new Application_Form_Venda_Venda();
        $formIten = new Application_Form_Venda_Itens();
        $itens = new Application_Model_DbTable_Itemvenda();
        $idvenda = $this->_getParam('idVenda');
        if ($idvenda != null) {
            $vendaTabela = new Application_Model_DbTable_Venda();
            $clienteTabela = new Application_Model_DbTable_Cliente();
            $venda = $vendaTabela->fetchRow("idVenda = " . $idvenda)->toArray();
            $cliente = $clienteTabela->fetchRow('idCliente = ' . $venda['idCliente'])->toArray();
            $form->cliente->setValue($cliente['nome']);
            $form->dataVenda->setValue($this->converteData($venda['dataVenda']));
            switch ($venda['situacao']) {
                case 0:
                    $situacao = 'Aberta';
                    break;
                case 1:
                    $situacao = 'Cancelada';
                    break;
                case 2:
                    $situacao = 'Faturada';
                    break;
                case 3:
                    $situacao = 'Finalizada';
                    break;
                case 4:
                    $situacao = 'Extornada';
                    break;
                default:
                    $situacao = false;
                    break;
            };

            $form->situacao->setValue($situacao);
        }
        $this->view->itens = $itens->fetchAll("idVenda = $idvenda");
        $this->view->form = $form;
        $this->view->formIten = $formIten;
    }

    public function addvendaAction() {
        if ($this->_getParam('idCliente') != null) {
            $id = (int) $this->_getParam('idCliente');
            $model = new Application_Model_DbTable_Venda();

            $idVenda = $model->insert(array('idCliente' => $id,
                'situacao' => 0,
                'dataVenda' => date('Y/m/d')
            ));
            $this->_redirect("/venda/create/idVenda/$idVenda");
        }
        if ($this->_request->isPost()) {
            
        }
    }

    public function updateAction() {
        
    }

    function converteData($data) {
        if (strstr($data, "/")) {//verifica se tem a barra /
            $d = explode("/", $data); //tira a barra
            $rstData = "$d[2]-$d[1]-$d[0]"; //separa as datas $d[2] = ano $d[1] = mes etc...
            return $rstData;
        } else if (strstr($data, "-")) {
            $data = substr($data, 0, 10);
            $d = explode("-", $data);
            $rstData = "$d[2]/$d[1]/$d[0]";
            return $rstData;
        } else {
            return '';
        }
    }

}

