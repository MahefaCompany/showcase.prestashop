<div class="kb-content">
    <div class="kb-content-header">
        <h1>{l s='Product Zone Mapping' mod='kbmarketplace'}</h1>
        <div class="kb-content-header-btn">
            <a href="{$map_products_link}" class="btn-sm btn-success" title="{l s='click to map new Products' mod='kbmarketplace'}"><i class="icon-plus"></i>{l s='Map More Products' mod='kbmarketplace'}</a>{* Variable contains HTML/CSS/JSON, escape not required *}
        </div> 
        <div class="clearfix"></div>
    </div>
    
    {if isset($kbfilter)}
        {$kbfilter} {* Variable contains HTML/CSS/JSON, escape not required *}

    {/if}
    
    {if isset($kbmutiaction)}
        {$kbmutiaction} {* Variable contains HTML/CSS/JSON, escape not required *}

    {/if}
    
    {if isset($kblist)}
        <div class="kb-vspacer5"></div>
        {$kblist} {* Variable contains HTML/CSS/JSON, escape not required *}

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
