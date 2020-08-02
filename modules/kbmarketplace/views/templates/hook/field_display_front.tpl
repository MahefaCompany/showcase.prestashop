<div class="kb_custom_field_block">
    <div >
        <input type="hidden" name="seller_registration_form" id="seller_registration_form" value="1"/>
          {assign var='field_counter' value=0}
        {if isset($registration_form_extra_fields)}
              {if isset($registration_form_extra_fields['shop_title']) && $registration_form_extra_fields['shop_title'] == 1}
                  <div class="form-group" >
                        <label for="shop_title" class="required">{l s='Shop Title' mod='kbmarketplace'}</label>
                        <input type="text" placeholder="{l s='Enter Shop Title' mod='kbmarketplace'}"
                               name='shop_title' id="shop_title" class="kbfield is_required validate form-control"
                               data-validate="isGenericName" 
                               value=""
                               />
                        <span class="error_message" style="display:none;">{l s='Please enter valid Shop Title' mod='kbmarketplace'}</span>
                    </div>
                {/if}
              {if isset($registration_form_extra_fields['seller_contact_number']) && $registration_form_extra_fields['seller_contact_number'] == 1}
                  <div class="form-group">
                        <label class="required" for="seller_contact_number">{l s='Enter Contact No' mod='kbmarketplace'}</label>
                        <input type="text" placeholder="{l s='Enter contact no' mod='kbmarketplace'}"
                               name='seller_contact_number' id="shop_title" class="kbfield is_required validate form-control"
                               data-validate="isPhoneNumber"
                               value=""
                               />
                        <span class="error_message" style="display:none;">{l s='Please enter valid contact number' mod='kbmarketplace'}</span>
                        
                    </div>
            {/if}
            {if isset($registration_form_extra_fields['seller_city']) && $registration_form_extra_fields['seller_city'] == 1}
                <div class="form-group">
                      <label class="required" for="seller_city">{l s='City' mod='kbmarketplace'}</label>
                      <input type="text" placeholder="{l s='Enter city' mod='kbmarketplace'}"
                             name='seller_city' id="shop_title" class="kbfield is_required validate form-control"
                             data-validate="isGenericName" 
                             value=""
                             />
                      <span class="error_message" style="display:none;">{l s='Please enter valid city name' mod='kbmarketplace'}</span>
                  </div>
              {/if}
            {if isset($registration_form_extra_fields['seller_country']) && $registration_form_extra_fields['seller_country'] == 1}
                      <div class="form-group">
                         <label class="required" for="seller_country">{l s='Country' mod='kbmarketplace'}</label>
                         <select name='seller_country' id='seller_country' class="kbfield seller_country is_required form-control">
                            {if !empty($total_active_country)}
                                {foreach $total_active_country as $id_country => $country_details}
                                    <option value="{$id_country|escape:'htmlall':'UTF-8'}" {if $default_country_id == $id_country}selected {/if}>{$country_details['name']|escape:'htmlall':'UTF-8'}</option>
                                {/foreach}
                            {/if}                       
                        </select>
                        <span class="error_message" style="display:none;">{l s='Please choose a valid country.' mod='kbmarketplace'}</span>
                    </div>
              {/if}
        {/if}
        {foreach $kb_available_field as $kbfield}
            {if ($kbfield['type'] == 'text') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                <div class="form-group" >
                        <label for="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}" {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label>
                        <input type="{if $kbfield['validation'] == 'isEmail'}email{else}text{/if}" {if $kbfield['placeholder'] != ''}placeholder="{$kbfield['placeholder']|escape:'htmlall':'UTF-8'}"{/if} 
                               name='{$kbfield['field_name']|escape:'htmlall':'UTF-8'}' id="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} {if $kbfield['required']}is_required{/if} {if $kbfield['validation'] != ''}validate{/if}  form-control"
                               {if $kbfield['validation'] != ''} data-validate="{$kbfield['validation']|escape:'htmlall':'UTF-8'}"{/if} {if ($kbfield['max_length'] != '') && ($kbfield['max_length'] > 0)} maxlength="{$kbfield['max_length']|escape:'htmlall':'UTF-8'}"{/if} {if $kbfield['min_length'] != ''}minlength="{$kbfield['min_length']|escape:'htmlall':'UTF-8'}"{/if}
                               value="{if isset($kbfield['customer_value'])}{$kbfield['customer_value']|escape:'htmlall':'UTF-8'}{/if}"
                               />
                        {if $kbfield['description'] != ''}<span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                        {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                        <input type="hidden" name="kb_register_newsletter" value="{if $kbfield['register_for_newsletter']}1{else}0{/if}"/>
                    </div>
            {/if}
            {if ($kbfield['type'] == 'select') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                 <div class="form-group">
                        <label for="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label>
                        <select name='{$kbfield['field_name']|escape:'htmlall':'UTF-8'}{if $kbfield['multiselect']}[]{/if}' id='{$kbfield['html_id']|escape:'htmlall':'UTF-8'}' class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} {if $kbfield['required']}is_required{/if} form-control"
                                {if $kbfield['multiselect']} multiple{/if} >
                            {if $kbfield['value'] != ''}
                                {foreach $kbfield['value']|json_decode:1 as $field_value}
                                    <option value="{$field_value['option_value']|escape:'htmlall':'UTF-8'}"
                                        {if isset($kbfield['default_value'])}
                                            {if $kbfield['default_value'] != ""}
                                                {if isset($kbfield['default_value'][0]) && isset($kbfield['default_value'][0]['option_value'])}
                                                    {if $kbfield['default_value'][0]['option_value'] == $field_value['option_value']}
                                                        selected
                                                    {/if}
                                                {/if}
                                            {/if}
                                        {/if}
                                        >{$field_value['option_label']|escape:'htmlall':'UTF-8'}</option>
                                {/foreach}
                            {/if}                       
                        </select>
                         {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                        {if $kbfield['description'] != ''}<span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                    </div>
            {/if}
            {if ($kbfield['type'] == 'radio') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                <div class="clearfix">
                        <label {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label></br>
                        {if $kbfield['value'] != ''}
                            {foreach $kbfield['value']|json_decode:1 as $field_value}
                                <div class="radio-inline">
                                    <label for="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}" class="top">
                                        <input type="radio" name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}" id="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} {if $kbfield['required']}is_required{/if}" value="{$field_value['option_value']|escape:'htmlall':'UTF-8'}" 
                                             {if isset($kbfield['default_value'])}
                                                   {if $kbfield['default_value'] != ""}
                                                       {if isset($kbfield['default_value'][0]) && isset($kbfield['default_value'][0]['option_value'])}
                                                           {if $kbfield['default_value'][0]['option_value'] == $field_value['option_value']}
                                                               checked
                                                           {/if}
                                                       {/if}
                                                   {/if}
                                               {/if}  />
                                        {$field_value['option_label']|escape:'htmlall':'UTF-8'}
                                    </label>
                                </div>
                            {/foreach}
                        {/if}
                                     {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                        {if $kbfield['description'] != ''}</br><span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                    </div>
            {/if}
            {if ($kbfield['type'] == 'checkbox') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                 <div class="form-group">
                        <label {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label></br>
                        {if $kbfield['value'] != ''}
                            {foreach $kbfield['value']|json_decode:1 as $field_value}
                                <div class="checkbox">
                                    <label for="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}">
                                        <input type="checkbox" name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}[]"id="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} {if $kbfield['required']}is_required{/if}" value="{$field_value['option_value']|escape:'htmlall':'UTF-8'}"
                                            {if isset($kbfield['default_value'])}
                                                {if $kbfield['default_value'] != ""}
                                                    {if isset($kbfield['default_value'][0]) && isset($kbfield['default_value'][0]['option_value'])}
                                                        {if $kbfield['default_value'][0]['option_value'] == $field_value['option_value']}
                                                            checked
                                                        {/if}
                                                    {/if}
                                                {/if}
                                            {/if}  
                                               />
                                        {$field_value['option_label']|escape:'htmlall':'UTF-8'}</label>
                                </div>
                            {/foreach}
                        {/if}
                        {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                         {if $kbfield['description'] != ''}</br><span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                    </div>

            {/if}
            {if ($kbfield['type'] == 'textarea') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                <div class="form-group">
                    <label for="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label>
                    <textarea {if $kbfield['placeholder'] != ''}placeholder="{$kbfield['placeholder']|escape:'htmlall':'UTF-8'}"{/if} 
                                                                name='{$kbfield['field_name']|escape:'htmlall':'UTF-8'}' id='{$kbfield['html_id']|escape:'htmlall':'UTF-8'}' class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} 
                                                                {if $kbfield['required']}is_required{/if} {if $kbfield['validation'] != ''}validate{/if}  form-control"
                                                                {if $kbfield['validation'] != ''} data-validate="{$kbfield['validation']|escape:'htmlall':'UTF-8'}"{/if}
                                                                {if ($kbfield['max_length'] != '') && ($kbfield['max_length'] > 0)} maxlength="{$kbfield['max_length']|escape:'htmlall':'UTF-8'}"{/if} {if $kbfield['min_length'] != ''}minlength="{$kbfield['min_length']|escape:'htmlall':'UTF-8'}"{/if}
                                                                >{if isset($kbfield['customer_value'])}{$kbfield['customer_value']|escape:'htmlall':'UTF-8'}{/if}</textarea>
                    {if $kbfield['description'] != ''}<span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                   {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}

                </div>
            {/if}
            {if ($kbfield['type'] == 'date') && ($kbfield['show_registration_form'] == 1)}
                 {$field_counter = $field_counter+1}
                <div class="form-group">
                    <label for="{$kbfield['html_id']|escape:'htmlall':'UTF-8'}" {if $kbfield['required']}class="required"{/if}>{$kbfield['label']}</label>
                    <input type="text" {if $kbfield['placeholder'] != ''}placeholder="{$kbfield['placeholder']|escape:'htmlall':'UTF-8'}"{/if} 
                           name='{$kbfield['field_name']|escape:'htmlall':'UTF-8'}' id='{$kbfield['html_id']|escape:'htmlall':'UTF-8'}' class="kbfield {$kbfield['html_class']|escape:'htmlall':'UTF-8'} {if $kbfield['required']}is_required{/if} {if $kbfield['validation'] != ''}validate{/if} form-control"
                           {if $kbfield['validation'] != ''} data-validate="{$kbfield['validation']|escape:'htmlall':'UTF-8'}"{/if} value="{if isset($kbfield['customer_value'])}{$kbfield['customer_value']|escape:'htmlall':'UTF-8'}{/if}"/>
                    {if $kbfield['description'] != ''}<span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>
                    {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                    <script type="text/javascript">
                        $('input[name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}"]').datepicker();
                         $('input[name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}"]').datepicker();
                            $('input[name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}"]').on('keypress keydown keyup', function(e) {
                                e.preventDefault();
                                return false;
                            });                   
                    </script>
                </div>
            {/if}
            {if ($kbfield['type'] == 'file') && ($kbfield['show_registration_form'] == 1)}
                <div class="form-group" style="width: 25%">
                    <label for="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}" {if $kbfield['required']}class="required"{/if}>{$kbfield['label']|escape:'htmlall':'UTF-8'}</label>
                    <input type="file" name="{$kbfield['field_name']|escape:'htmlall':'UTF-8'}" id="{$kbfield['html_id']}" class="kbfield kbfiletype form-control  {if $kbfield['required']}is_required{/if}" />
                    {if $kbfield['description'] != ''}<span class="form-info">({$kbfield['description']|escape:'htmlall':'UTF-8'})</span>{/if}</br>{if $kbfield['file_extension'] != ''} <span class="form-info ">{l s='File must be ' mod='kbmarketplace'}<span class="file_extension">{$kbfield['file_extension']}</span></span></br>{/if}
                    {if $kbfield['error_msg'] != ''}<span class="error_message" style="display:none;">{$kbfield['error_msg']|escape:'htmlall':'UTF-8'}</span>{/if}
                    
                </div>
            {/if}
        {/foreach}
        </div>
    </div>
<div class="checkbox">
    <input type="checkbox"  class="is_required" name="kbmp_registered_as_seller" id="kbmp_registered_as_seller" value="1" class="is_required"/>
    <label for="kbmp_registered_as_seller">{if $kb_seller_agreement != ''}{l s='I have read the agreement and want to register as seller.' mod='kbmarketplace'} (<a id="open_kb_seller_agreement_modal" href="#kb_seller_agreement_modal" style="color: #dd0000;">{l s='Read Seller Agreement' mod='kbmarketplace'}</a>){else}{l s='I agree to all terms and conditions & want to Register as a seller' mod='kbmarketplace'}{/if}</label>
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
    <script>
        var submit_account_btn = 1;
        var kb_not_valid = "{l s='Field is not valid' mod='kbmarketplace'}";
        var seller_checkbox_error_msg = "{l s='Kindly accept the terms and condition for registering as Seller.' mod='kbmarketplace'}";
        var file_not_empty = "{l s='File cannot be empty' mod='kbmarketplace'}";
        var field_not_empty = "{l s='Field cannot be empty' mod='kbmarketplace'}";
        var file_format_error = "{l s='File is not in supported format' mod='kbmarketplace'}";
        $('#account-creation_form').attr('enctype', 'multipart/form-data');
        velovalidation.setErrorLanguage({
            alphanumeric: "{l s='Field should be alphanumeric.' mod='kbmarketplace'}",
            digit_pass: "{l s='Password should contain atleast 1 digit.' mod='kbmarketplace'}",
            empty_field: "{l s='Field cannot be empty.' mod='kbmarketplace'}",
            number_field: "{l s='You can enter only numbers.' mod='kbmarketplace'}",            
            positive_number: "{l s='Number should be greater than 0.' mod='kbmarketplace'}",
            maxchar_field: "{l s='Field cannot be greater than # characters.' mod='kbmarketplace'}",
            minchar_field: "{l s='Field cannot be less than # character(s).' mod='kbmarketplace'}",
            invalid_date: "{l s='Invalid date format.' mod='kbmarketplace'}",
            valid_amount: "{l s='Field should be numeric.' mod='kbmarketplace'}",
            valid_decimal: "{l s='Field can have only upto two decimal values.' mod='kbmarketplace'}",
            maxchar_size: "{l s='Size cannot be greater than # characters.' mod='kbmarketplace'}",
            specialchar_size: "{l s='Size should not have special characters.' mod='kbmarketplace'}",
            maxchar_bar: "{l s='Barcode cannot be greater than # characters.' mod='kbmarketplace'}",
            positive_amount: "{l s='Field should be positive.' mod='kbmarketplace'}",
            maxchar_color: "{l s='Color could not be greater than # characters.' mod='kbmarketplace'}",
            invalid_color: "{l s='Color is not valid.' mod='kbmarketplace'}",
            specialchar: "{l s='Special characters are not allowed.' mod='kbmarketplace'}",
            script: "{l s='Script tags are not allowed.' mod='kbmarketplace'}",
            style: "{l s='Style tags are not allowed.' mod='kbmarketplace'}",
            iframe: "{l s='Iframe tags are not allowed.' mod='kbmarketplace'}",
            image_size: "{l s='Uploaded file size must be less than #.' mod='kbmarketplace'}",
            html_tags: "{l s='Field should not contain HTML tags.' mod='kbmarketplace'}",
            number_pos: "{l s='You can enter only positive numbers.' mod='kbmarketplace'}",
});
    $(document).ready(function(){
   if ($('input[name="passwd"]').length && $('.kb_custom_field_block').length) {
    $('input[name="passwd"]').closest('.form-group').after($('.kb_custom_field_block'));
    $('input[name="kbmp_registered_as_seller"]').attr('required', '');
}     
});
    </script>

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
* @copyright 2017 Knowband
* @license   see file: LICENSE.txt
*
*}