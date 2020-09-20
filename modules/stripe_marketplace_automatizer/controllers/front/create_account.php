<?php
require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__."/Liste.php";

if ($_POST) {

    function updateSellerInfo($id_seller, $id_acct){
        $request = "INSERT INTO "._DB_PREFIX_. "sma_seller_acct (id_seller, id_acct) VALUES ('".$id_seller."', '".$id_acct."')";
        return \Db::getInstance()->execute($request);
    }

    \Stripe\Stripe::setApiKey('sk_test_51H9qbOLKOBZ05EFrMyMNKmxekuCiFvRSDWV27qRd351mIW7v0EUmaTcPtbP7LHzHrkIpduQ0O4Zt2trkVHf2aRWh00gSz9Tz2V');
    try {
        if (!isset($_POST['tokenaccount']))
            die(json_encode([
                "code" => "error_not_good_parametter",
                "message" => "tokenAccount missing",
            ]));
        if (!isset($_POST['id_seller']))
            die(json_encode([
                "code" => "error_not_good_parametter",
                "message" => "id_seller missing",
            ]));
        $token = $_POST['tokenaccount'];
        $account = \Stripe\Account::create([
            'country' => 'FR',
            'type' => 'custom',
            'default_currency' => 'eur',
            'requested_capabilities' => [
                'card_payments',
                'transfers',
            ],
            'settings' => [
                'payouts' => [
                    'schedule' => [
                        'interval' => 'monthly',
                        'monthly_anchor' => 31,
                    ],
                ],
            ],
            'account_token' => $token,
        ]);
        if($account["object"] == 'account'){
            $id_seller = $_POST['id_seller'];
            $id_acct = $account["id"];
            updateSellerInfo($id_seller, $id_acct);
            die(json_encode([
                "message" => "successful",
                "resultStripe" => $account,
            ]));
        }else{
            die(json_encode([
                "message" => "error_not_good_response",
                "resultStripe" => $account,
            ]));
        }
    }catch (Exception $e) {
        die(json_encode([
            "message" => "error_exception",
            "resultStripe" => $e->getMessage(),
        ]));
    }
    exit();
}
