/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function allowRequest(anchor)
{
    var ret_lang = $(anchor).attr("type");
    /*Start Added by Anshul Mittal on "26-08-2017" to fix the issue of sent email language according to customer*/
    var res = ret_lang.split('_');
    var ret_id = res[0];
    var lang_id = res[1];
    $('#new-return_approve-form').find('.kb-validation-error').remove();
    $('#kb-return_approve-modal-form').show();
    $('#return_approve-form-content').show();
    $("html, body").animate({scrollTop: 0}, '500');
    $('#return_approve-updating-progress').css('display', 'none');
    $('#rm_yes_approve').on('click', function () {
        /*Start Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&method=approveReturn&ret=' + ret_id ,
            dataType: 'json',
                beforeSend: function () {
                    $('#new-return_approve-form').attr('disable', true);
                    $('#return_approve-updating-progress').css('display', 'inline-block');
                },
            success: function (json)
            {
                KbFilterList('seller_returnrequest_filter');
                if (json['status'] == true) {
                    $('#kb-return_approve-modal-form').hide();
                    $('#kb-return_approve-modal-form #return_approve-loader').show();
                    $('#kb-return_approve-modal-form #return_approve-form-content').hide();
                    $.gritter.add({
                        title: notification_title,
                        text: return_approve_success,
                        class_name: 'gritter-success',
                        sticky: false,
                        time: '3000'
                    });
                } else {
                    var error_html = '';
                    for (var i = 0; i < json['errors'].length; i++)
                        error_html += json['errors'][i] + '<br>';
                    jAlert(error_html);
                }
                $('#return_approve-updating-progress').css('display', 'none');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jAlert(kb_ajax_request_fail_err);
                $('#return_approve-updating-progress').css('display', 'none');
            }
        });
        $('#rm_yes_approve').unbind();
    });
}
function denyRequest(anchor)
{
    var ret_lang = $(anchor).attr("type");
    /*Start Added by Anshul Mittal on "26-08-2017" to fix the issue of sent email language according to customer*/
    var res = ret_lang.split('_');
    var ret_id = res[0];
    var lang_id = res[1];
    $('#new-return_deny-form').find('.kb-validation-error').remove();
    $('#kb-return_deny-modal-form').show();
    $('#return_deny-form-content').show();
    $("html, body").animate({scrollTop: 0}, '500');
    $('#return_deny-updating-progress').css('display', 'none');
    $('#rm_yes_deny').on('click', function () {
        /*Start Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&method=denyReturn&ret=' + ret_id,
            dataType: 'json',
                beforeSend: function () {
                    $('#new-return_deny-form').attr('disable', true);
                    $('#return_deny-updating-progress').css('display', 'inline-block');
                },
            success: function (json)
            {
                KbFilterList('seller_returnrequest_filter');
                if (json['status'] == true) {
                    $('#kb-return_deny-modal-form').hide();
                    $('#kb-return_deny-modal-form #return_deny-loader').show();
                    $('#kb-return_deny-modal-form #return_deny-form-content').hide();
                    $.gritter.add({
                        title: notification_title,
                        text: return_disapprove_success,
                        class_name: 'gritter-success',
                        sticky: false,
                        time: '3000'
                    });
                } else {
                    var error_html = '';
                    for (var i = 0; i < json['errors'].length; i++)
                        error_html += json['errors'][i] + '<br>';
                    jAlert(error_html);
                }
                $('#return_deny-updating-progress').css('display', 'none');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jAlert(kb_ajax_request_fail_err);
                $('#return_deny-updating-progress').css('display', 'none');
            }
        });
        $('#rm_yes_deny').unbind();
    });
}
function completeReturn(anchor)
{
    var ret_lang = $(anchor).attr("type");
    /*Start Added by Anshul Mittal on "26-08-2017" to fix the issue of sent email language according to customer*/
    var res = ret_lang.split('_');
    var ret_id = res[0];
    var lang_id = res[1];
    // changes to be done
    $('#new-return_complete-form').find('.kb-validation-error').remove();
    var is_refund_type = parseInt($(anchor).attr("refund"));
    if (is_refund_type != 1) {
        $("#generate_coupon").parent().parent().hide();
    } else {
        $("#generate_coupon").parent().parent().show();
    }
    // changes over
    $('#kb-return_complete-modal-form').show();
    $('#return_complete-form-content').show();
    $("html, body").animate({scrollTop: 0}, '500');
    $('#return_complete-updating-progress').css('display', 'none');
    var is_generate_coupon = 0;
    var is_update_inventory = 0;
    $('#rm_yes_complete').on('click', function () {
        if ($("#generate_coupon").length > 0 && $("#generate_coupon").val() == 1 && is_refund_type == 1) {
            is_generate_coupon = 1;
        } else {
            is_generate_coupon = 0;
        }
        if ($("#update_inventory").val() == 1) {
            is_update_inventory = 1;
        } else {
            is_update_inventory = 0;
        }
        /*Start Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&method=completeReturn&ret=' + ret_id + '&is_generate_coupon=' + is_generate_coupon + '&is_update_inventory=' + is_update_inventory,
            dataType: 'json',
                beforeSend: function () {
                    $('#new-return_complete-form').attr('disable', true);
                    $('#return_complete-updating-progress').css('display', 'inline-block');
                },
            success: function (json)
            {
                KbFilterList('seller_returnrequest_filter');
                if (json['status'] == true) {
                    $('#kb-return_complete-modal-form').hide();
                    $('#kb-return_complete-modal-form #return_complete-loader').show();
                    $('#kb-return_complete-modal-form #return_complete-form-content').hide();
                    $.gritter.add({
                        title: notification_title,
                        text: return_complete_success,
                        class_name: 'gritter-success',
                        sticky: false,
                        time: '3000'
                    });
                } else {
                    var error_html = '';
                    for (var i = 0; i < json['errors'].length; i++)
                        error_html += json['errors'][i] + '<br>';
                    jAlert(error_html);
                }
                $('#return_complete-updating-progress').css('display', 'none');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jAlert(kb_ajax_request_fail_err);
                $('#return_complete-updating-progress').css('display', 'none');
            }
        });
        $('#rm_yes_complete').unbind();
    });
}
function changeReturnStatus(anchor)
{
    var ret_lang = $(anchor).attr("type");
    /*Start Added by Anshul Mittal on "26-08-2017" to fix the issue of sent email language according to customer*/
    var res = ret_lang.split('_');
    var ret_id = res[0];
    var lang_id = res[1];
    $('#new-return_change_status-form').find('.kb-validation-error').remove();
    $('#kb-return_change_status-modal-form').show();
    $('#return_change_status-form-content').show();
    $("html, body").animate({scrollTop: 0}, '500');
    $('#return_change_status-updating-progress').css('display', 'none');
    $('#rm_yes_change_status').on('click', function () {
        var rm_status_id = $('#rm_change_return_status').val();
        /*Start Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'ajax=true&method=changeReturnStatus&ret=' + ret_id + '&stat=' + rm_status_id,
            dataType: 'json',
            beforeSend: function () {
                $('#new-return_change_status-form').attr('disable', true);
                $('#return_change_status-updating-progress').css('display', 'inline-block');
            },
            success: function (json)
            {
                KbFilterList('seller_returnrequest_filter');
                if (json['status'] == true) {
                    $('#kb-return_change_status-modal-form').hide();
                    $('#kb-return_change_status-modal-form #return_change_status-loader').show();
                    $('#kb-return_change_status-modal-form #return_change_status-form-content').hide();
                    $.gritter.add({
                        title: notification_title,
                        text: return_status_update_success,
                        class_name: 'gritter-success',
                        sticky: false,
                        time: '3000'
                    });
                } else {
                    var error_html = '';
                    for (var i = 0; i < json['errors'].length; i++)
                        error_html += json['errors'][i] + '<br>';
                    jAlert(error_html);
                }
                $('#return_change_status-updating-progress').css('display', 'none');
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                jAlert(kb_ajax_request_fail_err);
                $('#return_change_status-updating-progress').css('display', 'none');
            }
        });
        $('#rm_yes_change_status').unbind();
    });
}
function rmCloseModal(modal) {
    $('#' + modal).modal('hide');
}
function viewReturnDetail(anchor)
{
    var ret_id = $(anchor).attr('type');
    $('#rm_return_history_modal').modal({'show': true, 'backdrop': 'static'});
    $('#rm_return_history').html('');
    $.ajax({
        type: 'POST',
        url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
        data: 'ajax=true&method=getReturnData&ret=' + ret_id,
        data: 'ajax=true&method=getReturnData&ret=' + ret_id,
        success: function (res) {
                $('#rm_return_history').html(res['html']);
        }
    });
            }
function showreason(anchor) {
    $('#kb-return_comment-modal-form').find('.kb-modal').css('width', '50%');
    $('#kb-return_comment-modal-form').find('.kb-modal').css('left', '10%');
    if ($(anchor).attr('data-content') != '') {
        $('#kb-return_comment-modal-form').find('.kb-modal-footer').html($(anchor).attr('data-content'));
    } else {
        $('#kb-return_comment-modal-form').find('.kb-modal-footer').html(empty_comment);
    }
//    $('#kb-return_comment-modal-form').find('.kb-modal-footer').html($(anchor).attr('data-content'));
        $('#kb-return_comment-modal-form').show();
        $('#return_comment-form-content').show();
        $("html, body").animate({scrollTop: 0}, '500');
        }

function showcomment(anchor) {
    $('#kb-return_note-modal-form').find('.kb-modal').css('width', '50%');
        $('#kb-return_note-modal-form').find('.kb-modal').css('left', '10%');
    if ($(anchor).attr('data-content') != '') {
        $('#kb-return_note-modal-form').find('.kb-modal-footer').html($(anchor).attr('data-content'));
    } else {
    $('#kb-return_note-modal-form').find('.kb-modal-footer').html(empty_comment);
    }
    $('#kb-return_note-modal-form').show();
        $('#return_note-form-content').show();
        $("html, body").animate({scrollTop: 0}, '500');
        }

//function allowRequest(anchor)
//{
//    var ret_lang = $(anchor).attr("type");
//    /*Start Added by Anshul Mittal on "26-08-2017" to fix the issue of sent email language according to customer*/
//    var res = ret_lang.split('_');
//    var ret_id = res[0];
//    var lang_id = res[1];
//    /*End Added by Anshul Mittal on "26-08-2017"  to fix the issue of sent email language according to customer*/
//
//    /*Start Added by Anshul Mittal on "25-08-2017" to add a functionality of email editing before sending it to customer*/
//    $.ajax({
//        type: 'POST',
//        headers: {"cache-control": "no-cache"},
//        url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
//        async: true,
//        cache: false,
//        dataType: "json",
//        data: 'ajax=true'
//            + '&method=loadEmailTemplate&token=' + prestashop.static_token
//            + '&selected_temp=ret_app&selected_lang=' + lang_id,
//        beforeSend: function () {
//            $('#new-return_approve-form').attr('disable', true);
//            $('#return_approve-updating-progress').css('display', 'inline-block');
//        },
//        success: function (json)
//        {
//            $('#subject_email_allow').val(json['subject']);
//            //$('#body_email_comp').val(json['body']);
////            tinyMCE.get('body_email_allow').setContent(json['body']);
//            $('#body_email_allow').val(json['body']);
//            tinymce.init({
//                mode: "specific_textareas",
//                editor_selector: "autoload_rte",
//                menubar: false,
//                language: kb_editor_lang,
//                setup: function (ed) {
//                    ed.on('keydown', function (ed, e) {
//                        tinyMCE.triggerSave();
//                        textarea = $('#' + tinymce.activeEditor.id);
//                        if (textarea.parent('div').find('span.counter').length)
//                        {
//                            var max = textarea.parent('div').find('span.counter').data('max');
//                            if (max != 'none')
//                            {
//                                count = tinyMCE.activeEditor.getBody().textContent.length;
//                                rest = max - count;
//                                if (rest < 0)
//                                    textarea.parent('div').find('span.counter').html('<span style="color:red;">' + maximum + ' ' + max + characters + ': ' + rest + '</span>');
//                                else
//                                    textarea.parent('div').find('span.counter').html(' ');
//                            }
//                        }
//                    });
//                },
//                plugins: [
//                    "advlist autolink lists link charmap print preview anchor",
//                    "searchreplace visualblocks code fullscreen",
//                    "insertdatetime media table contextmenu paste code"
//                ],
//                toolbar: "code insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
//
//            });
//            $('#rm_yes_approve').show();
//            $('#new-return_approve-form').find('.kb-validation-error').remove();
//            $('#kb-return_approve-modal-form').show();
//            $('#return_approve-form-content').show();
//            $("html, body").animate({scrollTop: 0}, '500');
////            $('#return_approve-updating-progress').css('display', 'none');
//        },
//        error: function (XMLHttpRequest, textStatus, errorThrown) {
//            jAlert(kb_ajax_request_fail_err);
//            $('#return_approve-updating-progress').css('display', 'none');
//        }
//    });
//
//    /*End Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
//    $('#rm_yes_approve').on('click', function () {
//        /*Start Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
//        var subject_email_allow = $('#subject_email_allow').val();
////        var body_email_allow = tinyMCE.get('body_email_allow').getContent();
//        var body_email_allow = $('#body_email_allow').val();
//        /*End Added by Anshul Mittal on "25-08-2017"  to add a functionality of email editing before sending it to customer*/
////        $('#rm_approve_return_popup_loader').show();
//        var body_email = body_email_allow.replace(/&amp;/g, '#####@@@@@@');
//        body_email = body_email.replace(/&;/g, '#####@@@@@@');
//        body_email = body_email.replace(/&/g, '@@@@@@@@@@@@');
//        $.ajax({
//            type: 'POST',
//            headers: {"cache-control": "no-cache"},
//            url: kb_current_request + ((kb_current_request.indexOf('?') < 0) ? '?' : '&') + 'rand=' + new Date().getTime(),
//            async: true,
//            cache: false,
//            dataType: "json",
//            data: 'ajax=true&method=approveReturn&ret=' + ret_id + '&subject_email_allow=' + subject_email_allow + '&body_email_allow=' + body_email,
//            dataType: 'json',
//            success: function (response) {
////                $('#rm_approve_return_popup_loader').hide();
////                getNextReturnsListingPage($('#rm_pending_returns_current_page').val(), 1);
////                getNextReturnsListingPage($('#rm_active_returns_current_page').val(), 2);
////                if (response['mail_sent'])
////                    var html = '<div class="bootstrap returnmanager_success_msg"><div class="alert alert-success">';
////                else
////                    var html = '<div class="bootstrap returnmanager_success_msg"><div class="alert alert-warning">';
////                html += '<button type="button" class="close" data-dismiss="alert">×</button>';
////                html += success_return_approval;
////                if (!response['mail_sent'])
////                    html += '. ' + email_not_sent;
////                html += '</div></div>';
////                $('#velsof_rm_container').before(html);
////                $('#rm_approve_confirm').modal('hide');
////                $(".rm_customer_notes").popover();
////                $('[data-toggle="tooltip"]').tooltip();
////                $("html, body").animate({scrollTop: 0}, "slow");
//            }
//        });
//        $('#rm_yes_approve').unbind();
//    });
//}