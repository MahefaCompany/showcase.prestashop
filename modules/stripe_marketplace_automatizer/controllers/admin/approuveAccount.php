<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once _PS_MODULE_DIR_ . "/stripe_marketplace_automatizer/classes/Logger.php";
require_once _PS_MODULE_DIR_ . "/stripe_marketplace_automatizer/stripe_marketplace_automatizer.php";

$customer =(object) [
    'id' => getCustomerIdByIdSeller($_POST["idSeller"]),
    'email' => $_POST["email"]
];

stripe_marketplace_automatizer::createConnectedUser($customer);

function getCustomerIdByIdSeller($_idSeller)
{
    Logger::log("approuveAcount.php::getCustomerIdByIdSeller".__LINE__, [
        'customer' => $_idSeller,
    ]);
    $request = "SELECT id_customer FROM " . _DB_PREFIX_ . "kb_mp_seller WHERE id_seller = '$_idSeller'";
    $customer =  \Db::getInstance()->getRow($request);
    return ($customer) ? $customer->id_customer : false;
}
