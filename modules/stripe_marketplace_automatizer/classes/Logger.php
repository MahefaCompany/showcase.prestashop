<?php

/**
 * Author : Mahefa & Company
 * @Email : abelmahefa@gmail.com
 */
class Logger {

    public static function log($source, $detail = []){
        self::logSQL($source, $detail);
    }

    /**
     * $detail => data : Array
     */
    public static function logSQL($source, $detail = [], $uid = '', $level = 'info'){
        \Db::getInstance()->insert('sma_logger', array(
            'source' => $source,
            'details' => json_encode($detail),
            'uid' => $uid,
            'level' => $level,
        ));
    }

}