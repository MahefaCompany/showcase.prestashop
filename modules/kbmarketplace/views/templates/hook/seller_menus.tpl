{if isset($link_to_register)}
    <li class="lnk_wishlist">
        {if $kb_seller_agreement != ''}
            <a href="#kb_seller_agreement_modal" id="open_kb_seller_agreement_modal" data-href="{$link_to_register|escape:'htmlall':'UTF-8'}"
               title="{l s='Click to register as seller' mod='kbmarketplace'}" >
                    <i class="icon-star"></i>
                    <span>{l s='Register as seller' mod='kbmarketplace'}</span>
            </a>
        {else}
            <a href="javascript:void(0)" data-href="{$link_to_register|escape:'htmlall':'UTF-8'}"
               title="{l s='Click to register as seller' mod='kbmarketplace'}" 
               onclick="takeconfirmationforregister()" id="linkToConfirmation">
                    <i class="icon-star"></i>
                    <span>{l s='Register as seller' mod='kbmarketplace'}</span>
            </a>
        {/if}
    </li>
    <li class="lnk_wishlist">
    {if isset($is_favourite_seller_page) && $is_favourite_seller_page == 1}
        <a title="{l s='Click to visit favourite seller page' mod='kbmarketplace'}" href="{$favourite_seller_page_link|escape:'htmlall':'UTF-8'}">
            <i class="icon-heart"></i> {* Variable contains HTML/CSS/JSON, escape not required *}
            <span>  {l s='My Favourite Seller' mod='kbmarketplace'}</span>
            
        </a>
    {/if}
    </li>
   
    
{if $kb_seller_agreement != ''}
    <div id="kb_seller_agreement_modal" style="display:none;">
        <div style="">
            <p><pre>{html_entity_decode($kb_seller_agreement)}{*Variable contains HTML content,escape not required*}</pre></p>
            <p>
                <div class="checkbox">
                    <input type="checkbox" name="kbmp_registered_as_seller" id="kbmp_registered_as_seller" value="1" />
                    <label for="kbmp_registered_as_seller">{l s='I have read the agreement and register me as seller.' mod='kbmarketplace'}</label>
                </div>
            </p>
            <p>
                <button disabled="true" id="kbmp_registered_as_seller_btn" type="button" class="btn btn-success" onclick="location.href= '{$link_to_register|escape:'htmlall':'UTF-8'}'; ">{l s='Register' mod='kbmarketplace'}</button>
            </p>
        </div>
    </div>
 
    
{/if}    
    
{elseif isset($menus) && count($menus) > 0}
    <li class="lnk_wishlist">
    {if isset($is_favourite_seller_page) && $is_favourite_seller_page == 1}
        <a title="{l s='Click to visit favourite seller page' mod='kbmarketplace'}" href="{$favourite_seller_page_link|escape:'htmlall':'UTF-8'}">
            <i class="icon-heart"></i> {* Variable contains HTML/CSS/JSON, escape not required *}
            <span>  {l s='My Favourite Seller' mod='kbmarketplace'}</span>
            
        </a>
    {/if}
    </li>
    <div class="row_info" id="seller_menu">
        ﻿<style type="text/css">
            .col-lg-4{
                clear:both !important;
            }
        </style>	
        <h1 class="page-heading">{l s='Seller Account' mod='kbmarketplace'}</h1>
        {foreach $menus as $menu}
            <li>
                <a title="{$menu['title']|escape:'htmlall':'UTF-8'}" href="{$menu['href']|escape:'htmlall':'UTF-8'}">
                    <i class="icon-{$menu['icon_class']|escape:'htmlall':'UTF-8'}"></i>
                    <span>{$menu['label']|escape:'htmlall':'UTF-8'}</span>
                </a>
            </li>    
        {/foreach}
    </div>
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