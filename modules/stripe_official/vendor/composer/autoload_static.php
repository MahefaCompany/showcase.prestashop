<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita2ac7e4b1daae135a788fdf963aa7bfd
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Stripe_officialClasslib\\' => 24,
            'Stripe\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Stripe_officialClasslib\\' => 
        array (
            0 => __DIR__ . '/..' . '/totpsclasslib/src',
        ),
        'Stripe\\' => 
        array (
            0 => __DIR__ . '/..' . '/stripe/stripe-php/lib',
        ),
    );

    public static $classMap = array (
        'Stripe\\Account' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Account.php',
        'Stripe\\AccountLink' => __DIR__ . '/..' . '/stripe/stripe-php/lib/AccountLink.php',
        'Stripe\\AlipayAccount' => __DIR__ . '/..' . '/stripe/stripe-php/lib/AlipayAccount.php',
        'Stripe\\ApiOperations\\All' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/All.php',
        'Stripe\\ApiOperations\\Create' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/Create.php',
        'Stripe\\ApiOperations\\Delete' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/Delete.php',
        'Stripe\\ApiOperations\\NestedResource' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/NestedResource.php',
        'Stripe\\ApiOperations\\Request' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/Request.php',
        'Stripe\\ApiOperations\\Retrieve' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/Retrieve.php',
        'Stripe\\ApiOperations\\Update' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiOperations/Update.php',
        'Stripe\\ApiRequestor' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiRequestor.php',
        'Stripe\\ApiResource' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiResource.php',
        'Stripe\\ApiResponse' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApiResponse.php',
        'Stripe\\ApplePayDomain' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApplePayDomain.php',
        'Stripe\\ApplicationFee' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApplicationFee.php',
        'Stripe\\ApplicationFeeRefund' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ApplicationFeeRefund.php',
        'Stripe\\Balance' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Balance.php',
        'Stripe\\BalanceTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/BalanceTransaction.php',
        'Stripe\\BankAccount' => __DIR__ . '/..' . '/stripe/stripe-php/lib/BankAccount.php',
        'Stripe\\BitcoinReceiver' => __DIR__ . '/..' . '/stripe/stripe-php/lib/BitcoinReceiver.php',
        'Stripe\\BitcoinTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/BitcoinTransaction.php',
        'Stripe\\Capability' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Capability.php',
        'Stripe\\Card' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Card.php',
        'Stripe\\Charge' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Charge.php',
        'Stripe\\Checkout\\Session' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Checkout/Session.php',
        'Stripe\\Collection' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Collection.php',
        'Stripe\\CountrySpec' => __DIR__ . '/..' . '/stripe/stripe-php/lib/CountrySpec.php',
        'Stripe\\Coupon' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Coupon.php',
        'Stripe\\CreditNote' => __DIR__ . '/..' . '/stripe/stripe-php/lib/CreditNote.php',
        'Stripe\\Customer' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Customer.php',
        'Stripe\\CustomerBalanceTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/CustomerBalanceTransaction.php',
        'Stripe\\Discount' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Discount.php',
        'Stripe\\Dispute' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Dispute.php',
        'Stripe\\EphemeralKey' => __DIR__ . '/..' . '/stripe/stripe-php/lib/EphemeralKey.php',
        'Stripe\\Error\\Api' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Api.php',
        'Stripe\\Error\\ApiConnection' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/ApiConnection.php',
        'Stripe\\Error\\Authentication' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Authentication.php',
        'Stripe\\Error\\Base' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Base.php',
        'Stripe\\Error\\Card' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Card.php',
        'Stripe\\Error\\Idempotency' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Idempotency.php',
        'Stripe\\Error\\InvalidRequest' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/InvalidRequest.php',
        'Stripe\\Error\\OAuth\\InvalidClient' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/InvalidClient.php',
        'Stripe\\Error\\OAuth\\InvalidGrant' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/InvalidGrant.php',
        'Stripe\\Error\\OAuth\\InvalidRequest' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/InvalidRequest.php',
        'Stripe\\Error\\OAuth\\InvalidScope' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/InvalidScope.php',
        'Stripe\\Error\\OAuth\\OAuthBase' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/OAuthBase.php',
        'Stripe\\Error\\OAuth\\UnsupportedGrantType' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/UnsupportedGrantType.php',
        'Stripe\\Error\\OAuth\\UnsupportedResponseType' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/OAuth/UnsupportedResponseType.php',
        'Stripe\\Error\\Permission' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/Permission.php',
        'Stripe\\Error\\RateLimit' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/RateLimit.php',
        'Stripe\\Error\\SignatureVerification' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Error/SignatureVerification.php',
        'Stripe\\Event' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Event.php',
        'Stripe\\ExchangeRate' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ExchangeRate.php',
        'Stripe\\File' => __DIR__ . '/..' . '/stripe/stripe-php/lib/File.php',
        'Stripe\\FileLink' => __DIR__ . '/..' . '/stripe/stripe-php/lib/FileLink.php',
        'Stripe\\HttpClient\\ClientInterface' => __DIR__ . '/..' . '/stripe/stripe-php/lib/HttpClient/ClientInterface.php',
        'Stripe\\HttpClient\\CurlClient' => __DIR__ . '/..' . '/stripe/stripe-php/lib/HttpClient/CurlClient.php',
        'Stripe\\Invoice' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Invoice.php',
        'Stripe\\InvoiceItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/InvoiceItem.php',
        'Stripe\\InvoiceLineItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/InvoiceLineItem.php',
        'Stripe\\IssuerFraudRecord' => __DIR__ . '/..' . '/stripe/stripe-php/lib/IssuerFraudRecord.php',
        'Stripe\\Issuing\\Authorization' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/Authorization.php',
        'Stripe\\Issuing\\Card' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/Card.php',
        'Stripe\\Issuing\\CardDetails' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/CardDetails.php',
        'Stripe\\Issuing\\Cardholder' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/Cardholder.php',
        'Stripe\\Issuing\\Dispute' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/Dispute.php',
        'Stripe\\Issuing\\Transaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Issuing/Transaction.php',
        'Stripe\\LoginLink' => __DIR__ . '/..' . '/stripe/stripe-php/lib/LoginLink.php',
        'Stripe\\OAuth' => __DIR__ . '/..' . '/stripe/stripe-php/lib/OAuth.php',
        'Stripe\\Order' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Order.php',
        'Stripe\\OrderItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/OrderItem.php',
        'Stripe\\OrderReturn' => __DIR__ . '/..' . '/stripe/stripe-php/lib/OrderReturn.php',
        'Stripe\\PaymentIntent' => __DIR__ . '/..' . '/stripe/stripe-php/lib/PaymentIntent.php',
        'Stripe\\PaymentMethod' => __DIR__ . '/..' . '/stripe/stripe-php/lib/PaymentMethod.php',
        'Stripe\\Payout' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Payout.php',
        'Stripe\\Person' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Person.php',
        'Stripe\\Plan' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Plan.php',
        'Stripe\\Product' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Product.php',
        'Stripe\\Radar\\EarlyFraudWarning' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Radar/EarlyFraudWarning.php',
        'Stripe\\Radar\\ValueList' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Radar/ValueList.php',
        'Stripe\\Radar\\ValueListItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Radar/ValueListItem.php',
        'Stripe\\Recipient' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Recipient.php',
        'Stripe\\RecipientTransfer' => __DIR__ . '/..' . '/stripe/stripe-php/lib/RecipientTransfer.php',
        'Stripe\\Refund' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Refund.php',
        'Stripe\\Reporting\\ReportRun' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Reporting/ReportRun.php',
        'Stripe\\Reporting\\ReportType' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Reporting/ReportType.php',
        'Stripe\\RequestTelemetry' => __DIR__ . '/..' . '/stripe/stripe-php/lib/RequestTelemetry.php',
        'Stripe\\Review' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Review.php',
        'Stripe\\SKU' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SKU.php',
        'Stripe\\SetupIntent' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SetupIntent.php',
        'Stripe\\Sigma\\ScheduledQueryRun' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Sigma/ScheduledQueryRun.php',
        'Stripe\\SingletonApiResource' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SingletonApiResource.php',
        'Stripe\\Source' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Source.php',
        'Stripe\\SourceTransaction' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SourceTransaction.php',
        'Stripe\\Stripe' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Stripe.php',
        'Stripe\\StripeObject' => __DIR__ . '/..' . '/stripe/stripe-php/lib/StripeObject.php',
        'Stripe\\Subscription' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Subscription.php',
        'Stripe\\SubscriptionItem' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SubscriptionItem.php',
        'Stripe\\SubscriptionSchedule' => __DIR__ . '/..' . '/stripe/stripe-php/lib/SubscriptionSchedule.php',
        'Stripe\\TaxId' => __DIR__ . '/..' . '/stripe/stripe-php/lib/TaxId.php',
        'Stripe\\TaxRate' => __DIR__ . '/..' . '/stripe/stripe-php/lib/TaxRate.php',
        'Stripe\\Terminal\\ConnectionToken' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Terminal/ConnectionToken.php',
        'Stripe\\Terminal\\Location' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Terminal/Location.php',
        'Stripe\\Terminal\\Reader' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Terminal/Reader.php',
        'Stripe\\ThreeDSecure' => __DIR__ . '/..' . '/stripe/stripe-php/lib/ThreeDSecure.php',
        'Stripe\\Token' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Token.php',
        'Stripe\\Topup' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Topup.php',
        'Stripe\\Transfer' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Transfer.php',
        'Stripe\\TransferReversal' => __DIR__ . '/..' . '/stripe/stripe-php/lib/TransferReversal.php',
        'Stripe\\UsageRecord' => __DIR__ . '/..' . '/stripe/stripe-php/lib/UsageRecord.php',
        'Stripe\\UsageRecordSummary' => __DIR__ . '/..' . '/stripe/stripe-php/lib/UsageRecordSummary.php',
        'Stripe\\Util\\AutoPagingIterator' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/AutoPagingIterator.php',
        'Stripe\\Util\\CaseInsensitiveArray' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/CaseInsensitiveArray.php',
        'Stripe\\Util\\DefaultLogger' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/DefaultLogger.php',
        'Stripe\\Util\\LoggerInterface' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/LoggerInterface.php',
        'Stripe\\Util\\RandomGenerator' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/RandomGenerator.php',
        'Stripe\\Util\\RequestOptions' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/RequestOptions.php',
        'Stripe\\Util\\Set' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/Set.php',
        'Stripe\\Util\\Util' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Util/Util.php',
        'Stripe\\Webhook' => __DIR__ . '/..' . '/stripe/stripe-php/lib/Webhook.php',
        'Stripe\\WebhookEndpoint' => __DIR__ . '/..' . '/stripe/stripe-php/lib/WebhookEndpoint.php',
        'Stripe\\WebhookSignature' => __DIR__ . '/..' . '/stripe/stripe-php/lib/WebhookSignature.php',
        'Stripe_officialClasslib\\Actions\\ActionsHandler' => __DIR__ . '/..' . '/totpsclasslib/src/Actions/ActionsHandler.php',
        'Stripe_officialClasslib\\Actions\\DefaultActions' => __DIR__ . '/..' . '/totpsclasslib/src/Actions/DefaultActions.php',
        'Stripe_officialClasslib\\Db\\DbSchema' => __DIR__ . '/..' . '/totpsclasslib/src/Db/DbSchema.php',
        'Stripe_officialClasslib\\Db\\DbTable' => __DIR__ . '/..' . '/totpsclasslib/src/Db/DbTable.php',
        'Stripe_officialClasslib\\Db\\DbTableDefinitionModel' => __DIR__ . '/..' . '/totpsclasslib/src/Db/DbTableDefinitionModel.php',
        'Stripe_officialClasslib\\Db\\DbTableDefinitionRelation' => __DIR__ . '/..' . '/totpsclasslib/src/Db/DbTableDefinitionRelation.php',
        'Stripe_officialClasslib\\Db\\ObjectModelDefinition' => __DIR__ . '/..' . '/totpsclasslib/src/Db/ObjectModelDefinition.php',
        'Stripe_officialClasslib\\Db\\ObjectModelExtension' => __DIR__ . '/..' . '/totpsclasslib/src/Db/ObjectModelExtension.php',
        'Stripe_officialClasslib\\Extensions\\AbstractModuleExtension' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/AbstractModuleExtension.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\AdminProcessLoggerController' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/AdminProcessLoggerController.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\Classes\\ProcessLoggerObjectModel' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/Classes/ProcessLoggerObjectModel.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\Controllers\\Admin\\AdminProcessLoggerController' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/Controllers/Admin/AdminProcessLoggerController.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\ProcessLoggerExtension' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/ProcessLoggerExtension.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\ProcessLoggerHandler' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/ProcessLoggerHandler.php',
        'Stripe_officialClasslib\\Extensions\\ProcessLogger\\ProcessLoggerObjectModel' => __DIR__ . '/..' . '/totpsclasslib/src/Extensions/ProcessLogger/ProcessLoggerObjectModel.php',
        'Stripe_officialClasslib\\Install\\AbstractInstaller' => __DIR__ . '/..' . '/totpsclasslib/src/Install/AbstractInstaller.php',
        'Stripe_officialClasslib\\Install\\ExtensionInstaller' => __DIR__ . '/..' . '/totpsclasslib/src/Install/ExtensionInstaller.php',
        'Stripe_officialClasslib\\Install\\Installer' => __DIR__ . '/..' . '/totpsclasslib/src/Install/Installer.php',
        'Stripe_officialClasslib\\Install\\ModuleInstaller' => __DIR__ . '/..' . '/totpsclasslib/src/Install/ModuleInstaller.php',
        'Stripe_officialClasslib\\Registry' => __DIR__ . '/..' . '/totpsclasslib/src/Registry.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita2ac7e4b1daae135a788fdf963aa7bfd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita2ac7e4b1daae135a788fdf963aa7bfd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita2ac7e4b1daae135a788fdf963aa7bfd::$classMap;

        }, null, ClassLoader::class);
    }
}