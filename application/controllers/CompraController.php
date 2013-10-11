<?php

class CompraController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        $form = new Application_Form_Compra_Busca();
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
        $query = "SELECT nome, v.*,sum(i.total) as totalCompra 
                  from compra v 
                  left join fornecedor c 
                  on c.idFornecedor = v.idFornecedor 
                  left join itemcompra i 
                  on i.idCompra = v.idCompra 
                  $where 
                  group by idCompra";
        $model = $db->query($query);
        $this->view->compra = $model->fetchAll();
        $this->view->form = $form;
    }

    public function createAction() {
        $erro = false;
        $mensagem = null;
        $form = new Application_Form_Compra_Compra();
        $formIten = new Application_Form_Compra_Itens();
        $itens = new Application_Model_DbTable_Itemcompra();
        $idcompra = (int) $this->_getParam('idCompra');
        $delete = (int) $this->_getParam('delete');
        $update = (int) $this->_getParam('update');
        $db = Zend_Db_Table::getDefaultAdapter();
        $form->Faturar->setAttrib('onClick', "parent.location='/ContasPagar/create/idCompra/$idcompra'");
        $resultado = $db->query("SELECT descricao as nomeProduto,precoCusto,  i.*  
                                FROM itemcompra i 
                                LEFT JOIN produto p   
                                ON p.idProduto = i.idProduto
                                where idCompra = $idcompra ");
        $itensTabela = $resultado->fetchAll();
        if ($idcompra > 0) {
            $compraTabela = new Application_Model_DbTable_Compra();
            $fornecedorTabela = new Application_Model_DbTable_Fornecedor();
            $compra = $compraTabela->fetchRow("idCompra = " . $idcompra)->toArray();
            $fornecedor = $fornecedorTabela->fetchRow('idFornecedor = ' . $compra['idFornecedor'])->toArray();
            $form->fornecedor->setValue($fornecedor['nome']);
            $formIten->idCompra->setValue($compra['idCompra']);
            $form->dataCompra->setValue($this->converteData($compra['dataCompra']));
            switch ($compra['situacao']) {
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
            $idcompraValue = $formIten->idCompra->getValue();
            $itens->delete("idItemCompra = $delete");
            $this->_redirect("/compra/create/idCompra/$idcompraValue");
        }

        if ($update > 0) {
            $formIten->getElement('addIten')->setLabel('Atualizar Item');
            $modelItem = new Application_Model_DbTable_Itemcompra();
            $itemAtualizar = $modelItem->fetchRow("idItemCompra = $update")->toArray();
            $itemAtualizar['total'] = number_format($itemAtualizar['total'], 2, ',', '');
            $itemAtualizar['compraPreco'] = number_format($itemAtualizar['compraPreco'], 2, ',', '');
            $formIten->populate($itemAtualizar);
        }

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($formIten->isValid($data)) {
                $valor = $formIten->getValues();
                $valor['total'] = str_replace(',', '.', $valor['total']);
                $valor['compraPreco'] = str_replace(',', '.', $valor['compraPreco']);

                if ($valor['compraPreco'] > 0 && $valor['total'] > 0) {
                    if ($update == null) {
                        $itens->insert($valor);
                        $this->_redirect("/compra/create/idCompra/" . $valor['idCompra']);
                    } else {
                        
                        $itens->update($valor, 'idItemCompra = ' . $valor['idItemCompra']);
                        $this->_redirect("/compra/create/idCompra/" . $valor['idCompra']);
                    }
                } else {
                    $mensagem = "não pode conter preços negativos";
                    $erro = TRUE;
                }

                $valor['total'] = number_format($valor['total'], 2, ',', '');
                $valor['compraPreco'] = number_format($valor['compraPreco'], 2, ',', '');
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

    public function addcompraAction() {
        if ($this->_getParam('idFornecedor') != null) {
            $id = (int) $this->_getParam('idFornecedor');
            $model = new Application_Model_DbTable_Compra();
            $compraExiste = $model->fetchRow("idFornecedor = $id and situacao = 0 ");
            if (!isset($compraExiste)) {
                $idCompra = $model->insert(array('idFornecedor' => $id,
                    'situacao' => 0,
                    'dataCompra' => date('Y/m/d')
                ));
            } else {
                $arrayVenda = $compraExiste->toArray();
                $idCompra = $arrayVenda['idCompra'];
            }
            $this->_redirect("/compra/create/idCompra/$idCompra");
        }
    }

    public function cancelAction() {
        $idCompra = $this->_getParam("idCompra");
        $model = new Application_Model_DbTable_Compra();
        $itemVenda = new Application_Model_DbTable_Itemcompra();
        $model->update(array('situacao' => 1), "idCompra = $idCompra");
        $itemVenda->delete($idCompra);
        $this->_redirect('/compra');
    }

    public function extornarAction() {
        $idCompra = $this->_getParam("idCompra");
        $Venda = new Application_Model_DbTable_Compra();
        $itemVenda = new Application_Model_DbTable_Itemcompra();
        $CR = new Application_Model_DbTable_Contasreceber();
        $where = "idCompra = $idCompra";
        $itemVenda->delete($idCompra);
        $Venda->update(array('situacao' => 4), $where);
        $CR->update(array('situacao' => 2), $where);
        $this->_redirect('/compra');
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

