<?php

class Logger {

    public static function log($detail){
        $this->logSQL($detail);
    }

    public static function logSQL($detail){
        \Db::getInstance()->insert('sma_logger', array(
            'details' => $detail,
        ));
    }

}