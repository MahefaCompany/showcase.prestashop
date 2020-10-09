<?php
echo "this is Approuve file";

require_once __DIR__."/../../../../config/config.inc.php";
require_once __DIR__."/../../vendor/autoload.php";
require_once _PS_MODULE_DIR_ . "/stripe_marketplace_automatizer/classes/Logger.php";
require_once _PS_MODULE_DIR_ . "/stripe_marketplace_automatizer/stripe_marketplace_automatizer.php";

if (!defined('_PS_VERSION_')) {
    exit;
}

Logger::log("approuveAcount.php".__LINE__, [
    'message' => "Passage",
]);

$customer =(object) [
    'id' => getCustomerIdByIdSeller($_POST["idSeller"]),
    'email' => $_POST["email"]
];

// stripe_marketplace_automatizer::createConnectedUser($customer);
Logger::log("approuveAcount.php::getCustomerIdByIdSeller".__LINE__, [
    'customer' => $customer,
]);
function getCustomerIdByIdSeller($_idSeller)
{
    Logger::log("approuveAcount.php::getCustomerIdByIdSeller".__LINE__, [
        'customer' => $_idSeller,
    ]);
    $request = "SELECT id_customer FROM " . _DB_PREFIX_ . "kb_mp_seller WHERE id_seller = '$_idSeller'";
    $customer =  \Db::getInstance()->getRow($request);
    return ($customer) ? $customer['id_customer'] : false;
}

echo "Approuve Successed";
