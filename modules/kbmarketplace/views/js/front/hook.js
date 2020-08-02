/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 * We offer the best and most useful modules PrestaShop and modifications for your online store.
 *
 * @author    knowband.com <support@knowband.com>
 * @copyright 2017 Knowband
 * @license   see file: LICENSE.txt
 * @category  PrestaShop Module
 *
 */
$(document).ready(function(){
    if ($('#open_kb_seller_agreement_modal').length) {
        $('#open_kb_seller_agreement_modal').on('click', function(){
            $('#'+$(this).attr('data-modal')).modal('show');
        });
    }

    if ($('#seller_new_review_rating_block').length) {
        setTimeout(function(){displayRatingStartInput('seller_new_review_rating_block', 'review_rating')}, 2000);
    }

    $('#kbmp_registered_as_seller').on('change', function(){
        if ($(this).is(':checked')) {
            $('#kbmp_registered_as_seller_btn').attr('disabled', false);
        } else {
            $('#kbmp_registered_as_seller_btn').attr('disabled', true);
        }
    });

//    $('#cart_voucher button').on('click', function (e) {
//
//        var coupon = $('#discount_name').val();
//        var cart_url = $('#cart_rule_url').val();
//        var allow_free_shipping = $('#allow_free_shipping').val();
//        var form_surl = $('#cart_voucher form#voucher').attr('action');
//        if (allow_free_shipping != '1') {
//            if ((coupon != '') && (allow_free_shipping != '1')) {
//                $.ajax({
//                    data: {searchcoupon: true, coupon: coupon},
//                    url: cart_url,
//                    type: 'post',
//                    success: function (res) {
//                        if (res == 'free') {
//                            $('#cart_voucher #voucher').attr('onsubmit','event.preventDefault();');
//                            $('.alert').remove();
//                            $('#cart_title').after('<div class="alert alert-danger"><p>There is 1 error</p><ol><li>This voucher can not applied as allow Free Shipping voucher is disabled.</li></ol></div>');
//                            return false;
//                        } else {
//                            $('#cart_voucher #voucher').attr('onsubmit','');
//                            $('#cart_voucher form#voucher').append('<input type="text" name="submitAddDiscount"/>');
//                            $('#cart_voucher form#voucher').submit();
//                            return;
//                        }
//                    },
//                });
////                $.each(xhr, function(index, val) {
////                    console.log(val.responseText);
////                });
////                console.log(xhr.);
//                return false;
//            } else {
//                $('#cart_voucher #voucher').removeAttr('onsubmit');
//                return true;
//            }
////            return false;
//        } else {
//            $('#cart_voucher #voucher').removeAttr('onsubmit');
//            return true;
//        }
//    });

});

function openSellerReviewPopup(pop_id, id_seller)
{
    if ($('#'+pop_id).length) {
        $('#'+pop_id).find('input[type="text"]').val('');
        $('#'+pop_id).find('textarea').val('');
        if (id_seller != false) {
            $('#'+pop_id).find('input[name=id_seller]').val(parseInt(id_seller));
        }
        $('#'+pop_id).modal('show');
    }
}


