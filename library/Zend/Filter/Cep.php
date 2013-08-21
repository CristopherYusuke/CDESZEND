<?php

class Zend_Filter_Cep implements Zend_Filter_Interface{
    
    public function filter($value) {
        $filtro = new Zend_Filter_Digits();
        $value = $filtro->filter($value);
        $parte1 = substr($value, 0,5);
        $parte2 = substr($value,5,3);
        
        $value = $parte1 . "-" .$parte2;
        
        return $value;
    }
    
}


?>
