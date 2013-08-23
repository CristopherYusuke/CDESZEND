<?php


class ValidadorController extends Zend_Controller_Action {

    public function cpfAction() {
        $validador = new Zend_Validate_Cpf();
        $string = '08806412907';
        
        $resultado = $validador->isValid($string);
        
        if ($resultado) {
            echo "passou pela validação";
            exit;
        }else{
            print_r($validador->getMessages());
            exit;            
        }
                
    }

}

