{if true}
{*    <li class="lnk_wishlist">*}
        {if $kb_seller_agreement != ''}
            <a href="#kb_seller_agreement_modal_footer" id="open_kb_seller_agreement_modal_footer" data-href="{$link_to_register|escape:'htmlall':'UTF-8'}"
               title="{l s='Click to register as seller' mod='kbmarketplace'}" >
                    <span>{l s='Become a seller' mod='kbmarketplace'}</span>
            </a>
        {else}
            <a href="javascript:void(0)" data-href="{$link_to_register|escape:'htmlall':'UTF-8'}"
               title="{l s='Click to register as seller' mod='kbmarketplace'}" 
               onclick="takeconfirmationforregister(this)" >
                    {*<i class="icon-star"></i>*}
                    <span>{l s='Become a seller' mod='kbmarketplace'}</span>
            </a>
        {/if}
{*    </li>*}
    <script type="text/javascript">
        var kb_confirm_msg = "{l s='Are you sure?' mod='kbmarketplace'}";
        function takeconfirmationforregister(e){
            if(confirm(kb_confirm_msg)){
                location.href='https://lecannet.cliccommerce.fr/mon-compte?register_as_seller=1';
            }
        }
    </script>
    
{if $kb_seller_agreement != ''}
    <div id="kb_seller_agreement_modal_footer" style="display:none;">
        <div style="">
            <p>{html_entity_decode($kb_seller_agreement)}</p>{*Variable contains HTML content,escape not required*}
            <p>
                <div class="checkbox">
                    <input type="checkbox" name="kbmp_registered_as_seller" id="kbmp_registered_as_seller_footer" value="1" />
                    <label for="kbmp_registered_as_seller">{l s='I have read the agreement and register me as seller.' mod='kbmarketplace'}</label>
                </div>
            </p>
            <p>
                <button disabled="true" id="kbmp_registered_as_seller_btn_footer" type="button" class="btn btn-success" onclick="location.href= '{$link_to_register|escape:'htmlall':'UTF-8'}'; ">{l s='Register' mod='kbmarketplace'}</button>
            </p>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#open_kb_seller_agreement_modal_footer').fancybox({
                'hideOnContentClick': false
            });
            
            $('#kbmp_registered_as_seller_footer').on('change', function(){
                if ($(this).is(':checked')) {
                    $('#kbmp_registered_as_seller_btn_footer').attr('disabled', false);
                } else {
                    $('#kbmp_registered_as_seller_btn_footer').attr('disabled', true);
                }
            });
        });
    </script>    
    
{/if}    
    
{elseif isset($menus) && count($menus) > 0}
    <div class="row_info">
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