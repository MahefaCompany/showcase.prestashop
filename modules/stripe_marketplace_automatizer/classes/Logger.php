<?php

class Logger {

    public static function log($detail){
        self::logSQL($detail);
    }

    public static function logSQL($detail){
        \Db::getInstance()->insert('sma_logger', array(
            'details' => $detail,
        ));
    }

}