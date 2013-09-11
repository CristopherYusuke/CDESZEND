<?php
abstract class Application_Model_DbTable_Base_Venda extends Zend_Db_Table_Abstract {
	protected $_name = 'venda';
	protected $_referenceMap	= array(
		'ref1' => array(
			'columns'		   => array('idCliente'),
			'refTableClass'	 => 'Model_DbTable_Cliente',
			'refColumns'		=> array('idCliente')
		)
	);
}