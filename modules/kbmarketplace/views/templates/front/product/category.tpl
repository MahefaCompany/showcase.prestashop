<div class="kb-vspacer5"></div>
<div class="kb-panel outer-border kb_product_section">
    <div data-toggle="kb-product-form-category" class='kb-panel-header kb-panel-header-tab'>
        <h1>{$form_title|escape:'htmlall':'UTF-8'}</h1>
        <div class='kb-accordian-symbol kbexpand'></div>
        <div class='clearfix'></div>
    </div>
    <div id="kb-product-form-category" class='kb-panel-body'>
        <div class="kb-block kb-form">
            <ul class="kb-form-list">
                <li class="kb-form-fwidth">
                    <div class="kb-form-label-block">
                        <span class="kblabel " title="{l s='Categories to which the product will be mapped.' mod='kbmarketplace'}">{l s='Categories' mod='kbmarketplace'}</span><em>*</em>
                        <p class="form-inp-help">{l s='Cannot make home category as default category. In order to add default category please select other categories.'  mod='kbmarketplace'}</p>
                    </div>
                    <div id="kb_category_tree_container" class="kb-form-field-block">
                        
                    </div>
                </li>
                <li class="kb-form-fwidth last-row">
                    <div class="kb-form-label-block">
                        <span class="kblabel " title="{l s='Default category of the product' mod='kbmarketplace'}">{l s='Choose Default Category' mod='kbmarketplace'}</span><em>*</em>
                    </div>
                    <div class="kb-form-field-block">
                        <select id="pro_category_default" name="id_category_default" class="kb-inpselect">
                            {if $default_category > 0}
                                {foreach $categories as $cat}
                                    {if in_array($cat['id_category'], $selected_categories)}
                                        <option value="{$cat['id_category']|intval}" {if $cat['id_category'] eq $default_category}selected="selected"{/if} >{$cat['name']|escape:'htmlall':'UTF-8'}</option>
                                    {/if}
                                    
                                {/foreach}
                            {else}
                                <option value=''>{l s='Select' mod='kbmarketplace'}</option>
                            {/if}
                        </select>
                    </div>
                </li>
            </ul>
            {hook h="displayKbMarketPlacePForm" product_id=$id_product type=$product_type form="category"}
        </div>
    </div>
</div>
<script>
    var product_categories_for_default = [];
    function renderCategoryTree()
    {
        $.ajax({
            type: 'POST',
            headers: { "cache-control": "no-cache" },
            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&')+'rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType : "html",
            data: 'ajax=true'
                +'&method=getAjaxCategoryTree&token=' + static_token
                +'&id_product='+kb_id_product,
            beforeSend: function() {

            },
            success: function(content)
            {
                $('#kb_category_tree_container').html(content);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                jAlert(textStatus);
            }
        });
    }
    
    $(window).load(function(){
        setTimeout(function(){
            renderCategoryTree();
        }, 2000);
    });
    
    $(document).ready(function(){

        {foreach $categories as $cat}
            product_categories_for_default.push(
                {
                    'id_category': {$cat['id_category']|intval},
                    'name': '{$cat['name']|addslashes|escape:'htmlall':'UTF-8'}'
                }
            );
        {/foreach}

        $('#kb_category_tree_container').on('click', 'input[type="checkbox"]', function (){
            var tree_id_category = $(this).val();
            if ($(this).is(':checked') && $('#pro_category_default option[value="'+tree_id_category+'"]').length == 0) {
                
                for (var i in product_categories_for_default) {
                    if (product_categories_for_default[i].id_category == tree_id_category) {
                        if ($('#pro_category_default option[value=""]').length == 1) {
                            $('#pro_category_default').html('');
                        }
                        $('#pro_category_default').append('<option value="'+product_categories_for_default[i].id_category+'">'+product_categories_for_default[i].name+'</option>');
                        break;
                    }
                }
            } else {
                $('#pro_category_default option[value="'+tree_id_category+'"]').remove();
                if ($('#pro_category_default option').length == 0) {
                    var no_option_title = '{l s='Select' mod='kbmarketplace'}';
                    $('#pro_category_default').append('<option value="">'+no_option_title+'</option>');
                }
            }
        });
    });
                
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