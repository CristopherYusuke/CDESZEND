<?php

abstract class Application_Model_DbTable_Base_Compra extends Zend_Db_Table_Abstract {

    protected $_name = 'compra';
    protected $_referenceMap = array(
        'ref1' => array(
            'columns' => array('idFornecedor'),
            'refTableClass' => 'Model_DbTable_Fornecedor',
            'refColumns' => array('idFornecedor')
        )
    );

}