<?php

require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

/**
 * Author : Mahefa & Company
 * @Email : abelmahefa@gmail.com
 */
class ModuleInstaller {

    public static function install(){
        return self::installSql();
    }

    public static function uninstall(){
        return self::uninstallSql();
    }

    private static function installSql(){
        $request = "
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_logger;
            CREATE TABLE "._DB_PREFIX_."sma_logger ( 
                `id` INT NOT NULL AUTO_INCREMENT , 
                `source` VARCHAR(128) , 
                `details` TEXT NOT NULL ,
                `uid` VARCHAR(128) NULL ,
                `level` VARCHAR(32) NULL DEFAULT 'info',
                `date_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`id`)
            );
        ";

        $result = \Db::getInstance()->execute($request);

        Logger::log("ModuleInstaller::installSql");

        return $result;
    }

    private static function uninstallSql(){
        $request = "
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_logger;
        ";

        $result = \Db::getInstance()->execute($request);

        Logger::log("ModuleInstaller::uninstallSql");

        return $result;
    }

}