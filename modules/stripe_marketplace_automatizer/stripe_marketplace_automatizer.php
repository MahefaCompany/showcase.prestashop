<?php



if (!defined('_PS_VERSION_')) {

    exit;

}



require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/ModuleInstaller.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";
define("__STRIPE_KEY__", Configuration::get("STRIPE_TEST_KEY"));
define("__COUNTRY__", "US");
define("__CURRENCY__", "usd");

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

        // $this->tab = 'payments_gateways';

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
                    $data['id_acct'] = $this->create_account($params['newCustomer']->lastname .' '. $params['newCustomer']->firstname);
                    $idSellerAcct = \Db::getInstance()->insert('sma_seller_acct', $data);
                    if(isset($data['id_acct'])){
                        Logger::log("stripe_marketplace_automatizer::hookActionCustomerAccountAdd", [
                            'message' => "Seller created (stripe and sma_seller_acct)",
                            'idSellerAcct' => $idSellerAcct
                        ], '');
                        $this->notifyOwnerThatSellerCreated($params['newCustomer']);
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
                'message' => $e->getMessage(),
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

    public function create_account($nom)
    {
        require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
        $stripe = new \Stripe\StripeClient(__STRIPE_KEY__);

        try{
            $res = $stripe->accounts->create([
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
            ]);
    
        }catch (Exception $e){
            Logger::log("stripe_marketplace_automatizer::create_account", [
                'message' => $e->getMessage(),
            ], '', 'error');
            return null;
        }

        return $res->id;
    }

    private function notifyOwnerThatSellerCreated($newCustomer){
        
    }

}

