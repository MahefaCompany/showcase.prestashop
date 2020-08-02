<div class='kb-extra-content'>
<a class="btn btn-warning pull-right open_new_transaction_form" href="javascript:void(0)" onclick="openNewTransactionForm(this, {$new_transaction_id_seller|intval})">
    <i class="icon-collapse" id="icon_add_colapse_new_transaction"></i> <span id="kb-new-trabsaction-btn-label">{$kb_form_heading|escape:'htmlall':'UTF-8'}</span>
</a>
<div class='clearfix'></div>    
</div>
<div id="kb-new-transaction-form" style="display:none;">
    {$new_transaction_form}{*Variable contains css and html content, escape not required*}
</div>
<div class="">
    {$transaction_view_type}{*Variable contains css and html content, escape not required*}
</div>
<script type='text/javascript'>
    var transactionHistory_url = "{$transactionHistory_url|escape:'quotes':'UTF-8'}";
    {if (isset($smarty.get.submitFilterkb_mp_seller_transaction) && $smarty.get.submitFilterkb_mp_seller_transaction== '1') || (isset($smarty.get.transaction_view_type) && ($smarty.get.transaction_view_type == '1'))}
        $('select[name="transaction_view_type"]').val(transactionHistory_url);
    {elseif (isset($smarty.get.submitFilterkb_mp_seller_transaction) && $smarty.get.submitFilterkb_mp_seller_transaction == '0')}
        $('select[name="transaction_view_type"]').val(transactionHistory_url);
    {/if}
    var kb_admin_trans_error = "{$kb_admin_trans_error|escape:'htmlall':'UTF-8'}";
    var kb_admin_trans_new_txt = "{$kb_admin_trans_new_txt|escape:'htmlall':'UTF-8'}";
    var kb_admin_trans_close_txt = "{$kb_admin_trans_close_txt|escape:'htmlall':'UTF-8'}";
</script>

{*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer tohttp://www.prestashop.com for more information.
* We offer the best and most useful modules PrestaShop and modifications for your online store.
*
* @category  PrestaShop Module
* @author    knowband.com <support@knowband.com>
* @copyright 2016 knowband
* @license   see file: LICENSE.txt
*}
