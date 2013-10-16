<?php

class ContasPagarController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_CP_Busca();
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = "where cp.situacao = 0";
        $idCompra = $this->_getParam('idCompra');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {

                $where = "where cp.situacao = " . $data['situacao'] . " and nome like('%" . $data['nome'] . "%') ";
                if ($data['idCompra']) {
                    $where .= "and cp.idCompra = " . $data['idCompra'];
                }
            } else {
                $form->populate($data);
            }
        } else {
            if ($this->_getParam('idCompra')) {
                $where = "where c.idCompra = $idCompra";
                $form->idCompra->setValue($idCompra);
            }
        }

        $query = "SELECT  cp.*, f.nome
                    FROM
                    contaspagar cp
                        left join
                    compra c ON c.idCompra = cp.idCompra
                        left join
                    fornecedor f ON c.idFornecedor = f.idFornecedor
                    $where";

        $model = $db->query($query);
        $this->view->CP = $model->fetchAll();
        $this->view->form = $form;
    }

    public function createAction() {
        $form = new Application_Form_CP_ContasPagar();
        $model = new Application_Model_DbTable_Compra();
        $db = Zend_Db_Table::getDefaultAdapter();
        $idvenda = $this->_getParam('idCompra');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $totalCompra = $data['totalCompra'];
            $numParcelas = $data['formasPagamento'];
            $model->update(array(
                'situacao' => 2,
                'formasPagamento' => $data['formasPagamento'],
                'total' => $totalCompra), "idCompra =  $idvenda");
            $modelCP = new Application_Model_DbTable_Contaspagar();
            $date = new DateTime(date("Y-m-d"));
            $CP = array();
            if ($numParcelas == 0) {
                $CP = array(
                    'idCompra' => $idvenda,
                    'valor' => $data['totalCompra'],
                    'numParcela' => 1,
                    'vencimento' => $date->format('Y-m-d'),
                    'situacao' => 0
                );
                $modelCP->insert($CP);
            } else {
                $Parcela = number_format(($totalCompra / $numParcelas), 2, '.', '');
                $diferenca = number_format(($totalCompra - ($Parcela * $numParcelas)), 2, '.', '');
                $UltimaParcela = $diferenca + $Parcela;
                for ($i = 0; $i < $numParcelas; $i++) {
                    $date = $date->modify('+1 month');
                    $CP['idCompra'] = $idvenda;
                    $CP['valor'] = ($i == $numParcelas - 1) ? $UltimaParcela : $Parcela;
                    $CP['numParcela'] = $i + 1;
                    $CP['vencimento'] = $date->format('Y-m-d');
                    $CP['situacao'] = 0;
                    $modelCP->insert($CP);
                }
            }
            $this->_redirect("/ContasPagar/index/idCompra/$idvenda");
        }
        $resultado = $db->query("SELECT nome, c.*,sum(i.total) as totalCompra 
                  from compra c 
                  left join fornecedor f 
                  on f.idFornecedor = c.idFornecedor 
                  left join itemcompra i 
                  on i.idCompra = c.idCompra 
                  where c.idCompra = $idvenda 
                  group by idCompra");
        $itensTabela = $resultado->fetch();
        $itensTabela['totalCompra'] = (float) number_format($itensTabela['totalCompra'], 2, '.', '');

        if ($itensTabela['situacao'] != 0 || $itensTabela['totalCompra'] <= 0) {
            $this->_redirect('/venda');
        }

        $form->fornecedor->setValue($itensTabela['nome']);
        $form->dataCompra->setValue($this->converteData($itensTabela['dataCompra']));
        $form->totalCompra->setValue(number_format($itensTabela['totalCompra'], 2, ',', ''));
        $form->formasPagamento->setValue($itensTabela['formasPagamento']);
        switch ($itensTabela['situacao']) {
            case 0: $form->situacao->setValue('Aberta');
                break;
            case 1: $form->situacao->setValue('Cancelada');
                break;
            case 2: $form->situacao->setValue('Faturada');
                break;
            case 3: $form->situacao->setValue('Finalizada');
                break;
            case 4: $form->situacao->setValue('Extornada');
                break;
            default:$form->situacao->setValue('outro');
                break;
        };
        $this->view->form = $form;
    }

    public function pagamentoAction() {
        /*
          $form = new Application_Form_CR_Pagamento();
          $this->view->form = $form;
         */
        $date = new DateTime(date("Y-m-d"));
        $idCR = $this->_getParam("idContasPagar");
        $model = new Application_Model_DbTable_Contaspagar();
        $CP = $model->fetchRow("idContasP = $idCR")->toArray();
        $model->update(array('situacao' => 1, 'pagamento' => $date->format('Y-m-d')), "idContasP = $idCR");
        $existVenda = $model->fetchAll("idCompra = " . $CP['idCompra'] . " and situacao = 0")->toArray();

        if (count($existVenda) == 0) {
            $modelVenda = new Application_Model_DbTable_Compra();
            $modelVenda->update(array('situacao' => 3), "idCompra = " . $CP['idCompra']);
        }
        $this->_redirect("/ContasPagar/index/idCompra/" . $CP['idCompra']);
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

?>
