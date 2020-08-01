<?php

require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/classes/Logger.php";

class WebHookStripe
{
    public function __construct(){
        $this->readStreamWebhooks();
    }

    /**
     * https://stripe.com/docs/webhooks/build
     * https://stripe.com/docs/api/webhook_endpoints/update#update_webhook_endpoint-enabled_events
     */
    public function readStreamWebhooks(){
        $payload = @file_get_contents('php://input');
        $event = null;

        Logger::log("WebHookStripe::__construct", [
            'GET' => $_GET,
            'POST' => $_POST,
            'payload' => $payload,
        ]);
        die;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
                // Then define and call a method to handle the successful payment intent.
                // handlePaymentIntentSucceeded($paymentIntent);
                break;
            case 'payment_method.attached':
                $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
                // Then define and call a method to handle the successful attachment of a PaymentMethod.
                // handlePaymentMethodAttached($paymentMethod);
                break;
            // ... handle other event types
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        http_response_code(200);
    }
}

new WebHookStripe();