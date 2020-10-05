$(document).ready(function(){
    window.pk_stripe = '';
    $.get("https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/show_pk_stripe.php")
        .done(function(data){
            window.pk_stripe = data;

            const stripe = Stripe(window.pk_stripe);

            $(document).on("submit", "#account-creation_form", function(event) {
                event.preventDefault();
                if($("#kbmp_registered_as_seller:checked").val() == 1){
                    handleForm(stripe); 
                }else{
                    $(document).off("submit", "#account-creation_form");
                    $("#account-creation_form").submit();
                }
            });

        })
        .fail(function() {
            $(document).off("submit", "#account-creation_form");
            $("#account-creation_form").submit();
        });
    

    async function handleForm(stripe)
    {
        var company = $('#customer_firstname').val() + ' ' + $('#customer_lastname').val();
        const accountResult = await stripe.createToken('account', {
            business_type: 'company',
            company: {
                name: company,
            },
            tos_shown_and_accepted: true,
        });

        if (accountResult.token) {
            var email = $('#email').val();
            $.post( "https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/save_token.php", { 
                email: email, 
                tokenaccount: accountResult.token.id,
            })
            .done(function(data) {
                if(data == 'success'){
                    $(document).off("submit", "#account-creation_form");
                    $("#account-creation_form").submit();
                }else{
                    console.log('erreur inconnue');
                }
            })
            .fail(function() {
                $(document).off("submit", "#account-creation_form");
                $("#account-creation_form").submit();
            });
        }
    }
});