<?php
//erreur provoquer par le !https

include 'assets/php/braintree-paypal/lib/Braintree.php';

$gateway = new Braintree_Gateway(array(
  'accessToken' => 'access_token$sandbox$v743jd8dx9tcqm7d$b74e1af2628d3cfd035f697d05de5fd0',
));

?>
<button type="button" id="paypal-button"></button>
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
<script src="https://js.braintreegateway.com/web/3.25.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.25.0/js/paypal-checkout.min.js"></script>
<script>
paypal.Button.render({
  //braintree: braintree,
  client: {
    production: '<?php echo $clientToken = $gateway->clientToken()->generate() ?>',
    sandbox: '<?php echo $clientToken = $gateway->clientToken()->generate() ?>'
  },
  env: 'sandbox', // production or 'sandbox'
  commit: true, // This will add the transaction amount to the PayPal button

  payment: function (data, actions) {
    return actions.braintree.create({
      payment: {
        transactions: [
          {
            amount: { total: '0.01', currency: 'EUR' }
          }
        ]
      }
      // flow: 'checkout', // Required
      // amount: 10.00, // Required
      // currency: 'EUR', // Required
      // enableShippingAddress: true,
      // shippingAddressEditable: false,
      // shippingAddressOverride: {
      //   recipientName: 'Poulpi OTako',
      //   line1: '',
      //   line2: '',
      //   city: 'Perpignan',
      //   countryCode: 'FR',
      //   postalCode: '66000',
      //   state: 'France',
      //   phone: '+33427868423'
      // }
    });
  },

  onAuthorize: function (payload) {
    // Submit `payload.nonce` to your server.
    return actions.payment.execute().then(function() {//add
      window.alert('Payment Complete!');
    });
  },
}, '#paypal-button');
</script>
<?php
//erreur provoquer par le !https
// [
//   "amount" => 10 /*$_POST['amount']*/,
//   'merchantAccountId' => 'EUR',
//   "paymentMethodNonce" => 'paypal'/*$_POST['payment_method_nonce']*/,
//   "orderId" => 'FR9012345971744130112093589'/*$_POST['Mapped to PayPal Invoice Number']*/,
//   "descriptor" => [
//     "name" => "Descriptor displayed in customer CC statements. 22 char max"
//   ],
//   "shipping" => [
//     "firstName" => "Jen",
//     "lastName" => "Smith",
//     "company" => "Braintree",
//     "streetAddress" => "1 E 1st St",
//     "extendedAddress" => "Suite 403",
//     "locality" => "Bartlett",
//     "region" => "IL",
//     "postalCode" => "60103",
//     "countryCodeAlpha2" => "FR"
//   ],
//   "options" => [
//     "paypal" => [
//       "customField" => 'untest'/*$_POST["PayPal custom field"]*/,
//       "description" => 'une description'/*$_POST["Description for PayPal email receipt"]*/
//     ],
//   ]
// ]
?>
