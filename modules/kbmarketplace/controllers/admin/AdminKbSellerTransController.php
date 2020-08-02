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

require_once dirname(__FILE__).'/AdminKbMarketplaceCoreController.php';

class AdminKbSellerTransController extends AdminKbMarketplaceCoreController
{
    private $transaction_type  = array();
    private $display_view_type = true;

    public function __construct()
    {
        $this->bootstrap      = true;
        $this->lang           = false;
        $this->display        = 'list';
        $this->allow_export   = true;
        $this->context        = Context::getContext();
        $this->explicitSelect = true;

        parent::__construct();

        $this->transaction_type = array(
            KbSellerTransaction::KB_TRANSACTION_CREDIT_TYPE => $this->module->l('Credit', 'adminkbsellertranscontroller'),
            KbSellerTransaction::KB_TRANSACTION_DEBIT_TYPE => $this->module->l('Debit', 'adminkbsellertranscontroller'),
        );

        $this->fields_list = array(
            'seller_name' => array(
                'title' => $this->module->l('Seller', 'adminkbsellertranscontroller'),
                'havingFilter' => true,
            ),
            'email' => array(
                'title' => $this->module->l('Email', 'adminkbsellertranscontroller'),
                'havingFilter' => true,
                'filter_key' => 'c!email'
            )
        );
//        d(Tools::getAllValues());
        if ((Tools::getIsset('transaction_view_type') && Tools::getValue('transaction_view_type') == 1) || Tools::getIsset('submitFilterkb_mp_seller_transaction') || Tools::getIsset('submitResetkb_mp_seller_transaction')) {
            $this->table         = 'kb_mp_seller_transaction';
            $this->className     = 'KbSellerTransaction';
            $this->identifier    = 'id_seller';
            $this->toolbar_title = $this->module->l('Transactions', 'adminkbsellertranscontroller').' - '.$this->module->l('Transaction History', 'adminkbsellertranscontroller');
            $this->_select       = ' CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `seller_name`, c.`email`';
            $this->_orderBy .= 'a.date_add';
            $this->_orderWay .= 'DESC';
            $this->_join .= ' INNER JOIN '._DB_PREFIX_.'kb_mp_seller as sl on (a.id_seller = sl.id_seller)
				INNER JOIN `'._DB_PREFIX_.'customer` c ON (sl.`id_customer` = c.`id_customer`)';

            if (Tools::getIsset('id_seller') && (int) Tools::getValue('id_seller')
                > 0) {
                $this->display_view_type = true;
                $this->_where .= ' AND a.id_seller = '.(int) Tools::getValue('id_seller');

                $sleer       = new KbSeller((int) Tools::getValue('id_seller'));
                $seller_info = $sleer->getSellerInfo();
                if ($seller_info && count($seller_info) > 0) {
                    $this->toolbar_title = $this->module->l('Transactions', 'adminkbsellertranscontroller').' - '
                        .$this->module->l('Transaction History', 'adminkbsellertranscontroller').' ('.$seller_info['seller_name'].')';
                }
            }

            $part1             = array(
                'transaction_number' => array(
                    'title' => $this->module->l('Transaction ID', 'adminkbsellertranscontroller'),
                ),
                'transaction_type' => array(
                    'title' => $this->module->l('Type', 'adminkbsellertranscontroller'),
                    'type' => 'select',
                    'list' => $this->transaction_type,
                    'havingFilter' => true,
                    'callback' => 'renderTransactionType',
                    'filter_key' => 'a!transaction_type',
                    'order_key' => 'transaction_type',
                    'search' => true
                ),
                'comment' => array(
                    'title' => $this->module->l('Comment', 'adminkbsellertranscontroller'),
                ),
                'amount' => array(
                    'title' => $this->module->l('Amount', 'adminkbsellertranscontroller'),
                    'align' => 'text-right',
                    'type' => 'price',
                    'currency' => true,
                    'callback' => 'setCurrency'
                ),
                'date_add' => array(
                    'title' => $this->module->l('Transaction Date', 'adminkbsellertranscontroller'),
                    'align' => 'text-right',
                    'type' => 'date',
                    'filter_key' => 'a!date_add'
                )
            );
            $this->fields_list = array_merge($this->fields_list, $part1);
            $this->addRowAction('');
        } else {
            $this->table         = 'kb_mp_seller';
            $this->className     = 'KbSeller';
            $this->identifier    = 'id_seller';
            $this->_orderBy .= 'balance';
            $this->_orderWay .= 'DESC';
            $this->toolbar_title = $this->module->l('Transactions', 'adminkbsellertranscontroller').' - '.$this->module->l('Seller Balance History', 'adminkbsellertranscontroller');
            $this->_select = ' CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `seller_name`, a.`id_seller`,
				`er`.`total_earning`, `er`.`seller_earning`, `er`.`admin_earning`, `st`.`paid_amount`,
				(IF(er.seller_earning IS NOT NULL,er.seller_earning,0)
				- IF(st.paid_amount IS NOT NULL,st.paid_amount,0)) AS `balance`';

            $this->_join .= 'INNER JOIN `'._DB_PREFIX_.'customer` c ON (a.`id_customer` = c.`id_customer`)';
            $this->_join .= '
				LEFT JOIN (SELECT `id_seller`, SUM(product_count) AS `product_count`,
				SUM(total_earning) AS `total_earning`, SUM(seller_earning) AS `seller_earning`,
				SUM(admin_earning) AS `admin_earning` FROM '._DB_PREFIX_.'kb_mp_seller_earning
				GROUP BY id_seller)
				as er ON (er.id_seller = a.id_seller)';

            $this->_join .= '
				LEFT JOIN (SELECT id_seller, SUM(amount) AS `paid_amount`
				FROM '._DB_PREFIX_.'kb_mp_seller_transaction
				WHERE 1 GROUP BY id_seller) as `st` ON (st.id_seller = a.id_seller)';

            $part1 = array(
                'total_earning' => array(
                    'title' => $this->module->l('Total Earning', 'adminkbsellertranscontroller'),
                    'align' => 'text-right',
                    'type' => 'price',
                    'currency' => true,
                    'callback' => 'setCurrency'
                ),
                'admin_earning' => array(
                    'title' => $this->module->l('Your Commision', 'adminkbsellertranscontroller'),
                    'align' => 'text-right',
                    'type' => 'price',
                    'currency' => true,
                    'callback' => 'setCurrency'
                ),
                'seller_earning' => array(
                    'title' => $this->module->l('Seller Earning', 'adminkbsellertranscontroller'),
                    'align' => 'text-right',
                    'type' => 'price',
                    'currency' => true,
                    'callback' => 'setCurrency'
                )
            );

            $this->fields_list = array_merge($this->fields_list, $part1);

            $this->fields_list['paid_amount'] = array(
                'title' => $this->module->l('Amount Transfered', 'adminkbsellertranscontroller'),
                'type' => 'price',
                'currency' => true,
                'callback' => 'setCurrency'
            );
            $this->fields_list['balance']     = array(
                'title' => $this->module->l('Balance', 'adminkbsellertranscontroller'),
                'type' => 'price',
                'currency' => true,
                'callback' => 'setCurrency'
            );

            $this->addRowAction('tranaction');
        }

        $this->page_header_toolbar_title = $this->toolbar_title;
    }

    public function postProcess()
    {
        parent::postProcess();

        if (Tools::isSubmit('submitNewTransaction') && Tools::getValue('submitNewTransaction')
            == 1) {
            $this->saveNewTransaction();
        }
    }

    public function setMedia()
    {
        parent::setMedia();
    }

    public function renderTransactionType($echo, $tr)
    {
        unset($echo);
        return $this->transaction_type[$tr['transaction_type']];
    }

    public function initContent()
    {
        $tpl                           = $this->custom_smarty->createTemplate('kb_new_transaction_form.tpl');
        $helper                        = new HelperForm();
        $helper->show_toolbar          = false;
        $helper->default_form_language = $this->context->language->id;
        $transactionHistory_url = $this->context->link->getAdminLink('AdminKbSellerTrans').'&transaction_view_type=1';
        if ($this->display_view_type) {
            $transactionHistory_url = (Tools::getValue('submitFilterkb_mp_seller_transaction'))?$transactionHistory_url.'&submitFilterkb_mp_seller_transaction=1':$transactionHistory_url;
            $view_type = array(
                array(
                    'id_type' => $this->context->link->getAdminLink('AdminKbSellerTrans').'&transaction_view_type=0',
                    'name' => $this->module->l('Seller Balance History', 'adminkbsellertranscontroller')
                ),
                array(
                    'id_type' => $transactionHistory_url,
                    'name' => $this->module->l('Transaction History', 'adminkbsellertranscontroller')
                ),
            );

            $fields_options = array(
                'form' => array(
                    'legend' => array(
                        'title' => $this->module->l('Transaction View Type', 'adminkbsellertranscontroller'),
                        'icon' => 'icon-cogs'
                    ),
                    'input' => array(
                        array(
                            'type' => 'select',
                            'label' => $this->module->l('Select Type', 'adminkbsellertranscontroller'),
                            'name' => 'transaction_view_type',
                            'onchange' => 'changeTransactionView(this)',
                            'options' => array(
                                'query' => $view_type,
                                'id' => 'id_type',
                                'name' => 'name'
                            )
                        )
                    )
                )
            );

            $field_value                          = array();
            $field_value['transaction_view_type'] = $this->context->link->getAdminLink('AdminKbSellerTrans')
                .'&transaction_view_type=0';
            if (Tools::getIsset('transaction_view_type') && Tools::getValue('transaction_view_type')
                == 1) {
                $field_value['transaction_view_type'] = $this->context->link->getAdminLink('AdminKbSellerTrans')
                    .'&transaction_view_type=1';
            }

            $helper->tpl_vars = array('fields_value' => $field_value);
            $tpl->assign('transaction_view_type', $helper->generateForm(array($fields_options)));
            $tpl->assign('new_transaction_id_seller', 0);

            $sql = 'Select CONCAT(c.`firstname`, \' \', c.`lastname`) AS `seller_name`, c.`email`, s.id_seller
				FROM '._DB_PREFIX_.'kb_mp_seller as s INNER JOIN '._DB_PREFIX_.'customer c
				ON (s.`id_customer` = c.`id_customer`)';
        } else {
            $tpl->assign('new_transaction_id_seller', (int) Tools::getValue('id_seller'));
            $tpl->assign('transaction_view_type', '');

            $sql = 'Select CONCAT(c.`firstname`, \' \', c.`lastname`) AS `seller_name`, c.`email`, s.id_seller
				FROM '._DB_PREFIX_.'kb_mp_seller as s INNER JOIN '._DB_PREFIX_.'customer c
				ON (s.`id_customer` = c.`id_customer`)
				Where s.id_seller = '.(int) Tools::getValue('id_seller');
        }

        $results = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $sellers = array(
            array(
                'id_seller' => 0,
                'name' => $this->module->l('Choose Seller', 'adminkbsellertranscontroller')
            )
        );

        if (count($results) > 0) {
            foreach ($results as $result) {
                $sellers[] = array(
                    'id_seller' => $result['id_seller'],
                    'name' => $result['seller_name'].'('.$result['email'].')'
                );
            }
        }

        $transaction_type = array(
            array(
                'transaction_type' => KbSellerTransaction::KB_TRANSACTION_CREDIT_TYPE,
                'name' => $this->module->l('Credit', 'adminkbsellertranscontroller')
            ),
            array(
                'transaction_type' => KbSellerTransaction::KB_TRANSACTION_DEBIT_TYPE,
                'name' => $this->module->l('Debit', 'adminkbsellertranscontroller')
            ),
        );

        $fields_options = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->module->l('Make New Transaction', 'adminkbsellertranscontroller'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Select Seller', 'adminkbsellertranscontroller'),
                        'required' => true,
                        'class' => 'isIntExcludeZero',
                        'name' => 'new_transaction[id_seller]',
//                        'onchange' => 'updateBalField(this)',
                        'options' => array(
                            'query' => $sellers,
                            'id' => 'id_seller',
                            'name' => 'name'
                        ),
                        'col' => '6',
                    ),
                    array(
                        'type' => 'text',
                        'class' => 'isGenericName',
                        'required' => true,
                        'name' => 'new_transaction[id_transaction]',
                        'label' => $this->module->l('Transaction ID', 'adminkbsellertranscontroller'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->module->l('Type', 'adminkbsellertranscontroller'),
                        'required' => true,
                        'class' => 'fixed-width-sm isInt',
                        'name' => 'new_transaction[transaction_type]',
//                        'onchange' => 'updateBalField(this)',
                        'options' => array(
                            'query' => $transaction_type,
                            'id' => 'transaction_type',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'required' => true,
                        'class' => 'isPrice',
                        'name' => 'new_transaction[amount]',
                        'id' => 'new_transaction_amount',
                        'label' => $this->module->l('Amount', 'adminkbsellertranscontroller'),
                        'required' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'name' => 'new_transaction[comment]',
                        'label' => $this->module->l('Comment', 'adminkbsellertranscontroller')
                    ),
                    array(
                        'type' => 'checkbox',
                        'name' => 'new_transaction',
                        'values' => array(
                            'query' => array(
                                array(
                                    'val' => 1,
                                    'send_mail' => 'send_mail',
                                    'label' => $this->module->l('Send Notification to Seller', 'adminkbsellertranscontroller')
                                )
                            ),
                            'id' => 'send_mail',
                            'name' => 'label'
                        )
                    )
                ),
                'buttons' => array(
                    array(
                        'id' => 'kb-new-transaction-submit',
                        'title' => $this->module->l('Save', 'adminkbsellertranscontroller'),
                        'class' => 'btn btn-default pull-right',
                        'icon' => 'process-icon-save',
                        'js' => 'validateKbNewTransactionForm()',
                    )
                )
            )
        );

        $field_value = array(
            'new_transaction[id_seller]' => 0,
            'new_transaction[id_transaction]' => '',
            'new_transaction[transaction_type]' => KbSellerTransaction::KB_TRANSACTION_CREDIT_TYPE,
            'new_transaction[amount]' => 0,
            'new_transaction[comment]' => '',
            'new_transaction_send_mail' => 0
        );

        $helper->tpl_vars = array('fields_value' => $field_value);


        $helper->table         = 'kb_new_transaction';
        $helper->currentIndex  = $this->context->link->getAdminLink('AdminKbSellerTrans');
        $helper->submit_action = 'submitNewTransaction';

        $tpl->assign('new_transaction_form', $helper->generateForm(array($fields_options)));
        $tpl->assign('kb_form_heading', $this->module->l('Add New Transaction', 'adminkbsellertranscontroller'));
        $tpl->assign('kb_admin_trans_error', $this->module->l('Please provide information with valid values. Example: Transaction amount must be greater than 0.', 'adminkbsellertranscontroller'));
        $tpl->assign('kb_admin_trans_new_txt', $this->module->l('Add New Transaction', 'adminkbsellertranscontroller'));
        $tpl->assign('kb_admin_trans_close_txt', $this->module->l('Close Transaction Form', 'adminkbsellertranscontroller'));
        $tpl->assign('transactionHistory_url', $transactionHistory_url);
        $this->content .= $tpl->fetch();
        parent::initContent();
    }

    public function initToolbar()
    {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
    }

    public function getList(
        $id_lang,
        $orderBy = null,
        $orderWay = null,
        $start = 0,
        $limit = null,
        $id_lang_shop = null
    ) {
        parent::getList($id_lang, $orderBy, $orderWay, $start, $limit, $id_lang_shop);
    }

    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
    }

    public static function setCurrency($echo, $tr)
    {
        unset($tr);
        return Tools::displayPrice($echo);
    }

    /**
     * Display link to view/edit order
     */
    public function displayTranactionLink($token = null, $id = 0, $name = null)
    {
        unset($token);
        unset($name);
        $tpl = $this->custom_smarty->createTemplate('transaction_list_action.tpl');
        $tpl->assign(
            'view_link',
            $this->context->link->getAdminLink('AdminKbSellerTrans')
            .'&transaction_view_type=1&id_seller='.(int) $id
        );
        $tpl->assign('id_seller', (int) $id);
        $tpl->assign('view_trans_title', $this->module->l('view all transaction of this seller', 'adminkbsellertranscontroller'));
        $tpl->assign('new_trans_title', $this->module->l('click to make new transaction', 'adminkbsellertranscontroller'));
        return $tpl->fetch();
    }

    protected function saveNewTransaction()
    {
        $transaction_params = Tools::getValue('new_transaction');
        if (isset($transaction_params['id_seller']) && $transaction_params['id_seller']
            > 0) {
            $amount = $transaction_params['amount'];

            if ($transaction_params['transaction_type'] == KbSellerTransaction::KB_TRANSACTION_DEBIT_TYPE) {
                $amount = '-'.$amount;
            }

            $seller      = new KbSeller($transaction_params['id_seller']);
            $transaction = new KbSellerTransaction();

            $transaction->id_seller          = $transaction_params['id_seller'];
            $transaction->id_shop            = $seller->id_shop;
            $transaction->transaction_number = $transaction_params['id_transaction'];
            $transaction->transaction_type   = $transaction_params['transaction_type'];
            $transaction->amount             = $amount;
            $transaction->comment            = $transaction_params['comment'];
            $transaction->id_employee        = $this->context->employee->id;

            if ($transaction->save()) {
                $this->context->cookie->__set(
                    'kb_redirect_success',
                    $this->module->l('New Transaction history has been saved.', 'adminkbsellertranscontroller')
                );
                if (Tools::getIsset('new_transaction_send_mail')) {
                    $email_template_id_key = 'mp_seller_amount_credit_transfer_notification';
                    if ($transaction_params['transaction_type'] == KbSellerTransaction::KB_TRANSACTION_DEBIT_TYPE) {
                        $email_template_id_key = 'mp_seller_amount_debit_transfer_notification';
                    }

                    $seller_info = $seller->getSellerInfo();

                    $formatted_amount = Tools::displayPrice($transaction_params['amount']);

                    //send email to Seller
                    $template_vars       = array(
                        '{{shop_title}}' => $seller_info['title'],
                        '{{seller_name}}' => $seller_info['seller_name'],
                        '{{seller_email}}' => $seller_info['email'],
                        '{{amount}}' => $formatted_amount,
                        '{{comment}}' => $transaction_params['comment'],
                        '{{seller_contact}}' => $seller_info['phone_number']
                    );
                    $email = new KbEmail(
                        KbEmail::getTemplateIdByName($email_template_id_key),
                        $seller_info['id_default_lang']
                    );
                    $notification_emails = $seller->getEmailIdForNotification();
                    foreach ($notification_emails as $em) {
                        $email->send($em['email'], $em['title'], null, $template_vars);
                    }
                }
            } else {
                $this->context->cookie->__set(
                    'kb_redirect_error',
                    $this->module->l('Error occurred while saving transaction history.', 'adminkbsellertranscontroller')
                );
            }
        }
        Tools::redirectAdmin($this->context->link->getAdminLink('AdminKbSellerTrans'));
    }
}
