<div id="kb-marketplace-layout" class="outer-border pad5">
    {if $HOOK_KBLEFT_COLUMN && $HOOK_KBRIGHT_COLUMN}
        {include file=$kb_layout_dir|cat:"col3_layout.tpl"}
    {elseif $HOOK_KBLEFT_COLUMN || $HOOK_KBRIGHT_COLUMN}
        {include file=$kb_layout_dir|cat:"col2_layout.tpl"}
    {elseif $TEMPLATE}
    <div id="kblayout-centercol" class="center_column col-xs-12 col-sm-12 pad0">
        <div class="kb-block kb-panel centerlftoffest">
            {if isset($waiting_for_approval)}
                <div class="kbalert kbalert-warning">
                    <i class="icon-exclamation-sign"></i>{l s='Your seller account has been created and waiting for Admin approval.' mod='kbmarketplace'}
                </div>
            {/if}
            {if isset($approval_link)}
                <div class="kbalert kbalert-warning">
                    <i class="icon-exclamation-sign"></i>{l s='Your seller account has been disapproved by Admin.' mod='kbmarketplace'} <a href="{$approval_link|escape:'htmlall':'UTF-8'}">{l s='Click' mod='kbmarketplace'}</a> {l s='to again send request for account approval.' mod='kbmarketplace'}
                </div>
            {/if}
            
            {if isset($account_dissaproved)}
                <div class="kbalert kbalert-warning">
                    <i class="icon-exclamation-sign"></i>{l s='Your seller account has been disapproved by Admin.' mod='kbmarketplace'}
                </div>
            {/if}
            
            {if isset($account_disabled)}
                <div class="kbalert kbalert-warning">
                    <i class="icon-exclamation-sign"></i>{l s='Your seller account is inactive.' mod='kbmarketplace'}
                </div>
            {/if}
            {if isset($kb_confirmation) && is_array($kb_confirmation) && count($kb_confirmation) > 0}
                <div class="kbalert kbalert-success">
                    <ul>
                        {foreach $kb_confirmation as $con}
                            <li>{$con|escape:'htmlall':'UTF-8'}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {if isset($kb_errors) && is_array($kb_errors) && count($kb_errors) > 0}
                <div class="kbalert kbalert-danger">
                    <ul>
                        {foreach $kb_errors as $err}
                            <li>{$err|escape:'htmlall':'UTF-8'}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}
            {$TEMPLATE}{*Variable contains css and html content, escape not required*}
        </div>
    </div>
    {/if}
    <div class="clearfix"></div>
    {if isset($mobile_device)}
    {addJsDef is_mobile_device=$mobile_device|intval}
    {/if}
    {if isset($kb_image_path)}
    {addJsDef kb_img_seller_path=$kb_image_path|escape:'htmlall':'UTF-8'}
    {/if}
    {if isset($kb_current_request)}
    {addJsDef kb_current_request=$kb_current_request}{*Variable contains url, escape not required*}
    {/if}
    {if isset($ajax_error)}
    {addJsDef kb_ajax_request_fail_err=$ajax_error|escape:'htmlall':'UTF-8'}
    {/if}
    {if isset($required_field_error)}
    {addJsDef kb_required_field=$required_field_error|escape:'htmlall':'UTF-8'}
    {/if}
    {if isset($invalid_field_error)}
    {addJsDef kb_invalid_field=$invalid_field_error|escape:'htmlall':'UTF-8'}
    {/if}
    {if isset($kb_image_size_limit)}
    {addJsDef kb_image_size_limit=$kb_image_size_limit|intval}
    {/if}
    {addJsDefL name=kb_delete_confirmation}{l s='Are you sure?' mod='kbmarketplace' js=1}{/addJsDefL}
    {addJsDefL name=kb_search_product}{l s='Search Product' mod='kbmarketplace' js=1}{/addJsDefL}
    {addJsDefL name=kb_enter2_chars}{l s='Please enter 2 or more character(s)' mod='kbmarketplace' js=1}{/addJsDefL}
    {addJsDefL name=kb_pro_remove_img}{l s='Remove' mod='kbmarketplace' js=1}{/addJsDefL}
    {addJsDefL name=kb_select_suppliers_text}{l s='Select Suppliers' mod='kbmarketplace' js=1}{/addJsDefL}
</div>
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