<?php

class RelatorioController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
    }

    public function indexAction() {
        
    }

    public function vendapordataAction() {
        $where = "";
        $mensagem = null;
        $form = new Application_Form_Relatorio_VendaPorData();
        $db = Zend_Db_Table::getDefaultAdapter();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $values = $form->getValues();
                $values['dataInicio'] = $this->converteData($values['dataInicio']);
                $values['dataFinal'] = $this->converteData($values['dataFinal']);
               if($values['dataInicio'] < $values['dataFinal']){
                    $where = "where  nome like('%" . $values['nome'] . "%') and dataVenda BETWEEN   '". $values['dataInicio'] ."' AND  '" . $values['dataFinal'] . "'";
                    if(!$values['situacao'] == '' ){
                        $where .= " and situacao = '". $values['situacao']   ."'"; 
                    }
               }else{
                   $mensagem = "data inicio não pode ser menor que a data final ";
               }
                
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
        $this->view->mensagens = $mensagem; 
    }

    public function vendapordataprintAction() {
        
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
