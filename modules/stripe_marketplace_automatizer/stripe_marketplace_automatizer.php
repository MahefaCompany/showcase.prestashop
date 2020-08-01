<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

class stripe_marketplace_automatizer
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
    }

    public function install()
    {
        if (!parent::install()) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

}
