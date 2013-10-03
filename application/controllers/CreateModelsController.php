<?php

class CreateModelsController extends Zend_Controller_Action {

    public function init() {
        parent::init();
        if (!Zend_auth::getInstance()->hasIdentity()) {
            $this->_redirect('/login');
        }
        set_time_limit(0);
    }

    public function indexAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $path = APPLICATION_PATH . '\\models\\DbTable';
        $pathBase = $path . '\\Base';

        if (!is_dir($path))
            mkdir($path);
        if (!is_dir($pathBase))
            mkdir($pathBase);

        $db = Zend_Db_Table::getDefaultAdapter();
        $dbConfig = $db->getConfig();

        $model = <<<EOT
<?php
class Application_Model_DbTable_%s extends Application_Model_DbTable_Base_%s {

}
EOT;

        $modelBase = <<<EOT
<?php
abstract class Application_Model_DbTable_Base_%s extends Zend_Db_Table_Abstract {
	protected \$_name = '%s';
%s
}
EOT;

        $refmap_outer = <<<EOT
	protected \$_referenceMap	= array(
%s
	);
EOT;

        $refmap_inner = <<<EOT
		'%s' => array(
			'columns'		   => array('%s'),
			'refTableClass'	 => '%s',
			'refColumns'		=> array('%s')
		)
EOT;

        $toTable = new Zend_Filter_Inflector(':tbl');
        //$toTable->addFilterPrefixPath('ZFKiller_Filter_', 'ZFKiller/Filter/');
        $toTable->addRules(array(':tbl' => array()));

        $toClass = new Zend_Filter_Inflector(':tbl');
        //$toClass->addFilterPrefixPath('ZFKiller_Filter_', 'ZFKiller/Filter/');
        $toClass->addRules(array(':tbl' => array('StringToLower', 'Word_UnderscoreToCamelCase')));

        /* $toClass = new Zend_Filter_Inflector(
          ':tbl',
          //array(':tbl' => array('StringToLower', 'Word_UnderscoreToCamelCase'))
          array(':tbl' => array())
          ); */
        //$toClass = $toTable;

        header('Content-type:text/plain;charset=utf-8');
        foreach ($db->listTables() as $table) {
            echo "$table\n";
            flush();

            $sql = "select
			tc.constraint_name,
			kcu.table_name,
			kcu.column_name,
			kcu.referenced_table_name,
			kcu.referenced_column_name
		from
			information_schema.table_constraints tc,
			information_schema.key_column_usage kcu
		where
			tc.table_name = " . $db->quote($table) . "
			and tc.table_schema = " . $db->quote($dbConfig['dbname']) . "
			and kcu.CONSTRAINT_SCHEMA = " . $db->quote($dbConfig['dbname']) . "
			and tc.constraint_type = 'FOREIGN KEY'
			and kcu.constraint_name = tc.constraint_name";

            $keys = $db->fetchAll($sql);

            // Base
            $refs = array();
            if (!empty($keys)) {
                $r = 0;
                foreach ($keys as $key) {
                    $refs[] = sprintf($refmap_inner, 'ref' . ++$r, $key['column_name'], 'Model_DbTable_' . $toClass->filter(array('tbl' => $key['referenced_table_name'])), $key['referenced_column_name']
                    );
                }

                //echo('<pre>' . print_r($sql, 1));
                //echo('<pre>' . print_r($keys, 1));
                //echo('<pre>' . print_r($refs, 1));
                //exit;
            }

            $className = $toClass->filter(array('tbl' => $table));
            $baseClassFile = $pathBase . '\\' . $className . '.php';
            $h = fopen($baseClassFile, 'w+');
            $content = sprintf($modelBase, $toClass->filter(array('tbl' => $table)), $toTable->filter(array('tbl' => $table)), (!empty($refs) ? sprintf($refmap_outer, join(",\n", $refs)) : '')
            );
            //die('<pre>' . print_r($content, 1));
            fwrite($h, $content);
            fclose($h);

            // Classe
            $classFile = $path . '\\' . $className . '.php';
            if (!file_exists($classFile)) {
                $h = fopen($classFile, 'w+');
                $content = sprintf($model, $className, $className
                );
                fwrite($h, $content);
                fclose($h);
            }
        }

        //header('Content-type:text/html', true);
        exit;
    }

}