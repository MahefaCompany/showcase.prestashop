<?php
require_once __DIR__."/../../../../config/config.inc.php";
require_once _PS_MODULE_DIR_."/stripe_marketplace_automatizer/stripe-php/init.php";
require_once __DIR__."/../../vendor/autoload.php";
require_once __DIR__."/Liste.php";

$liste = (new \Liste())->all();

// dump($liste); die;

if ($_POST) {

    function updateSellerInfo($id_seller, $id_acct){
        $request = "INSERT INTO "._DB_PREFIX_. "sma_seller_acct (id_seller, id_acct) VALUES ('".$id_seller."', '".$id_acct."')";
        return \Db::getInstance()->execute($request);
    }

    \Stripe\Stripe::setApiKey('sk_test_iLXqSeMiKZXcexyjxqQSChl0');
    try {
        if (!isset($_POST['tokenAccount']))
            die(json_encode([
                "code" => "error_not_good_parametter",
                "message" => "tokenAccount missing",
            ]));
        if (!isset($_POST['id_seller']))
            die(json_encode([
                "code" => "error_not_good_parametter",
                "message" => "id_seller missing",
            ]));
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
        if($account["object"] == 'account'){
            $id_seller = $_POST['id_seller'];
            $id_acct = $account["id"];
            updateSellerInfo($id_seller, $id_acct);
            die(json_encode([
                "message" => "successful",
                "resultStripe" => $account,
            ]));
        }else{
            die(json_encode([
                "message" => "error_not_good_response",
                "resultStripe" => $account,
            ]));
        }
    }catch (Exception $e) {
        die(json_encode([
            "message" => "error_exception",
            "resultStripe" => $e->getMessage(),
        ]));
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
        <script type="text/javascript">
            function sleep(ms, cqllbqck) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            const stripe = Stripe('pk_test_xRSiDl60ZAwr2qbXZhk7NOAf');
            const myForm = document.querySelector('#payment-form');

            async function handleForm() {
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
                    createAccount(accountResult, personResult, item.id_seller);
                }
            }

            // Start function
            const startDoStaff = async function(item) {
                return await doStaff(item);
            }
            

            function createAccount(accountResult, personResult, id_seller){
                console.log("createAccount", accountResult, personResult);
                const data = {
                    "tokenAccount": accountResult.token.id, 
                    // "tokenAccount": personResult.token.id
                     "id_seller": id_seller,
                };
                console.log("createAccount", data);
                $.ajax({
                    url : 'https://lecannet.cliccommerce.fr/modules/stripe_marketplace_automatizer/controllers/front/creacc.php',
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
            
            const start = async function() {
                const result = await handleForm();
            }
            start();
        </script>
    </body>
</html>