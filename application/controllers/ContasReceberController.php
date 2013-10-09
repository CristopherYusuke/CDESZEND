<?php

class ContasReceberController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_CR_Busca();
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = '';
        $idVenda = $this->_getParam('idVenda');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $where = "where situacao = " . $data['situacao'] . " and nome like('%" . $data['nome'] . "%')";
                if ($data['idVenda']) {
                    $where += "and c.idVenda = " . $data['idVenda'];
                }
            } else {
                $form->populate($data);
            }
        } else {
            if ($this->_getParam('idVenda')) {
                $where = "where c.idVenda = $idVenda";
            }
        }
        $query = "SELECT  c.*, cl.nome
                    FROM
                    contasreceber c
                        left join
                    venda v ON v.idVenda = c.idVenda
                        left join
                    cliente cl ON v.idCliente = cl.idCliente
                    $where";
        $model = $db->query($query);
        $this->view->CR = $model->fetchAll();
        $this->view->form = $form;
    }

    public function createAction() {
        $form = new Application_Form_CR_ContasReceber();
        $model = new Application_Model_DbTable_Venda();
        $db = Zend_Db_Table::getDefaultAdapter();
        $idvenda = $this->_getParam('idVenda');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $model->update(array('situacao' => 2,
                'formasPagamento' => $data['formasPagamento'])
                    , "idVenda =  $idvenda");
            $modelCR = new Application_Model_DbTable_Contasreceber();
            $numParcelas = $data['formasPagamento'];
            $totalVenda = $data['totalVenda'];
            $date = new DateTime(date("Y-m-d"));
            $CR = array();
            if ($numParcelas == 0) {
                $CR = array(
                    'idVenda' => $idvenda,
                    'valor' => $data['totalVenda'],
                    'numParcela' => 1,
                    'vencimento' => $date->format('Y-m-d'),
                    'situacao' => 0
                );
                $modelCR->insert($CR);
            } else {
                $Parcela = number_format(($totalVenda / $numParcelas), 2, '.', '');
                '<br>';
                $diferenca = number_format(($totalVenda - ($Parcela * $numParcelas)), 2, '.', '');
                '<br>';
                $UltimaParcela = $diferenca + $Parcela;
                for ($i = 0; $i < $numParcelas; $i++) {
                    $date = $date->modify('+1 month');
                    $CR['idVenda'] = $idvenda;
                    $CR['valor'] = ($i == $numParcelas - 1) ? $UltimaParcela : $Parcela;
                    $CR['numParcela'] = $i + 1;
                    $CR['vencimento'] = $date->format('Y-m-d');
                    $CR['situacao'] = 0;
                    $modelCR->insert($CR);
                }
            }
            $this->_redirect("/ContasReceber/index/idVenda/$idvenda");
        }
        $resultado = $db->query("SELECT nome, v.*,sum(i.total) as totalVenda 
                  from venda v 
                  left join cliente c 
                  on c.idCliente = v.idCliente 
                  left join itemvenda i 
                  on i.idVenda = v.idVenda 
                  where v.idVenda = $idvenda 
                  group by idVenda");
        $itensTabela = $resultado->fetch();
        $itensTabela['totalVenda'] = (float) number_format($itensTabela['totalVenda'], 2, '.', '');

        if ($itensTabela['situacao'] != 0 || $itensTabela['totalVenda'] <= 0) {
            $this->_redirect('/venda');
        }

        $form->cliente->setValue($itensTabela['nome']);
        $form->dataVenda->setValue($this->converteData($itensTabela['dataVenda']));
        $form->totalVenda->setValue(number_format($itensTabela['totalVenda'], 2, ',', ''));
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
        $form = new Application_Form_CR_Pagamento();
        $this->view->form = $form;
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
