<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";
// require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/ModuleInstaller.php";
// require_once _PS_MODULE_DIR_.'/stripe_official/classes/StripePayment.php';
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";


class Creation
{
    private $db;
    private $conf;

    public function __construct(){

        $this->uid = $this->generateUid();
        $this->db = \Db::getInstance();
        $this->conf['sma_currency'] = Configuration::get("SMA_CURRENCY");
        $this->conf['sma_country'] = Configuration::get("SMA_COUNTRY");
        $this->conf['stripe_key'] = "sk_test_srgpz8vJRxo0mar9tGsjfOJU";

        foreach ($this->getAllSeller() as $row) {
            $nom = $row['firstname']." ".$row['lastname'];
            $id_acct = $this->create_account(str_replace("'", " ", $nom));
            $idSellerAcct = \Db::getInstance()->insert('sma_seller_acct', [
                'id_seller' => $row['id_seller'],
                'id_acct' => $id_acct,
            ]);
            if(isset($id_acct)){
                Logger::log("Creation::__construct:".__LINE__, [
                    'message' => "Seller created (stripe and sma_seller_acct)",
                    'idSellerAcct' => $idSellerAcct
                ], '');
                //$this->notifyOwnerThatSellerCreated($params['newCustomer'], $data['id_seller'], $data['id_acct']);
            }else{
                Logger::log("Creation::__construct:".__LINE__, [
                    'message' => "Seller not created (has a problem)",
                ], '');
            }
        }

        // Logger::log("WebHookStripe::__contruct", [
        //     'seller' => $this->getAllSeller(),
        // ], $this->uid);
    }

    private function getAllSeller($exist_sma_acct = false)
    {
        $request = "select u1.id_seller, u3.firstname, u3.lastname from " . _DB_PREFIX_ . "kb_mp_seller u1 LEFT JOIN " . _DB_PREFIX_ . "customer u3 ON u1.id_customer = u3.id_customer";
        if(! $exist_sma_acct)
        {
            $request .= " where not exists (select id_seller  from " . _DB_PREFIX_ . "sma_seller_acct u2 where u1.id_seller=u2.id_seller)";
        }
        return $this->db->executeS($request);
    }

    public function create_account($nom)
    {
        require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
        $stripe = new \Stripe\StripeClient($this->conf['stripe_key']);

        try{
            $tokenResult = $stripe->tokens->create([
                'account' => [
                    // 'individual' => [
                    //     'first_name' => 'Jane',
                    //     'last_name' => 'Doe',
                    // ],
                    'company' => [
                        'name' => $nom,
                        // 'last_name' => $nom,
                    ],
                    'tos_shown_and_accepted' => true,
                ],
            ]);
            Logger::log("Creation::create_account:".__LINE__, [
                'tokenResult' => $tokenResult,
            ]);

            $createResult = $stripe->accounts->create([
                'type' => 'custom',
                'country' => $this->conf['sma_country'],
                'default_currency' => $this->conf['sma_currency'],
                'requested_capabilities' => [
                  'card_payments',
                  'transfers',
                ],
                // 'business_profile' => [
                //     'name' => $nom
                // ],
                // 'business_type' => "individual",
                'settings' => [
                    'payouts' => [
                        'schedule' => [
                            'interval' => 'monthly',
                            'monthly_anchor' => 31,
                        ],
                    ],
                ],
                'account_token' => $tokenResult->id,
            ]);
            Logger::log("Creation::create_account:".__LINE__, [
                'createResult' => str_replace("'", " ", $nom),
            ]);

            $accUpdateResult = $stripe->accounts->update(
                $createResult->id,
                [
                    'tos_acceptance' => [
                    'date' => time(),
                    'ip' => $_SERVER['REMOTE_ADDR'], // Assumes you're not using a proxy
                    ],
                ]
            );
            Logger::log("Creation::create_account:".__LINE__, [
                'accUpdateResult' => $accUpdateResult,
            ]);
    
        }catch (Exception $e){
            Logger::log("Creation::create_account:".__LINE__, [
                'message' => str_replace("'", " ", $nom),
            ], '', 'error');
            return null;
        }
        return $createResult->id;
    }

    private function generateUid(){
        return md5(uniqid());
    }
}


new Creation();
die;