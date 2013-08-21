<?php

class FiltroController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function digitosAction() {
        $filtro = new Zend_Filter_Digits();
        $string = "088.064.129-06";
        $stringFiltro = $filtro->filter($string);
        echo $stringFiltro;
        exit();
    }

    public function cepAction() {
        $filtro = new Zend_Filter_Cep();
        $string = "8720hadkuem00509590000";
        $strigFiltrada = $filtro->filter($string);
        echo $strigFiltrada;
        exit();
    }

    public function telefoneAction() {
        $filtro = new Zend_Filter_Telefone();
        $string = "kjsdfkalçjf44lkfjaksldf9823lsaaf2236";
        $stringFiltrada = $filtro->filter($string);
        echo $stringFiltrada;
        exit();
    }

}

?>
