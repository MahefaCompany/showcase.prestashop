{*define numbers of product per line in other page for desktop*}
{assign var='nbItemsPerLine' value=3}
{assign var='nbItemsPerLineTablet' value=2}
{assign var='nbItemsPerLineMobile' value=3}
{assign var='nbLi' value=$sellers|@count}
{math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
{math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
<ul class="product_list grid row">
    {foreach from=$sellers item=seller name=sellers}
        {math equation="(total%perLine)" total=$smarty.foreach.sellers.total perLine=$nbItemsPerLine assign=totModulo}
        {math equation="(total%perLineT)" total=$smarty.foreach.sellers.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
        {math equation="(total%perLineT)" total=$smarty.foreach.sellers.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
        {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
        {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
        {if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}
        <li class="ajax_block_product {if $page_name == 'index'} col-xs-12 col-sm-4 col-md-3{else} col-xs-12 col-sm-6 col-md-4{/if}{if $smarty.foreach.sellers.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.sellers.iteration%$nbItemsPerLine == 1} first-in-line{/if}{if $smarty.foreach.sellers.iteration > ($smarty.foreach.sellers.total - $totModulo)} last-line{/if}{if $smarty.foreach.sellers.iteration%$nbItemsPerLineTablet == 0} last-item-of-tablet-line{elseif $smarty.foreach.sellers.iteration%$nbItemsPerLineTablet == 1} first-item-of-tablet-line{/if}{if $smarty.foreach.sellers.iteration%$nbItemsPerLineMobile == 0} last-item-of-mobile-line{elseif $smarty.foreach.sellers.iteration%$nbItemsPerLineMobile == 1} first-item-of-mobile-line{/if}{if $smarty.foreach.sellers.iteration > ($smarty.foreach.sellers.total - $totModuloMobile)} last-mobile-line{/if}">
            <div class="product-container" itemscope="" itemtype="http://schema.org/Product">
                <div class="left-block">
                    <div class="product-image-container">
                        <a class="product_img_link" href="{$seller.href|escape:'htmlall':'UTF-8'}" title="{$seller.title|escape:'htmlall':'UTF-8'}" itemprop="url" target='_blank'>
                            <img class="replace-2x img-responsive" src="{$seller.logo|escape:'htmlall':'UTF-8'}" alt="" title="" width="250" height="250" itemprop="image">
                        </a>
                    </div>
                </div>
                <div class="right-block">
                    <h5 itemprop="name">
                        <a class="product-name" href="{$seller.href|escape:'htmlall':'UTF-8'}" target='_blank' title="{$seller.title|escape:'htmlall':'UTF-8'}" itemprop="url">
                            {$seller.title|escape:'htmlall':'UTF-8'}
                        </a>
                    </h5>
                    <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" class="content_price">
                        <div class="vss_seller_ratings">
                            <div class="vss_rating_unfilled">★★★★★</div>
                            <div class="vss_rating_filled" style="width:{$seller.rating_percent|escape:'htmlall':'UTF-8'}%">★★★★★</div>
                        </div>
                    </div>
                    {if isset($is_favourite_seller_page) && $is_favourite_seller_page == 1}
                                <div class="product-price-and-shipping">
                                <div class="kbmp-_row kb-tcenter">
                                <div class="kbmp-_inner_block">
                                    <i class="icon-heart shortlist_link" style="color: #ef4545;"></i><a href="javascript:addShortListSeller(this, {$seller.id_seller|escape:'htmlall':'UTF-8'});" class="sfl_product_link_{$seller.id_seller|escape:'htmlall':'UTF-8'}" style="padding-left:7px;font-size:13px;color: #2fb5d2;">{l s='Favourite Seller' mod='kbmarketplace'}</a>
                                </div>
                                </div>
                            {else}
                    <span itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" class="availability">
                        <div class="kbmp-_row kb-tcenter">
                            <div class="kbmp-_inner_block"><a href="{$seller.view_review_href|escape:'htmlall':'UTF-8'}" class="vss_active_link vss_read_review_bck" title='{l s='%s Review(s)'|sprintf:$seller.total_review mod='kbmarketplace'}'><span class="">{l s='View Reviews' mod='kbmarketplace'}</span></a></div>
                            {if $seller.display_write_review}
                                <div class="kbmp-_inner_block">
                                    {if !$kb_is_customer_logged}
                                        <a href="{$link->getPageLink('my-account', (bool)Configuration::get('PS_SSL_ENABLED'))|escape:'htmlall':'UTF-8'}"  class="vss_active_link "><span class="">{l s='Write Review' mod='kbmarketplace'}</span></a>
                                    {else}
                                        <a href="#kb-seller-new-review-popup"  class="vss_active_link vss_write_review_bck open-slr-review-form" onclick="$('#kb-seller-new-review-seller-id').val({$seller.id_seller|intval})"><span class="">{l s='Write Review' mod='kbmarketplace'}</span></a>
                                    {/if}
                                </div>
                            {/if}
                        </div>
                    </span>
                        {/if}
                </div>
            </div>
        </li>
    {/foreach}
</ul>
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