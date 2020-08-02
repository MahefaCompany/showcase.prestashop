<div class="kb-content">
    <div class="kb-content-header">
        <h1>{l s='Shippings' mod='kbmarketplace'}</h1>
        <div class="kb-content-header-btn">
            <a href="{$new_shipping_link|escape:'htmlall':'UTF-8'}" class="kbbtn kbbtn-success" title="{l s='click to add new shipping' mod='kbmarketplace'}"><i class="icon-plus"><span>{l s='Add New' mod='kbmarketplace'}</span></i></a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class='kb-vspacer5'></div>
    {if isset($kbfilter)}
        {$kbfilter}{*Variable contains css and html content, escape not required*}
    {/if}
    
    {if isset($kblist)}
        <div class="kb-vspacer5"></div>
        {$kblist}{*Variable contains css and html content, escape not required*}
    {/if}
    
    <div id="kb-seller-shipping-view-popup" style="display:none;">
        <div class="kb-overlay"></div>
        <div class="kb-modal">
            <div class='kb-model-content-loader'><div class="kb-modal-loading-img"></div></div>
            <div class='kb-model-content'>
                <div class="kb-modal-header">
                    <h1>{l s='Shipping Detail' mod='kbmarketplace'}</h1>
                    <span class="kb-modal-close" data-modal="kb-seller-shipping-view-popup">X</span>
                </div>
                <div class="kb-modal-content">
                    <div id="shipping-content">
                            
                    </div>
                </div>    
            </div>
        </div>
    </div>
    
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
