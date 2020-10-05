<?php
/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 * We offer the best and most useful modules PrestaShop and modifications for your online store.
 *
 * @author    knowband.com <support@knowband.com>
 * @copyright 2017 Knowband
 * @license   see file: LICENSE.txt
 * @category  PrestaShop Module
 */

class AdminKbSellerApprovalListControllerOverride extends AdminKbSellerApprovalListController
{
    public function __construct(){
        parent::__construct();
        var_dump('AdminKbSellerApprovalListControllerOverride::__construct'); die;
    }

    public function processApproveSeller()
    {
        if (Tools::getIsset($this->identifier)) {
            $seller           = new KbSeller(Tools::getValue($this->identifier));
            $seller->approved = KbGlobal::APPROVED;
            $seller->active   = 1;
            $seller->save(true);
            $product = KbSellerProduct::getSellerProducts(
                Tools::getValue($this->identifier),
                false,
                null,
                null,
                null,
                null,
                KbGlobal::APPROVED,
                0
            );
            if (!empty($product)) {
                foreach ($product as $pro) {
                    if ($pro['approved'] == KbGlobal::APPROVED) {
                        $enable_prod = new Product((int)$pro['id_product']);
                        if ($enable_prod->active == 0) {
                            Db::getInstance()->execute(
                                'UPDATE '._DB_PREFIX_.'product'
                                . ' SET active=1,redirect_type="" '
                                . 'WHERE id_product='. (int)$pro['id_product']
                            );
                            Db::getInstance()->execute(
                                'UPDATE '._DB_PREFIX_.'product_shop'
                                . ' SET active=1,redirect_type="" '
                                . 'WHERE id_shop='.(int) $pro['id_shop'] .' AND id_product='. (int)$pro['id_product']
                            );
                        }
                    }
                }
            }
            $customer      = $seller->getSellerInfo();
            $template_vars = array(
                '{{email}}' => $customer['email'],
                '{{full_name}}' => $customer['seller_name']
            );

            $email = new KbEmail(
                KbEmail::getTemplateIdByName('mp_seller_account_approval'),
                $seller->id_default_lang
            );
            $notification_emails = $seller->getEmailIdForNotification();
            foreach ($notification_emails as $em) {
                $email->send($em['email'], $em['title'], null, $template_vars);
            }

            $this->context->cookie->__set(
                'kb_redirect_success',
                $this->module->l('Seller account has been approved successfully. Now, he/she can start selling on store.', 'adminkbsellerapprovallistcontroller')
            );
        }
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminKbSellerApprovalList'));
    }

    public function processDissapproveSeller()
    {
        if (Tools::getIsset($this->identifier)) {
            $seller           = new KbSeller(Tools::getValue($this->identifier));
            $seller->approved = KbGlobal::DISSAPPROVED;
            $seller->save(true);

            $customer      = $seller->getSellerInfo();
            $template_vars = array(
                '{{disapproval_reason}}' => Tools::getValue('marketplace_reason_comment'),
                '{{full_name}}' => $customer['seller_name']
            );

            $email               = new KbEmail(
                KbEmail::getTemplateIdByName('mp_seller_account_disapproval'),
                $seller->id_default_lang
            );
            $notification_emails = $seller->getEmailIdForNotification();
            foreach ($notification_emails as $em) {
                $email->send($em['email'], $em['title'], null, $template_vars);
            }

            $reason_log              = new KbReasonLog();
            $reason_log->reason_type = 1;
            $reason_log->id_seller   = $seller->id;
            $reason_log->id_employee = $this->context->employee->id;
            $reason_log->comment     = Tools::getValue('marketplace_reason_comment');
            $reason_log->save(true);

            $this->context->cookie->__set(
                'kb_redirect_success',
                $this->module->l('Seller account has been disapproved successfully.', 'adminkbsellerapprovallistcontroller')
            );
        }
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminKbSellerApprovalList'));
    }

}
