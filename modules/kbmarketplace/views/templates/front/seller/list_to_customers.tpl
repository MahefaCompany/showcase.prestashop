<script>
        var ajaxurl = "{$ajaxurl}";{* Variable contains URL, escape not required *}
        var sfl_shortlist_text= "{l s='Mark Seller as Favourite' mod='kbmarketplace'}";
        var sfl_already_added_text= "{l s='Favourite Seller' mod='kbmarketplace'}";
    </script>
    <script>
    {if isset($is_favourite_seller_page) && $is_favourite_seller_page == 1}
        var is_favourite_seller_page = "1";
        {else}
            var is_favourite_seller_page = "0";
    {/if}
</script>
{if isset($sellers) && count($sellers) > 0}
    <h1 class="page-heading">
        <span clas="cat-name">{if isset($is_favourite_seller_page) && $is_favourite_seller_page == 1}{l s='My Favourite Sellers' mod='kbmarketplace'} {else}{l s='Sellers' mod='kbmarketplace'}{/if}</span>
        <div class="clearfix"></div>
    </h1>

    <div class="content_sortPagiBar clearfix">
        <div class="sortPagiBar clearfix">
            <ul class="display hidden-xs">
                <li class="display-title">{$pagination_string|escape:'htmlall':'UTF-8'}</li>
            </ul>

            <form id="sellerSortForm" action="#" class="productsSortForm">
                <div class="select selector1">
                    <label for="selectProductSort">{l s='Sort by' mod='kbmarketplace'}</label>
                    <select id="selectProductSort" class="selectSellerSort form-control">
                        <option value="" selected="selected">--</option>
                        {foreach $sorting_types as $sort}
                            <option value="{$sort['value']|escape:'htmlall':'UTF-8'}" {if $sort['value'] == $selected_sort} selected="selected"{/if} >{$sort['label']|escape:'htmlall':'UTF-8'}</option>
                        {/foreach}
                    </select>
                </div>
            </form>
        </div>
        {if isset($kb_pagination.pagination) && $kb_pagination.pagination neq ''}
            <div id="front-end-customer-pagination" class="top-pagination-content clearfix">
                <div class="sv-p-paging">
                    {$kb_pagination.pagination}{*Variable contains css and html content, escape not required*}
                    <div class='clearfix'></div>
                </div>
            </div>
        {/if}        
    </div>
    <div class="clearfix"></div>
        <img id="kb-list-loader" src="{$kb_image_path|escape:'htmlall':'UTF-8'}loader128.gif" />

    <div class='kbmp-_block'>

    </div>
    <div id="seller_list_to_customers">
        {include file="./seller_list.tpl"}
    </div>
    {addJsDef kb_page_start=$kb_pagination.page_position|intval}
    <div id="kb-seller-new-review-popup" style="display:none; width:400px">
        <div id='slr-new-review-blk' class='s-review-n'>
            <h2>{l s='Write a review' mod='kbmarketplace'}</h2>
            <form id="slr-review-form" action="{$link->getModuleLink($kb_module_name, 'sellerfront', [], (bool)Configuration::get('PS_SSL_ENABLED'))|escape:'htmlall':'UTF-8'}" method="post">
                <input id="kb-seller-new-review-seller-id" type="hidden" name="id_seller" value="0" />
                <ul>
                    <li>
                        <label>{l s='Rate this Seller' mod='kbmarketplace'}:</label>
                        <div id="seller_new_review_rating_block"></div>
                        <script type="text/javascript">
                            {literal}
                                $(document).ready(function(){
                                    setTimeout(function(){displayRatingStartInput('seller_new_review_rating_block', 'review_rating')}, 2000);
                                });
                            {/literal}
                        </script>
                        <div class="clearfix"></div>
                    </li>
                </ul>
                <br>
                <label for="review_title">{l s='Title' mod='kbmarketplace'}: <sup class="required">*</sup></label>
                <div class="kb-form-label-block">
                    <input id="review_title" name="review_title" type="text" value="" class="required">
                </div>
                <label for="review_content">{l s='Comment' mod='kbmarketplace'}: <sup class="required">*</sup></label>
                <div class="kb-form-label-block">
                    <textarea id="review_content" name="review_content" class="required"></textarea>
                </div>
                <div class='rvi_footer'>
                    <p class="fl required"><sup>*</sup> {l s='Required fields' mod='kbmarketplace'}</p>
                    <p class="fr">
                        <input type="hidden" name="new_review_submit" value="1" />
                        <button id="submitSellerReview" type="button" class="btn button button-small" {if $logged}onclick="submitSellerNewReview(this)"{else}onclick="location.href='{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}'"{/if}>
                            <span>{l s='Submit' mod='kbmarketplace'}</span>
                        </button>
                    </p>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
{else}
    <h1 class="page-heading" style='border:0;'>
        <span clas="cat-name">{$empty_list|escape:'htmlall':'UTF-8'}</span>
        <div class="clearfix"></div>
    </h1>
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