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
        $where = "where c.situacao = 0";
        $idVenda = $this->_getParam('idVenda');
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {

                $where = "where c.situacao = " . $data['situacao'] . " and nome like('%" . $data['nome'] . "%') ";
                if ($data['idVenda']) {
                    $where .= "and c.idVenda = " . $data['idVenda'];
                }
            } else {
                $form->populate($data);
            }
        } else {
            if ($this->_getParam('idVenda')) {
                $where = "where c.idVenda = $idVenda";
                $form->idVenda->setValue($idVenda);
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
            $totalVenda = $data['totalVenda'];
            $numParcelas = $data['formasPagamento'];
            $model->update(array(
                'situacao' => 2,
                'formasPagamento' => $data['formasPagamento'],
                'total' => $totalVenda), "idVenda =  $idvenda");
            $modelCR = new Application_Model_DbTable_Contasreceber();
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
                $diferenca = number_format(($totalVenda - ($Parcela * $numParcelas)), 2, '.', '');
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
        $resultado = $db->query("SELECT nome, v.*, sum(i.total) as totalVenda
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

        $idCR = $this->_getParam("idContasReceber");
        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT  c.*, cl.nome
                    FROM
                    contasreceber c
                        left join
                    venda v ON v.idVenda = c.idVenda
                        left join
                    cliente cl ON v.idCliente = cl.idCliente
                    where idContasR = $idCR ";
        $model = $db->query($query);
        $pagar = $model->fetch();
        $pagar['vencimento'] = $this->converteData($pagar['vencimento']);
        $pagar['valor'] = number_format((float) $pagar['valor'], 2, ',', '');
        $form->Voltar->setAttribs(array('onClick' => "parent.location='/ContasReceber/index/idVenda/" . $pagar['idVenda'] . "'"));

        $form->populate($pagar);

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $values['valorPagar'] = str_replace(',', '.', $values['valorPagar']);
                $values['valorPago'] = $values['valorPago'] + $values['valorPagar'];
                $date = new DateTime(date("Y-m-d"));
                if ($values['restante'] <= 0) {
                    $atualizar = array(
                        'valorPago' => $values['valorPago'],
                        'pagamento' => $date->format('Y-m-d'),
                        'situacao' => 1
                    );
                } else {
                    $atualizar = array(
                        'valorPago' => $values['valorPago'],
                        'pagamento' => $date->format('Y-m-d'),
                    );
                }
                $db->update('contasreceber', $atualizar, 'idContasR = ' . $values['idContasR']);
                $modelCR = new Application_Model_DbTable_Contasreceber();
                $CR = $modelCR->fetchRow("idContasR = $idCR")->toArray();
                $existVenda = $modelCR->fetchAll("idVenda = " . $CR['idVenda'] . " and situacao = 0")->toArray();

                if (count($existVenda) == 0) {
                    $modelVenda = new Application_Model_DbTable_Venda();
                    $modelVenda->update(array('situacao' => 3), "idVenda = " . $CR['idVenda']);
                }

                $this->_redirect("/ContasReceber/index/idVenda/" . $values['idVenda']);
            }
        }
        $this->view->form = $form;
    }

    public function reciboAction() {
        $id = $this->_getParam('id');

        $db = Zend_Db_Table::getDefaultAdapter();
        $query = "SELECT  c.*, cl.nome
                    FROM
                    contasreceber c
                        left join
                    venda v ON v.idVenda = c.idVenda
                        left join
                    cliente cl ON v.idCliente = cl.idCliente
                    where  idContasR  =  $id";




        $model = $db->query($query);
        $CR = $model->fetch();

        $queryItens = "SELECT descricao as nomeProduto,precoCusto,estoque,  i.*  
                                FROM itemvenda i 
                                LEFT JOIN produto p   
                                ON p.idProduto = i.idProduto
                                where idVenda = " . $CR['idVenda'];
        $resultado = $db->query($queryItens);
        $itens = $resultado->fetchAll();
        
        $this->view->itens = $itens;
        $this->view->CR = $CR;
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
