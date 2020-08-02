<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";
require_once _PS_MODULE_DIR_.'/stripe_official/classes/StripePayment.php';

/**
 * Author : Mahefa & Company
 * @Email : abelmahefa@gmail.com
 */
class WebHookStripe
{
    private $uid;

    public function __construct(){
        $this->uid = $this->generateUid();
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
    }

    /**
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

        StripePayment::getBy($paymentIntentID);
    }

    private function generateUid(){
        return md5(uniqid());
    }
}

// Run the hook
new WebHookStripe();