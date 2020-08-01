<?php

class Logger {

    public static function log($detail){
        self::logSQL($detail);
    }

    /**
     * $detail : Array
     */
    public static function logSQL($source, $detail = []){
        \Db::getInstance()->insert('sma_logger', array(
            'source' => $source,
            'details' => json_encode($detail),
        ));
    }

}