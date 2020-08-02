<div class="kb-content">
    <div class="kb-content-header">
        <h1>{if isset($zone_name)}{$zone_name|escape:'htmlall':'UTF-8'}{/if}</h1>
        <div class="kbbtn-group kb-tright">
            <a href="{$cancel_button}" class="btn-sm btn-success" title="{l s='click to go back to zone list' mod='kbmarketplace'}"><i class="icon-cancel"></i>{l s='Back' mod='kbmarketplace'}</a> {* Variable contains HTML/CSS/JSON, escape not required *}
            <a href="{$add_zipcode_global_zone_link}" class="btn-sm btn-success" title="{l s='click to add new zone' mod='kbmarketplace'}"><i class="icon-plus"></i>{l s='Add New Zipcodes' mod='kbmarketplace'}</a>
        </div> {* Variable contains HTML/CSS/JSON, escape not required *}
        <div class="clearfix"></div>
    </div>
        <input type="hidden" id="id_zone" name="id_zone" value ="{if isset($id_zone)}{$id_zone|escape:'htmlall':'UTF-8'}{/if}"/>
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
