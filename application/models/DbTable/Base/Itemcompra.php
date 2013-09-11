<?php

abstract class Application_Model_DbTable_Base_Itemcompra extends Zend_Db_Table_Abstract {

    protected $_name = 'itemcompra';
    protected $_referenceMap = array(
        'ref1' => array(
            'columns' => array('idProduto'),
            'refTableClass' => 'Model_DbTable_Produto',
            'refColumns' => array('idProduto')
        ),
        'ref2' => array(
            'columns' => array('idCompra'),
            'refTableClass' => 'Model_DbTable_Compra',
            'refColumns' => array('idCompra')
        )
    );

}