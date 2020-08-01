<?php

require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

class ModuleInstaller {

    public function install(){
        return $this->installSql();
    }

    public function uninstall(){
        return $this->uninstallSql();
    }

    private function installSql(){
        $request = "
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_logger;
            CREATE TABLE "._DB_PREFIX_."sma_logger ( 
                `id` INT NOT NULL AUTO_INCREMENT , 
                `details` TEXT NOT NULL , 
                `date_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`id`)
            );
        ";

        \Db::getInstance()->execute($request);

        Logger::log("ModuleInstaller::installSql");
    }

    private function uninstallSql(){
        $request = "
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_logger;
        ";

        \Db::getInstance()->execute($request);

        Logger::log("ModuleInstaller::uninstallSql");
    }

}