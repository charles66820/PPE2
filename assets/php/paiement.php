<?php
include 'assets/php/braintree-paypal/lib/Braintree.php';

$gateway = new Braintree_Gateway(array(
  'accessToken' => 'access_token$sandbox$v743jd8dx9tcqm7d$b74e1af2628d3cfd035f697d05de5fd0',
));

$result = $gateway->transaction()->sale([
  'amount' => '10.00',
  'paymentMethodNonce' => 'nonceFromTheClient',
  'options' => [
    'submitForSettlement' => True
  ]
]);
if(isset($_POST['validecommande'])){
  echo $_POST['validecommande'];
}

if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}
?>
