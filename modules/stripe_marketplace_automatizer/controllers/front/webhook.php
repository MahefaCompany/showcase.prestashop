<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

class WebHookStripe
{
    public function __construct(){
        Logger::log("WebHookStripe::__construct", [$_GET, $_POST]);
    }

    // public function initContent(){
    //     Logger::log("WebHookStripe::initContent");
    //     parent::initContent();
    // }

    // public function postProcess(){
    //     Logger::log("WebHookStripe::postProcess");
    // }
}

new WebHookStripe();