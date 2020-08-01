<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

class WebHookStripe
{
    public function __construct(){
        Logger::log("WebHookStripe::__construct", [
            'GET' => $_GET, 
            'POST' => $_POST,
        ]);
    }
}

new WebHookStripe();