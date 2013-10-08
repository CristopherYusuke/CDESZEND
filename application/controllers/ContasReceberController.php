<?php

class ContasReceberController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        
    }

    public function createAction() {
        $form = new Application_Form_CR_ContasReceber();
        $db = Zend_Db_Table::getDefaultAdapter();
        if ($this->_request->isPost()) {
            
        } else {
            $idvenda = $this->_getParam('idVenda');
            $resultado = $db->query("SELECT nome, v.*,sum(i.total) as totalVenda 
                  from venda v 
                  left join cliente c 
                  on c.idCliente = v.idCliente 
                  left join itemvenda i 
                  on i.idVenda = v.idVenda 
                  where v.idVenda = $idvenda 
                  group by idVenda");
            $itensTabela = $resultado->fetch();

            $form->cliente->setValue($itensTabela['nome']);
            $form->dataVenda->setValue($this->converteData($itensTabela['dataVenda']));
            $form->totalVenda->setValue(number_format($itensTabela['totalVenda'], 2, ',', ''));
            
            switch ($itensTabela['situacao']) {
                case 0:
                    $form->situacao->setValue('Aberta');
                    break;
                case 1:
                    $form->situacao->setValue( 'Cancelada');
                    break;
                case 2:
                    $form->situacao->setValue('Faturada');
                    break;
                case 3:
                    $form->situacao->setValue('Finalizada');
                    break;
                case 4:
                    $form->situacao->setValue('Extornada');
                    break;
                default:
                     $form->situacao->setValue('outro');
                    break;
            };
        }



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
