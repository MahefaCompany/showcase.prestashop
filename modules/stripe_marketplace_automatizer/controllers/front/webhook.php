<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";
require_once _PS_MODULE_DIR_.'/stripe_official/classes/StripePayment.php';
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
define("__STRIPE_KEY__", Configuration::get("STRIPE_TEST_KEY"));
define("__CURRENCY__", "usd");

/**
 * Author : Mahefa & Company
 * @Email : abelmahefa@gmail.com
 * 
 * https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/webhook.php
 * https://devdocs.prestashop.com/1.7/development/database/db/
 * 
 */
class WebHookStripe
{
    private $uid;

    private $db;


    public function __construct(){
        sleep(3);
        $this->uid = $this->generateUid();
        $this->db = \Db::getInstance();
        $this->readStreamWebhooks();
    }

    /**
     * https://stripe.com/docs/webhooks/build
     * https://stripe.com/docs/api/webhook_endpoints/update#update_webhook_endpoint-enabled_events
     */
    public function readStreamWebhooks(){
        // Payload : https://gist.github.com/MahefaAbel/36be9a3e4a9ee10a756eae4a128faaf1
        $payload = @file_get_contents('php://input');
        $event = null;
        Logger::log("WebHookStripe::readStreamWebhooks", [
            'GET' => $_GET,
            'POST' => $_POST,
            'payload' => $payload,
        ], $this->uid);
        // die;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            Logger::log("WebHookStripe::readStreamWebhooks", [
                'messages' => "Invalid payload",
            //    'variablaTianaHojerena' => null,
            ], $this->uid, 'error');
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.created':
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                $this->handlePaymentIntentSucceeded($paymentIntent);
                break;
            // case 'payment_method.attached':
            //     $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
            //     // Then define and call a method to handle the successful attachment of a PaymentMethod.
            //     // handlePaymentMethodAttached($paymentMethod);
            //     break;
            // ... handle other event types
            default:
                // Unexpected event type
                Logger::log("WebHookStripe::readStreamWebhooks", [
                    'messages' => "Unexpected event type",
                ], $this->uid, 'error');
                http_response_code(400);
                exit();
        }

        http_response_code(200);
    }

    private function handlePaymentIntentSucceeded($paymentIntent){
        $cart = $this->getCartByPaymentIntentID($paymentIntent->id);
        $orders = $this->getOrdersByCartId($cart);
        $orders = $this->getOrderSeller($orders);
        
        for ($i=0; $i < sizeof($orders); $i++) { 
            if($orders[$i]['id_seller'] != null and $orders[$i]['id_seller'] != false and $orders[$i]['id_acct'] != null and $orders[$i]['id_acct'] != false)
                $this->transfert($orders[$i]);
        }
        
    }

    private function transfert($order)
    {
        $amount = $order['total_paid'] -  (3*$order['total_paid']/100 + 0.40);
        $amount = (int) ($amount * 100);

        $stripe = new \Stripe\StripeClient(__STRIPE_KEY__);
    
        try{
            $stripe->transfers->create([
                'amount' => $amount,
                'currency' => __CURRENCY__,
                'destination' => $order['id_acct'],
                'description' => 'Order no: ' . $order['id_order'] . ' SellerID: '. $order['id_seller'],
            ]);
        } catch (Exception $e) {
            $this->db->insert('sma_transfer_rejected', array(
                'id_seller' => $order['id_seller'],
                'id_order' => $order['id_order'],
                'id_acct' => $order['id_acct'],
                'amount' => $amount / 100,
                'message' => $e->getMessage(),
            ));
        }
    }

    /**
     * Maka ny idCart (Prestashop)
     * https://sql.webmo.fr/pma-sqldedie/sql.php?db=sql10522_1&table=ps_stripe_payment&pos=0
     * https://sql.webmo.fr/pma-sqldedie/sql.php?db=sql10522_1&table=ps_stripe_payment_intent&pos=0
     * https://sql.webmo.fr/pma-sqldedie/sql.php?db=sql10522_1&table=ps_sma_logger&pos=0
     * https://sql.webmo.fr/pma-sqldedie/sql.php?db=sql10522_1&table=ps_orders&pos=0
     * 
     */
    private function getCartByPaymentIntentID($paymentIntentID){
        Logger::log("WebHookStripe::getCartByPaymentIntentID", [
            'messages' => "paymentIntentID:". $paymentIntentID,
        ], $this->uid);

        return $this->getCart($paymentIntentID);
    }

    private function getCart($paymentIntentID){
        $request = "SELECT id_cart FROM " . _DB_PREFIX_ . "stripe_payment WHERE id_payment_intent = '$paymentIntentID'";
        $row =  $this->db->getRow($request);
        return ($row) ? $row['id_cart'] : $row;
    }

    private function getOrdersByCartId($cartId){
        Logger::log("WebHookStripe::getOrdersByCartID", [
            'messages' => "cardID:". $cartId,
        ], $this->uid);

        return $this->getOrders($cartId);
    }

    private function getOrders($cartID)
    {
        $request = "SELECT id_order, total_paid FROM " . _DB_PREFIX_ . "orders WHERE id_cart = '$cartID'";
        return $this->db->executeS($request);
    }

    private function getSellerByOrderId($orderId){
        Logger::log("WebHookStripe::getSellerByOrderId", [
            'messages' => "orderID:". $orderId,
        ], $this->uid);

        return $this->getSeller($orderId);
    }

    private function getSeller($orderId)
    {
        $request = "SELECT id_seller FROM " . _DB_PREFIX_ . "kb_mp_seller_order_detail WHERE id_order = '$orderId'";
        $row =  $this->db->getRow($request);
        return ($row) ? $row['id_seller'] : $row;
    }

    private function getOrderSeller($orders)
    {
        $order_seller = array();
        for ($i=0; $i < sizeof($orders); $i++) { 
            $id_order = $orders[$i]['id_order'];
            $id_seller = $this->getSeller($id_order);
            $order_seller[$i]['id_order'] = $id_order;
            $order_seller[$i]['id_seller'] = $id_seller;
            $order_seller[$i]['id_acct'] = $this->getAcctId($id_seller);
            $order_seller[$i]['total_paid'] = $orders[$i]['total_paid'];
        }

        return $order_seller;
    }

    private function getAcctId($id_seller)
    {
        $request = "SELECT id_acct FROM " . _DB_PREFIX_ . "sma_seller_acct WHERE id_seller = '$id_seller'";
        $row =  $this->db->getRow($request);
        return ($row) ? $row['id_acct'] : $row;
    }

    private function generateUid(){
        return md5(uniqid());
    }

    // protected function _installTab()
    // {
    //     Logger::log("Stripe::_installTab", [
    //         'ok' => "ok",
    //     ], "");
        
    //     $tab = new Tab();
    //     $tab->class_name = 'AdminAcct';
    //     //$tab->module = $this->name;
    //     $tab->id_parent = (int)Tab::getIdFromClassName('AdminParentPreferences');
    //     $tab->icon = 'settings_applications';
    //     $languages = Language::getLanguages();
    //     //var_dump($languages);
    //     foreach ($languages as $lang) {
    //         $tab->name[$lang['id_lang']] = 'Vendeur';
    //     }
    //     try {
    //         $tab->save();
    //     } catch (Exception $e) {
    //         echo $e->getMessage();
    //         return false;
    //     }
 
    //     return true;
    // }

    
}

// Run the hook
new WebHookStripe();