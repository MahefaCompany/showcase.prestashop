<?php

class Logger {

    public static function log($source, $detail = []){
        self::logSQL($source, $detail);
    }

    /**
     * $detail : Array
     */
    public static function logSQL($source, $detail = []){
        \Db::getInstance()->insert('sma_logger', array(
            'source' => $source,
            'details' => "`".json_encode($detail)."`",
        ));
        // $sql = 'INSERT INTO '._DB_PREFIX_.'sma_logger (source, details) VALUE (`'.pSQL($source).'`, `'.pSQL(json_encode($detail)).'`)';
        // \Db::getInstance()->execute($sql);
    }

}