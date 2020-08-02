<div class="checkbox">
    <input type="checkbox" name="kbmp_registered_as_seller" id="kbmp_registered_as_seller" value="1" />
    <label for="kbmp_registered_as_seller">{if $kb_seller_agreement != ''}{l s='I have read the agreement and want to register as seller.' mod='kbmarketplace'} (<a id="open_kb_seller_agreement_modal" href="#kb_seller_agreement_modal" style="color: #dd0000;">{l s='Read Seller Agreement' mod='kbmarketplace'}</a>){else}{l s='Also register me as seller' mod='kbmarketplace'}{/if}</label>
</div>
{if $kb_seller_agreement != ''}
<div id="kb_seller_agreement_modal" style="display:none;">
    <div style="">
        <p>
           {$kb_seller_agreement}{*Variable contains HTML content,escape not required*} 
        </p>
    </div>
</div>
    
<script type="text/javascript">
    $(document).ready(function(){
        $('#open_kb_seller_agreement_modal').fancybox({
            'hideOnContentClick': false
        });
    });
</script>    
    
{/if}
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