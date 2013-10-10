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
        $idvenda = (int) $this->_getParam('idVenda');
        $delete = (int) $this->_getParam('delete');
        $update = (int) $this->_getParam('update');
        $db = Zend_Db_Table::getDefaultAdapter();
        $form->Faturar->setAttrib('onClick', "parent.location='/ContasReceber/create/idVenda/$idvenda'");
        $resultado = $db->query("SELECT descricao as nomeProduto,precoCusto,estoque,  i.*  
                                FROM itemvenda i 
                                LEFT JOIN produto p   
                                ON p.idProduto = i.idProduto
                                where idVenda = $idvenda ");
        $itensTabela = $resultado->fetchAll();
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
            $itemAtualizar['total'] = number_format($itemAtualizar['total'], 2, ',', '');
            $itemAtualizar['vendaPreco'] = number_format($itemAtualizar['vendaPreco'], 2, ',', '');
            $formIten->populate($itemAtualizar);
        }

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($formIten->isValid($data)) {
                $valor = $formIten->getValues();
                $valor['total'] = str_replace(',', '.', $valor['total']);
                $valor['vendaPreco'] = str_replace(',', '.', $valor['vendaPreco']);
                $valor['precoCusto'] = str_replace(',', '.', $valor['precoCusto']);
                if ($valor['vendaPreco'] > 0 && $valor['total'] > 0) {
                    if ($valor['precoCusto'] <= $valor['vendaPreco']) {     
                        if ($valor['qtde'] <= $valor['estoque']) {
                            unset($valor['precoCusto']);
                            unset($valor['estoque']);
                            if ($update == null) {
                                $itens->insert($valor);
                                $this->_redirect("/venda/create/idVenda/" . $valor['idVenda']);
                            } else {
                                $itens->update($valor, 'idItemVenda = ' . $valor['idItemVenda']);
                                $this->_redirect("/venda/create/idVenda/" . $valor['idVenda']);
                            }
                        } else {
                            $mensagem = "A quantidade de produto e superior a oque tem no estoque ";
                            $erro = TRUE;
                        }
                    } else {
                        $mensagem = "O preço de venda não pode ser menor que o preço de custo ";
                        $erro = TRUE;
                    }
                } else {
                    $mensagem = "não pode conter preços negativos";
                    $erro = TRUE;
                }

                $valor['total'] = number_format($valor['total'], 2, ',', '');
                $valor['vendaPreco'] = number_format($valor['vendaPreco'], 2, ',', '');
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

    public function cancelAction() {
        $idVenda = $this->_getParam("idVenda");
        $model = new Application_Model_DbTable_Venda();
        $model->update(array('situacao' => 1), "idVenda = $idVenda");
        $this->_redirect('/venda');
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

