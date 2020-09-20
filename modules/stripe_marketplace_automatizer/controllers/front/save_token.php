<?php
require_once __DIR__."/../../../../config/config.inc.php";
require_once __DIR__."/../../vendor/autoload.php";

if ($_POST) {

    function updateTokenInfo($email, $token){
        $request = "INSERT INTO "._DB_PREFIX_. "sma_account_token (email, token) VALUES ('".$email."', '".$token."')";
        return \Db::getInstance()->execute($request);
    }

    if(updateTokenInfo($_POST['email'], $_POST['tokenaccount']))
    {
        echo "success";
    }
    exit();
}
