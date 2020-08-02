<script>
    var PS_ALLOW_ACCENTED_CHARS_URL = {$PS_ALLOW_ACCENTED_CHARS_URL|escape:'htmlall':'UTF-8'};
</script>
{if isset($seller_account_menus) && count($seller_account_menus) > 0}
<div id="seller-account-menus">
	<div class="current">
            <span>{l s='Seller Account' mod='kbmarketplace'}</span>
        </div>
        <ul class="toogle_content">
            {foreach $seller_account_menus as $menu}
                <li>
                <a title="{$menu['title']|escape:'htmlall':'UTF-8'}" href="{$menu['href']|escape:'htmlall':'UTF-8'}">
                    <span>{$menu['label']|escape:'htmlall':'UTF-8'}</span>
                </a>
                </li>
            {/foreach}
        </ul>
</div>
{elseif isset($seller_account_link)}
    <div id="sellers-account-link" class="kb-top-menu-link">
            <a href="{$seller_account_link|escape:'htmlall':'UTF-8'}" >{l s='Seller Account' mod='kbmarketplace'}</a>
    </div>
{/if}
{if isset($seller_list_link)}
<div id="sellers-list-link" class="kb-top-menu-link">
	<a href="{$seller_list_link|escape:'htmlall':'UTF-8'}" title="{l s='Click to view all sellers' mod='kbmarketplace'}">{l s='Sellers' mod='kbmarketplace'}</a>
</div>
{/if}
{if isset($kb_mp_custom_js) && $kb_mp_custom_js != ''}
        <script type='text/javascript'>{$kb_mp_custom_js}</script>{*Variable contains js code, escape not required*}
{/if}
{if isset($kb_mp_custom_css) && $kb_mp_custom_css != ''}
    <style>{$kb_mp_custom_css}</style>{*Variable contains css code, escape not required*}
{/if}
{if isset($cart_url)}
    {if $cart_url !=''}
        <input type="hidden" id="allow_free_shipping" value="{$allow_free_shipping|escape:'htmlall':'UTF-8'}"/>
        <input type="hidden" id="cart_rule_url" value="{$cart_url}{*Variable contains html, escape not required*}"/>
    {/if}
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