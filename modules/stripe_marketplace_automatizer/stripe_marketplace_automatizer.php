<?php



if (!defined('_PS_VERSION_')) {

    exit;

}



require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/ModuleInstaller.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";
define("__STRIPE_KEY__", Configuration::get("STRIPE_TEST_KEY"));
// define("__COUNTRY__", "US");
// define("__CURRENCY__", "usd");
define("__COUNTRY__", "FR");
define("__CURRENCY__", "eur");

class stripe_marketplace_automatizer extends Module

{

    public static $webhook_events = array(

        'charge.expired',

        'charge.failed',

        'charge.succeeded',

        'charge.pending',

        'charge.captured',

        'charge.refunded'

    );



    public function __construct()

    {

        $this->name = 'stripe_marketplace_automatizer';

        $this->version = '1.0.0';

        $this->author = 'Mahefa';

        $this->bootstrap = true;

        $this->display = 'view';

        $this->module_key = 'bb21cb93bbac39159ef3af00bca52354';

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.7.9.99');

        $this->currencies = true;



        parent::__construct();


        $this->meta_title = $this->l('Stripe Marketplace Automatizer', $this->name);

        $this->displayName = $this->l('Stripe Marketplace Automatizer', $this->name);

        $this->description = $this->l('Start accepting stripe payments today, directly from your shop!', $this->name);

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?', $this->name);



        // Logger::log("stripe_marketplace_automatizer::__construct");

    }



    public function install()

    {

        if (
            !parent::install()
            || !$this->registerHook('actionCustomerAccountAdd')
        ) {

            return false;

        }



        if(!ModuleInstaller::install()){

            return false;

        }



        return true;

    }



    public function uninstall()
    {

        if (!parent::uninstall()) {

            return false;

        }



        if(!ModuleInstaller::uninstall()){

            return false;

        }

        

        return true;

    }

    public function hookActionCustomerAccountAdd($params)
    {
        Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
            'params' => $params,
        ]);

        try{
            if(isset($params['newCustomer'])){
                $data['id_seller'] = $this->getSellerByCustomerId($params['newCustomer']->id);
                if($data['id_seller'] != false){ // If seller
                    Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                        'message' => "New customer (Seller)",
                    ], '');
                    $data['id_acct'] = $this->create_account($params['newCustomer']->firstname .' '. $params['newCustomer']->lastname);
                    $idSellerAcct = \Db::getInstance()->insert('sma_seller_acct', $data);
                    if(isset($data['id_acct'])){
                        Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                            'message' => "Seller created (stripe and sma_seller_acct)",
                            'idSellerAcct' => $idSellerAcct
                        ], '');
                        $this->notifyOwnerThatSellerCreated($params['newCustomer'], $data['id_seller'], $data['id_acct']);
                    }else{
                        Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                            'message' => "Seller not created (has a problem)",
                        ], '');
                    }
                }else{
                    Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                        'message' => "New customer (not seller)",
                    ], '');
                }
            }else{
                Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                    'message' => "params not have newCustomer object",
                ], '', 'error');
            }
        }catch (Exception $e){
            Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                'message' => pSQL($e->getMessage()),
            ], '', 'error');
            return null;
        }
        
    }

    private function getSellerByCustomerId($id_customer)
    {
        $request = "SELECT id_seller FROM " . _DB_PREFIX_ . "kb_mp_seller WHERE id_customer = '$id_customer'";
        $row =  \Db::getInstance()->getRow($request);
        return ($row) ? $row['id_seller'] : false;
    }

    /**
     * https://stripe.com/docs/api/tokens/create_account?lang=php
     */
    public function create_account($nom)
    {
        require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
        $stripe = new \Stripe\StripeClient(__STRIPE_KEY__);

        try{
            $tokenResuklt = $stripe->tokens->create([
                'account' => [
                    'individual' => [
                        'first_name' => 'Jane',
                        'last_name' => 'Doe',
                    ],
                    'tos_shown_and_accepted' => true,
                ],
            ]);
            Logger::log("stripe_marketplace_automatizer::create_account:".__LINE__, [
                'tokenResuklt' => $tokenResuklt,
            ]);

            $createResult = $stripe->accounts->create([
                'type' => 'custom',
                'country' => __COUNTRY__,
                'default_currency' => __CURRENCY__,
                'requested_capabilities' => [
                  'card_payments',
                  'transfers',
                ],
                'business_profile' => [
                    'name' => $nom
                ],
                'settings' => [
                    'payouts' => [
                        'schedule' => [
                            'interval' => 'monthly',
                            'monthly_anchor' => 31,
                        ],
                    ],
                ],
                'account_token' => $tokenResuklt->token->id,
            ]);
            Logger::log("stripe_marketplace_automatizer::create_account:".__LINE__, [
                'createResult' => $createResult,
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
            Logger::log("stripe_marketplace_automatizer::create_account:".__LINE__, [
                'accUpdateResult' => $accUpdateResult,
            ]);
    
        }catch (Exception $e){
            Logger::log("stripe_marketplace_automatizer::create_account", [
                'message' => pSQL($e->getMessage()),
            ], '', 'error');
            return null;
        }
        return $createResult->id;
    }

    private function notifyOwnerThatSellerCreated($newCustomer, $idSeller, $idAcct){
        Mail::Send(
 
            // == REQUIRED FIELDS ARE BELOW ==
         
            /* -- Language id --
            Basic context (if available): $this->context->language->id
            Alternative context: Context::getContext()->language->id
            Default store language: Configuration::get('PS_LANG_DEFAULT') */
         
            Context::getContext()->language->id,
            // --------
         
            /* -- Template name --
            Put your mail template into each language folder of /mails/{lang_iso}/ in .html and .txt format. 
            Ex.: my_mail_template.html and my_mail_template.txt.
            You can make your own /mails/ directory with subdirectories with all your language names (just look into /mails/ directory) anywhere you want to - The path will be specified later. */
         
            'new_seller',
            // --------
         
            /* -- Topic -- */
         
            'Hello there!',
            // --------
         
            /* -- Variables --
            Put null if you don't want to send any. Example of array: */
         
            array(
                '{seller_name}' => $newCustomer->firstname .' '. $newCustomer->lastname,
                '{seller_id}' =>  $idSeller,
                '{acct_id}' =>  $idAcct,
                '{date_ins}' =>  date("d-m-Y") ." à ". date("h:i")
            ),
            // --------
         
            /* -- Receiver email address --
            It can be customer email or your email - depending on your needs. 
            Basic context (if available): $this->context->customer->email
            Alternative context: Context::getContext()->language->email
            Your main (BackOffice) email: Configuration::get("PS_SHOP_EMAIL") */
          
            "abelmahefa@gmail.com",
            // --------
         
            // == OPTIONAL FIELDS ARE BELOW ==
         
            /* -- Receiver name --
            This could be firstname and lastname of a customer.
            You can get customer context and just put ->firstname , ->lastname.
            Or just type any name you want to. */
         
            null,
            // --------
         
            /* -- Sender email --
            Could be your store email: Configuration::get("PS_SHOP_EMAIL")
            but better put the null on this */
         
            null,
            // --------
         
            /* -- Sender name --
            Could be Your firstname and lastname, shopname or both. 
            Get shop name: Configuration::get("PS_SHOP_NAME") */
         
            null,
            // --------
         
            /* -- Attachment -- */
         
            null, // replace with $attach variable if you want to send an attachment,
            // --------
         
            /* -- SMTP mode -- */
         
            null, // just put null here
            // --------
         
            /* -- Mails directory -- 
            Path to /mails/ directory with languages iso codes and with your templates. */
         
            _PS_MODULE_DIR_."/stripe_marketplace_automatizer/mails/",
            // --------
         
            /* -- Die after error? --  */
         
            false,
            // --------
         
            /* -- ID Shop -- 
            Basic context (if available):$this->context->shop->id
            Alternative context: Context::getContext()->shop->id
            */
         
            null,
            // --------
         
            /* -- BCC -- 
            Bcc recipient(s) (email address). */
            null,
         
            // --------
         
            /* -- Reply to --
            Email address for setting the Reply-To header. */
         
            null
            // --------
        );
    }

}

