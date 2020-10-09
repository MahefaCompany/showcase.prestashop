// Maka token stripe
// tokenStripe = ?
$(document).ready(function () {
  window.pk_stripe = "";
  $.get(
      "https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/show_pk_stripe.php"
    )
    .done(function (data) {
      console.log(data);
      window.pk_stripe = data;

      const stripe = Stripe(window.pk_stripe);

    })

  $("table.kb_mp_seller>tbody>tr>td:last-child>ul.dropdown-menu>li:first-child>a").on("click", function () {
    idSeller = $(this).parent().parent().parent().parent().parent().parent().children("td:nth-child(2)").html()
    firstName = $(this).parent().parent().parent().parent().parent().parent().children("td:nth-child(3)").html()
    lastName = $(this).parent().parent().parent().parent().parent().parent().children("td:nth-child(4)").html()
    email = $(this).parent().parent().parent().parent().parent().parent().children("td:nth-child(5)").html()

    sendRequiresDatastoBeApprouved(stripe, firstName, lastName, idSeller, email);
  });

  async function sendRequiresDatastoBeApprouved(stripe, _firstName, _lastName, _idSeller = null, _email) {

    var company = _firstName + " " + _lastName
    const accountResult = await stripe.createToken("account", {
      business_type: "company",
      company: {
        name: company,
      },
      tos_shown_and_accepted: true,
    });

    if (accountResult.token) {
      $.post(
          "https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/save_token.php", {
            email: _email,
            tokenaccount: accountResult.token.id,
          }
        ).done(function (data) {
          if (data == "success") {
            $.post(
              "https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/admin/approuveAccount.php", {
                idSeller: _idSeller,
                email: _email,
              }
            )
          }
        })
        .fail(function () {
          console.log("Token Account can't be saved ");
        });
    }
  }
});


// -------------------------------