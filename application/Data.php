<?php

class Application_Data {

    public function __construct() {
        
    }

    public function databr($datasql) {
        if (!empty($datasql)) {
            $p_dt = explode('-', $datasql);
            $data_br = $p_dt[2] . '/' . $p_dt[1] . '/' . $p_dt[0];
            return print $data_br;
        }
    }

// Formata data dd/mm/aaaa para aaaa-mm-dd
    public function datasql($databr) {
        if (!empty($databr)) {
            $p_dt = explode('/', $databr);
            $data_sql = $p_dt[2] . '-' . $p_dt[1] . '-' . $p_dt[0];
            return $data_sql;
        }
    }

// formata data do banco para a view
}

?>
