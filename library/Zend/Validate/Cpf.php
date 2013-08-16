<?php

class Zend_Validate_Cpf extends Zend_Validate_Abstract
{
   const INVALID = 'cpfInvalid';
    protected $_messageTemplates = array(
        self::INVALID   => "'%value%' is an invalid CPF",
    );
    public function isValid($value) {
        $this->_setValue($value);
        $value = preg_replace('[-|\.]', '', $value);
        for ($i = 9; $i < 11; $i++) {
            for ($d = 0, $c = 0; $c < $i; $c++) {
                $d += $value{$c} * (($i + 1) - $c);
            }
 
            $d = ((10 * $d) % 11) % 10;

            if ($value{$c} != $d) {
                $this->_error(self::INVALID);
                return false;
            }
        }
        return true;
    }

}
