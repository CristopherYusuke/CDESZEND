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
        $db = Zend_Db_Table::getDefaultAdapter();
        $where = ' where situacao = 0';
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $where = "where situacao = " . $data['situacao'] . " and nome like('%" . $data['nome'] . "%')";
            } else {
                $form->populate($data);
            }
        }
        $query = "SELECT nome, v.*,sum(i.total) as totalVenda 
                  from venda v 
                  left join cliente c 
                  on c.idCliente = v.idCliente 
                  left join itemvenda i 
                  on i.idVenda = v.idVenda 
                  $where 
                  group by idVenda";
        $model = $db->query($query);
        $this->view->venda = $model->fetchAll();
        $this->view->form = $form;
    }

    public function createAction() {
        $erro = false;
        $mensagem = null;
        $form = new Application_Form_Venda_Venda();
        $formIten = new Application_Form_Venda_Itens();
        $itens = new Application_Model_DbTable_Itemvenda();
        $db = Zend_Db_Table::getDefaultAdapter();
        $resultado = $db->query("SELECT descricao as nomeProduto,precoCusto ,i.*  
                                FROM itemvenda i 
                                LEFT JOIN produto p   
                                ON p.idProduto = i.idProduto ");
        $itensTabela = $resultado->fetchAll();
        $idvenda = (int) $this->_getParam('idVenda');
        $delete = (int) $this->_getParam('delete');
        $update = (int) $this->_getParam('update');
        if ($idvenda > 0) {
            $vendaTabela = new Application_Model_DbTable_Venda();
            $clienteTabela = new Application_Model_DbTable_Cliente();
            $venda = $vendaTabela->fetchRow("idVenda = " . $idvenda)->toArray();
            $cliente = $clienteTabela->fetchRow('idCliente = ' . $venda['idCliente'])->toArray();
            $form->cliente->setValue($cliente['nome']);
            $formIten->idVenda->setValue($venda['idVenda']);
            $form->dataVenda->setValue($this->converteData($venda['dataVenda']));
            switch ($venda['situacao']) {
                case 0: $situacao = 'Aberta';
                    break;
                case 1: $situacao = 'Cancelada';
                    break;
                case 2: $situacao = 'Faturada';
                    break;
                case 3: $situacao = 'Finalizada';
                    break;
                case 4: $situacao = 'Extornada';
                    break;
                default: $situacao = "outro";
                    break;
            };

            $form->situacao->setValue($situacao);
        }
        if ($delete > 0) {
            $idvendaValue = $formIten->idVenda->getValue();
            $itens->delete("idItemVenda = $delete");
            $this->_redirect("/venda/create/idVenda/$idvendaValue");
        }
        if ($update > 0) {
            $formIten->getElement('addIten')->setLabel('Atualizar Item');
            $itemAtualizar = $itens->fetchRow("idItemVenda = $update")->toArray();
            $itemAtualizar['total'] = str_replace('.', ',', $itemAtualizar['total']);
            $itemAtualizar['vendaPreco'] = str_replace('.', ',', $itemAtualizar['vendaPreco']);
            $formIten->populate($itemAtualizar);
        }

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($formIten->isValid($data)) {
                $valor = $formIten->getValues();
                $valor['total'] = (float) str_replace(',', '.', $valor['total']);
                $valor['vendaPreco'] = (float) str_replace(',', '.', $valor['vendaPreco']);
                if ($valor['vendaPreco'] > 0 && $valor['total'] > 0) {
                    if ($itensTabela['precoCusto'] > $valor['vendaPreco']) {
                        if ($update == null) {
                            $itens->insert($valor);
                            $this->_redirect("/venda/create/idVenda/" . $valor['idVenda']);
                        } else {
                            $itens->update($valor, 'idItemVenda = ' . $valor['idItemVenda']);
                            $this->_redirect("/venda/create/idVenda/" . $valor['idVenda']);
                        }
                    } else {
                        $mensagem = "O preço de venda não pode ser menor que o preço de custo ";
                        $erro = TRUE;
                    }
                } else {
                    $mensagem = "não pode conter preços negativos";
                    $erro = TRUE;
                }
                $valor['total'] = (float) str_replace('.', ',', $valor['total']);
                $valor['vendaPreco'] = (float) str_replace('.', ',', $valor['vendaPreco']);
                $formIten->populate($valor);
                $this->view->form = $form;
            } else {
                $formIten->populate($data);
                $this->view->form = $form;
            }
        }
        $this->view->mensagem = $mensagem;
        $this->view->erro = $erro;
        $this->view->itens = $itensTabela;
        $this->view->form = $form;
        $this->view->formIten = $formIten;
    }

    public function addvendaAction() {
        if ($this->_getParam('idCliente') != null) {
            $id = (int) $this->_getParam('idCliente');
            $model = new Application_Model_DbTable_Venda();
            $vendaExiste = $model->fetchRow("idCliente = $id and situacao = 0 ");
            if (!isset($vendaExiste)) {
                $idVenda = $model->insert(array('idCliente' => $id,
                    'situacao' => 0,
                    'dataVenda' => date('Y/m/d')
                ));
            } else {
                $arrayVenda = $vendaExiste->toArray();
                $idVenda = $arrayVenda['idVenda'];
            }

            $this->_redirect("/venda/create/idVenda/$idVenda");
        }
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

