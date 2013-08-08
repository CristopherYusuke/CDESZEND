<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function validadorAction() {
        $validador = new Zend_Validate_Digits();
        $string = "valor";

        $resultado = $validador->isValid($string);
        if ($resultado) {
            echo "ok";
        } else {
            $erros = $validador->getMessages();
            print_r($erros);
        }
    }

}

