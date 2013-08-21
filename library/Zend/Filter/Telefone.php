<?php

class Zend_Filter_Telefone implements Zend_Filter_Interface{
    
    public function filter($value) {
        $filtro = new Zend_Filter_Digits();
        $value = $filtro->filter($value);
        
        $parte1 = substr($value, 0,2);
        $parte2 = substr($value,2,4);
        $parte3 = substr($value, 6,10);

        $value =  "(". $parte1 . ")" ." ".$parte2 ."-" . $parte3;
        
        return $value;
    }
    
}

?>
