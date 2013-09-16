<?php

class Zend_Validate_Cpf extends Zend_Validator_cpfCnpjAbstract {
    /**
     * Tamanho do Campo
     * @var int
     */
    protected $_size = 11;
 
    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $_modifiers = array(
        array(10,9,8,7,6,5,4,3,2),
        array(11,10,9,8,7,6,5,4,3,2)
    );
}
