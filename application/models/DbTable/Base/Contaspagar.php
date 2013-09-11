<?php
abstract class Application_Model_DbTable_Base_Contaspagar extends Zend_Db_Table_Abstract {
	protected $_name = 'contaspagar';
	protected $_referenceMap	= array(
		'ref1' => array(
			'columns'		   => array('idCompra'),
			'refTableClass'	 => 'Model_DbTable_Compra',
			'refColumns'		=> array('idCompra')
		)
	);
}