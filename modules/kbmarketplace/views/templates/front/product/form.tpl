<script type="text/javascript" src='{$tiny_mce_js_file}' ></script>{*Variable contains URL content, escape not required*}
<div class="kb-content">
    {if !isset($permission_error)}
    <div class="kb-content-header">
        <h1>{$product_form_heading|escape:'htmlall':'UTF-8'}</h1>
        <div class="clearfix"></div>
    </div>
    {/if}
    <a href="form.tpl"></a>
    {if $step eq 1}
        {include file=$product_template_dir|cat:"product_type.tpl"}
    {elseif $step eq 2}
        {if !isset($permission_error)}
        <form id="kb-product-form" action="{$form_submit_url|escape:'htmlall':'UTF-8'}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="productformkey" value="{$formkey|escape:'htmlall':'UTF-8'}" />
            <input type="hidden" name="id_product" value="{$id_product|intval}" />
            <div id="kb-product-form-global-msg" class="kbalert kbalert-danger" style="display:none;"><i class="icon-exclamation-sign"></i></div>
            {if $id_product > 0}
            <div class="kbbtn-group kb-tleft" style="float:left;">
                <select id='kb_lang_slector' class="btn-sm btn-info" style='margin-top: -5%;'>
                    {foreach $languages as $language}                    
                        <option {if $default_lang == $language['id_lang']} selected {/if} value='{$language['id_lang']|escape:'htmlall':'UTF-8'}'>{$language['name']|escape:'htmlall':'UTF-8'}</option>
                    {/foreach}
                </select>
            </div>
            <div class="kbbtn-group kb-tright">
                <a href="{$duplicate_link|escape:'htmlall':'UTF-8'}" id="kb_product_duplicate_btn" class="kbbtn btn-info" title="{l s='click to clone this product' mod='kbmarketplace'}"><i class="icon-copy"><span>{l s='Duplicate' mod='kbmarketplace'}</span></i></a>
                <a href="javascript:void(0)" onclick='{$delete_link_js|escape:'htmlall':'UTF-8'}' class="kbbtn btn-danger" title="{l s='click to delete this product' mod='kbmarketplace'}"><i class="icon-trash"><span>{l s='Delete' mod='kbmarketplace'}</span></i></a>
            </div>
            {else}
                <div class="kbbtn-group kb-tright">
                    <select id='kb_lang_slector' class="btn-sm btn-info" style='margin-top: -5%;'>
                        {foreach $languages as $language}                    
                            <option {if $default_lang == $language['id_lang']} selected {/if} value='{$language['id_lang']|escape:'htmlall':'UTF-8'}'>{$language['name']|escape:'htmlall':'UTF-8'}</option>
                        {/foreach}
                    </select>
                </div>
            {/if}
            <div class="kbalert kbalert-info" {if $id_product > 0} style='margin-top: 3%;'{/if}>
                <i class="icon-question-sign"></i>{l s='Fields marked with (*) are mandatory fields.' mod='kbmarketplace'}
            </div>
            {if count($tabs_display) > 0}
                {foreach $tabs_display as $tab_form}
                    {$tab_form}{*Variable contains css and html content, escape not required*}
                {/foreach}
            {/if}
            {hook h="displayKbMarketPlacePForm" product_id=$id_product type=$product_type form="parentform"}
            <div class='kb-vspacer5'></div>
            <input id="kb_submission_type" type="hidden" name="submitType" value="save" />
            <input type="hidden" id="kb_product_type" name="type_product" value="{$product_type|intval}" />
            <button type="button" class='kbbtn-big kbbtn-default' onclick="submitProductForm('savenstay')">{l s='Save and Stay' mod='kbmarketplace'}</button>
            <button type="button" class='kbbtn-big kbbtn-success' onclick="submitProductForm('save')">{l s='Save' mod='kbmarketplace'}</button>
        </form>
        {addJsDef kb_id_product=$id_product|intval}
        {addJsDef kb_editor_lang=$editor_lang|escape:'htmlall':'UTF-8'}
        {addJsDef kb_default_lang=$default_lang|intval}
        {addJsDefL name=kb_form_validation_error}{l s='Please fill the detail with valid values.'|escape:'htmlall':'UTF-8' mod='kbmarketplace' js=1}{/addJsDefL}
        <script>
            var kb_img_format = [];

            {foreach $kb_img_frmats as $for}
                kb_img_format.push('{$for|escape:'htmlall':'UTF-8'}');
            {/foreach}
            var kb_chars_limit = "{l s='The name can not be greater than 128 characters.Kindly check the same for all languages.' mod='kbmarketplace'}";
            var kb_desc_limit_initial = "{l s='Short description can not be greater than ' mod='kbmarketplace'}";
            var kb_desc_limit_after = "{l s=' characters .Kindly check the same for all languages.' mod='kbmarketplace'}";
            var json_languages = {$json_languages nofilter};{*Variables contain JSON, can not escape this.*}
            var short_desc_limit = {$short_desc_limit|intval};            
            var kb_product_types = [];
            var kb_product_type_simple = {$type_simple|intval};
            var kb_product_type_pack = {$type_pack|intval};
            var kb_product_type_virtual = {$type_virtual|intval};
            kb_product_types.push(kb_product_type_simple, kb_product_type_pack, kb_product_type_virtual);    
        </script>
        {/if}
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