<?php



require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";



class ModuleInstaller {



    public static function install(){

        self::_installTab();
        return self::installSql();

    }



    public static function uninstall(){

        self::_uninstallTab();
        return self::uninstallSql();

    }



    private static function installSql(){

        //DROP TABLE IF EXISTS "._DB_PREFIX_."sma_logger;
        $request = "

            CREATE TABLE IF NOT EXISTS "._DB_PREFIX_."sma_logger ( 

                `id` INT NOT NULL AUTO_INCREMENT , 

                `source` VARCHAR(128) , 

                `details` TEXT NOT NULL , 

                `date_add` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 

                PRIMARY KEY (`id`)

            );

            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."sma_seller_acct` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `id_seller` int(11) NOT NULL,
                `id_acct` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            );

            
            CREATE TABLE IF NOT EXISTS `"._DB_PREFIX_."sma_transfer_rejected` (
                `id` INT NOT NULL AUTO_INCREMENT , 
                `id_seller` int(11) NOT NULL,
                `id_order` int(11) NOT NULL,
                `id_acct` varchar(255) NOT NULL,
                `amount` double NOT NULL,
                `message` text NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_seller_acct;
            DROP TABLE IF EXISTS "._DB_PREFIX_."sma_transfer_rejected;

        ";



        //$result = \Db::getInstance()->execute($request);



        Logger::log("ModuleInstaller::uninstallSql");



        return $result;

    }

    protected static function _installTab()
    {
        Logger::log("ModuleInstaller::_installTab", [], "");
        
        $tab = new Tab();
        $tab->class_name = 'AdminAcct';
        $tab->module = "stripe_marketplace_automatizer";
        $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentPreferences');
        $tab->icon = 'settings_applications';
        $languages = Language::getLanguages();
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = 'Vendeur';
        }
        try {
            $tab->save();
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
 
        return true;
    }

    protected static function _uninstallTab()
    {
        Logger::log("ModuleInstaller::_uninstallTab", [], "");
        
        $tabId = (int)Tab::getIdFromClassName('AdminAcct');
        if (!$tabId) {
            return true;
        }
        $tab = new Tab($tabId);
        $tab->delete();
 
        return true;
    }

}