<div class="kb-content">
    {if !isset($permission_error)}
        <div class="kb-content-header">
            <h1>{$form_heading|escape:'htmlall':'UTF-8'}</h1>
            <div class="clearfix"></div>
        </div>
        <form id="kb-shipping-form" action="{$shipping_submit_url|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="shipping_form" value="1" />
            <div id="kb-shipping-form-global-msg" class="kbalert kbalert-danger" style="display:none;"></div>
            <div class="kbalert kbalert-info">
                <i class="icon-question-sign"></i>{l s='Fields marked with (*) are mandatory fields.' mod='kbmarketplace'}
            </div>
            <div class="kb-panel outer-border">
                <div class='kb-panel-body'>
                    <div class="kb-block kb-form">
                        <ul class="kb-form-list">
                            <li class="kb-form-l">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Name' mod='kbmarketplace'}</span><em>*</em>
                                </div>
                                <div class="kb-form-field-block">
                                    <select class="kb-inpselect" id="kb_mp_shipping_name" name="name">
                                        {if !empty($allowed_shipping)} 
                                            {assign var="ship_selected" value=false}
                                            {foreach $allowed_shipping as $key => $method}
                                                <option value="{$key|escape:'htmlall':'UTF-8'}" {if !empty($carrier->name)}{if $carrier->name == $key}{assign var="ship_selected" value=true}selected{elseif (!$ship_selected && $key == 'other')}selected{/if}{/if}>{$method|escape:'htmlall':'UTF-8'}</option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                    <input type="text" class="kb-inpfield required" id="kb_mp_shipping_name_text" validate="isGenericName" name="name" value="{if !$ship_selected}{$carrier->name|escape:'htmlall':'UTF-8'}{/if}" />
                                   
                                </div>
                            </li>
                            <li class="kb-form-r">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Delay Message' mod='kbmarketplace'}</span><em>*</em>
                                </div>
                                <div class="kb-form-field-block">
                                    <input type="text" class="kb-inpfield required" validate="isGenericName" id="kb_mp_shipping_delay" name="delay_{$default_lang|intval}" value="{$carrier->delay|escape:'htmlall':'UTF-8'}" />
                                </div>
                            </li>
                            <li class="kb-form-l">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Active' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <select name="active" class="kb-inpselect">
                                        <option value="0" {if $carrier->active eq 0}selected="selected"{/if}>{l s='No' mod='kbmarketplace'}</option>
                                        <option value="1" {if $carrier->active eq 1}selected="selected"{/if}>{l s='Yes' mod='kbmarketplace'}</option>
                                    </select>
                                </div>
                            </li>
                            <li class="kb-form-r">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Free Shipping' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <select id='is_free' name="is_free" class="kb-inpselect">
                                        <option value="0" {if $carrier->is_free eq 0}selected="selected"{/if}>{l s='No' mod='kbmarketplace'}</option>
                                        <option value="1" {if $carrier->is_free eq 1}selected="selected"{/if}>{l s='Yes' mod='kbmarketplace'}</option>
                                    </select>
                                </div>
                            </li>
                            <li class="kb-form-fwidth">
                                <div class="form-lbl-indis">
                                    <span class="kblabel">{l s='Logo' mod='kbmarketplace'}</span>
                                    <p class="form-inp-help">{l s='Logo size should be %s.' mod='kbmarketplace' sprintf='40 X 40'}</p>
                                </div>
                                <div class="form-field-indis">
                                    <div class="form-img-display" style='width: 52px;'>
                                        <img id="shipping_logo_placeholder" class="" style='height:40px; width:40px;' src="{$shipping_logo|escape:'htmlall':'UTF-8'}" title="{l s='Logo of your shipping' mod='kbmarketplace'}">
                                    </div>
                                    <input id="shipping_logo" class="" type="file" name="carrier_logo_input" style="display:none;" />
                                    <input type="hidden" id="logo" name="logo" value="" />
                                    <input type="hidden" id="update_shipping_logo" value="0"/>
                                    <input type="hidden" id="is_kb_shipping_logo_updated" value="{$is_kb_shipping_logo_updated|escape:'htmlall':'UTF-8'}"/>
                                    <input type="hidden" id="kb_shipping_default_logo" value="{$ship_default_logo|escape:'quotes':'UTF-8'}"/>
                                    <div class="kb-block file-uploader">
                                         <a href="javascript:void(0)" id="kb_shipping_logo_browse" onclick="$('#shipping_logo').trigger('click');" >{l s='Browse' mod='kbmarketplace'}</a>
                                        {if $is_kb_shipping_logo_updated}
                                            <a href="javascript:void(0)" id="kb_shipping_logo_remove" style="{if $is_kb_shipping_logo_updated|escape:'htmlall':'UTF-8'} display:block;{else} display:none; {/if}" onclick="removeCarrierLogo('{if $is_kb_shipping_logo_updated} {$shipping_logo|escape:'quotes':'UTF-8'} {else} {$ship_default_logo|escape:'htmlall':'UTF-8'} {/if}')" >{l s='Remove' mod='kbmarketplace'}</a>
                                        {else}
                                            <a href="javascript:void(0)" id="kb_shipping_logo_remove"  style="{if $is_kb_shipping_logo_updated|escape:'htmlall':'UTF-8'} display:block;{else} display:none; {/if}" onclick="removeCarrierLogo('{$ship_default_logo|escape:'quotes':'UTF-8'}')" >{l s='Remove' mod='kbmarketplace'}</a>
                                        {/if}
                                        <input id="shipping_logo_update" type="hidden" name="shipping_logo_update" value="0" />
                                    </div>
                                    <div id="shipping_logo_error" class="kb-validation-error"></div>
                                </div>
                            </li>
                            <li class="kb-form-l">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Maximum Package Width' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <div class="kb-labeled-inpfield">
                                        <span class="inplbl">{$ps_dimension_unit|escape:'htmlall':'UTF-8'}</span>
                                        <input type="text" class="kb-inpfield" validate="isPrice" name="max_width" value="{$carrier->max_width|escape:'htmlall':'UTF-8'}" maxlength="14" />
                                    </div>
                                </div>
                            </li>
                            <li class="kb-form-r">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Maximum Package Height' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <div class="kb-labeled-inpfield">
                                        <span class="inplbl">{$ps_dimension_unit|escape:'htmlall':'UTF-8'}</span>
                                        <input type="text" class="kb-inpfield" validate="isPrice" name="max_height" value="{$carrier->max_height|escape:'htmlall':'UTF-8'}" maxlength="14" />
                                    </div>
                                </div>
                            </li>
                            <li class="kb-form-l">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Maximum Package Depth' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <div class="kb-labeled-inpfield">
                                        <span class="inplbl">{$ps_dimension_unit|escape:'htmlall':'UTF-8'}</span>
                                        <input type="text" class="kb-inpfield" validate="isPrice" name="max_depth" value="{$carrier->max_depth|escape:'htmlall':'UTF-8'}" maxlength="14" />
                                    </div>
                                </div>
                            </li>
                            <li class="kb-form-r">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Maximum Package Weight' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <div class="kb-labeled-inpfield">
                                        <span class="inplbl">{$ps_weight_unit|escape:'htmlall':'UTF-8'}</span>
                                        <input type="text" class="kb-inpfield" validate="isPrice" name="max_weight" value="{$carrier->max_weight|escape:'htmlall':'UTF-8'}" maxlength="14" />
                                    </div>
                                </div>
                            </li>
                            <li class="kb-form-fwidth">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Billing' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <div class="kboption-inline kb-inpoption">
                                        <input class="" type="radio" name="shipping_method" id="label_for_shipping_method_price" value="{$shipping_method_price|intval}" {if $carrier->shipping_method == $shipping_method_price}checked="checked"{/if} /> <label for="label_for_shipping_method_price">{l s='According to total price' mod='kbmarketplace'}</label>    
                                    </div>
                                    <div class="kboption-inline kb-inpoption">
                                        <input class="" type="radio" name="shipping_method" id="label_for_shipping_method_weight" value="{$shipping_method_weight|intval}"  {if $carrier->shipping_method == $shipping_method_weight}checked="checked"{/if} /> <label  for="label_for_shipping_method_weight">{l s='According to total weight' mod='kbmarketplace'}</label>    
                                    </div>
                                </div>
                            </li>
                            <!-- to add tax field done by rishabh jain on 19th july 2018-->
                            <li class="kb-form-fwidth">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Tax' mod='kbmarketplace'}</span>
                                </div>
                                <div class="kb-form-field-block">
                                    <select class="kb-inpselect" id="tax_rule" name="tax_rule">
                                          {if !empty($tax_rules)} 
                                            {foreach $tax_rules as $tax}
                                                <option value="{$tax['id']|intval}" {if $tax_id eq $tax['id']} selected {/if} >{$tax['name']|escape:'htmlall':'UTF-8'}</option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                    
                                </div>
                            </li>
                            <!-- chnages over -->
                            
                            <li class="kb-form-fwidth">
                                <div class="kb-form-label-block">
                                    <span class="kblabel ">{l s='Ranges' mod='kbmarketplace'}</span>
                                    <p class="form-inp-help">{l s='Please provide valid range before using any checkbox, shown below the set range boxes.' mod='kbmarketplace'}</p>
                                </div>
                                {include file="./ranges.tpl"}
                                <div class='kb-vspacer5'></div>
                                <button type="button" class='kbbtn btn-warning' onclick="add_new_range();">{l s='Add New Range' mod='kbmarketplace'}</button>
                            </li>
                            {if isset($mapping_shipping) && mapping_shipping}
                            <li class="kb-form-fwidth kb-table-list" style="padding-left: 20px;">
                                <div class="kb-form-field-block">
                                    <div class="kboption-inline kb-inpoption">
                                        <input class="" type="checkbox" name="mapped_all" id="label_for_mapped_shipping_method" value="1"/> <label for="label_for_mapped_shipping" style="font-weight: bold;">{l s='Map this shipping with all products' mod='kbmarketplace'}</label>    
                                    </div>
                                </div>
                            </li>
                            {/if}
                        </ul>
                    </div>
                </div>
            </div>
            <div class='kb-vspacer5'></div>
            <button id='saveShippingBtn' type="button" class='kbbtn-big kbbtn-success' onclick="validateForm()">{l s='Save' mod='kbmarketplace'}</button>
        </form>
        {addJsDef zones_nbr=(count($zones)+3)|intval}
        {addJsDef kb_id_carrier=$carrier->id|intval}
        {addJsDef kb_default_lang=$default_lang|intval}
        {addJsDef kb_shipping_currency_unit=$ps_currency_unit|escape:'htmlall':'UTF-8'}
        {addJsDef kb_shipping_weight_unit=$ps_weight_unit|escape:'htmlall':'UTF-8'}
        {addJsDefL name=kb_shipping_range_price}{l s='Will be applied when the price is'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=kb_shipping_range_weight}{l s='Will be applied when the weight is'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=kb_form_validation_error}{l s='Please fill the detail with valid values.'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=invalid_range}{l s='This range is not valid'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=range_is_overlapping}{l s='Ranges are overlapping'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=select_at_least_one_zone}{l s='Please select at least one zone'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=need_to_validate}{l s='Please validate the last range before create a new one.'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=delete_range_confirm}{l s='Are you sure?'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        {addJsDefL name=labelDelete}{l s='Delete'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        <script>
            var kb_img_format = [];

            {if isset($kb_shipping_logo_path)}
                var kb_shipping_logo_path = "{$kb_shipping_logo_path|escape:'quotes':'UTF-8'}";
            {else}
                var kb_shipping_logo_path = '';  
            {/if}
            var kb_shipping_url = "{$kb_shipping_url|escape:'quotes':'UTF-8'}";
            {foreach $kb_img_frmats as $for}
                kb_img_format.push('{$for|escape:'htmlall':'UTF-8'}');
            {/foreach} 
        </script>
    {/if}
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
