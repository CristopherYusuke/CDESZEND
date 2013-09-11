<?php
abstract class Application_Model_DbTable_Base_Itemvenda extends Zend_Db_Table_Abstract {
	protected $_name = 'itemvenda';
	protected $_referenceMap	= array(
		'ref1' => array(
			'columns'		   => array('idVenda'),
			'refTableClass'	 => 'Model_DbTable_Venda',
			'refColumns'		=> array('idVenda')
		),
		'ref2' => array(
			'columns'		   => array('idProduto'),
			'refTableClass'	 => 'Model_DbTable_Produto',
			'refColumns'		=> array('idProduto')
		)
	);
}