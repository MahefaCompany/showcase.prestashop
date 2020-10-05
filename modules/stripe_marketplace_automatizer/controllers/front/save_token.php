<?php
require_once __DIR__."/../../../../config/config.inc.php";
require_once __DIR__."/../../vendor/autoload.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

if (isset($_POST['email']) && isset($_POST['tokenaccount'])) {

    function updateTokenInfo($email, $token){
        $request = "INSERT INTO "._DB_PREFIX_. "sma_account_token (email, token) VALUES ('".$email."', '".$token."')";
        return \Db::getInstance()->execute($request);
    }

    if(updateTokenInfo($_POST['email'], $_POST['tokenaccount']))
    {
        echo "success";
    }
    exit();
}else{
    Logger::log("save_token", [
        'message' => "",
    ], $this->uid);
}
