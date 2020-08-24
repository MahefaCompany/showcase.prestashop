<?php
require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__."/Liste.php";

$liste = (new \Liste())->all();

// dump($liste); die;

if ($_POST) {
    \Stripe\Stripe::setApiKey('sk_test_51H9qbOLKOBZ05EFrMyMNKmxekuCiFvRSDWV27qRd351mIW7v0EUmaTcPtbP7LHzHrkIpduQ0O4Zt2trkVHf2aRWh00gSz9Tz2V');
  $error = '';
  $success = '';
  try {
    if (!isset($_POST['tokenAccount']))
      throw new Exception("The Stripe Token was not generated correctly");
      $token = $_POST['tokenAccount'];
        $account = \Stripe\Account::create([
            'country' => 'US',
            'type' => 'custom',
            'default_currency' => 'usd',
                'requested_capabilities' => [
                  'card_payments',
                  'transfers',
            ],
            'account_token' => $token,
        ]);
    echo $success = 'successful.';
  }
  catch (Exception $e) {
    echo $error = $e->getMessage();
  }
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title>Stripe Getting Started Form</title>
        <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
        <!-- jQuery is used only for this example; it isn't required to use Stripe -->
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    </head>
    <body>
        <!-- to display errors returned by createToken -->
        <!-- <span class="payment-errors"><?= $error ?? "error)" ?></span>
        <span class="payment-success"><?= $success ?? "success)" ?></span>
        <form action="" method="POST" id="payment-form">
            <div class="form-row">
                <label>Card Number</label>
                <input type="text" size="20" autocomplete="off" class="card-number" value="4242424242424242"/>
            </div>
            <div class="form-row">
                <label>CVC</label>
                <input type="text" size="4" autocomplete="off" class="card-cvc" value="123"/>
            </div>
            <div class="form-row">
                <label>Expiration (MM/YYYY)</label>
                <input type="text" size="2" class="card-expiry-month" value="11"/>
                <span> / </span>
                <input type="text" size="4" class="card-expiry-year" value="21" />
            </div>
            <input type="hidden" name="token-person" id="token-person">
            <input type="hidden" name="token-account" id="token-account">
            <button type="submit" class="submit-button">Submit</button>
        </form> -->

        <script type="text/javascript">

            function sleep(ms, cqllbqck) {
            return new Promise(resolve => setTimeout(resolve, ms));
            // setTimeout(function(){
            //     cqllbqck();
            // }, ms);
            }

            // Assumes you've already included Stripe.js!
            const stripe = Stripe('pk_test_51H9qbOLKOBZ05EFrCh6Xiq5ybWDUzwEJsLymddhp9SIIPRucjawLdJImgj1eJqFZS7oH8O8YOsHogAAcSkpWSuA700drl1cgFX');
            const myForm = document.querySelector('#payment-form');
            // myForm.addEventListener('submit', handleForm);

            async function handleForm() {
                // event.preventDefault();

                let listVendeur = '<?= $liste ?>';
                listVendeur = JSON.parse(listVendeur);
                // console.log("handleForm", listVendeur);

                const timeoutStripe = 5000; //30000;
                var time = timeoutStripe;
                listVendeur.forEach(item => {
                    sleep(time).then(() => {
                        console.log("reveille", time, item);
                        startDoStaff(item);
                    });
                    time += timeoutStripe;
                });
                return;

                
            }

            async function doStaff(item){
                console.log("doStaff", item);
                if(item == undefined) return;
                const accountResult = await stripe.createToken('account', {
                    business_type: 'company',
                    company: {
                        name: item.firstname + " " + item.lastname,
                    },
                    tos_shown_and_accepted: true,
                });
                const personResult = await stripe.createToken('person', {
                    person: {
                        first_name: item.firstname,
                        last_name: item.lastname,
                    },
                });

                if (accountResult.token && personResult.token) {
                    // document.querySelector('#token-account').value = accountResult.token.id;
                    // document.querySelector('#token-person').value = personResult.token.id;
                    createAccount(accountResult, personResult);
                }
            }

            // Start function
            const startDoStaff = async function(item) {
                return await doStaff(item);
            }
            

            function createAccount(accountResult, personResult){
                console.log("createAccount", accountResult, personResult);
                const data = {
                        "tokenAccount": accountResult.token.id, 
                        // "tokenAccount": personResult.token.id
                    };
                console.log("createAccount", data);
                $.ajax({
                    url : 'https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/index.php',
                    type : 'POST',
                    // dataType : 'json',
                    // crossDomain: true,
                    data: data,
                    success : function(response, statut){ // success est toujours en place, bien sûr !
                        console.log("createAccount", response);
                        //handleForm(null, response);
                    },

                    error : function(resultat, statut, erreur){

                    }

                });
            }
            
            
            // Start function
            const start = async function() {
                const result = await handleForm();
            }
            start();
        </script>
    </body>
</html>