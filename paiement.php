<button type="button" id="paypal-button"></button>
<script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
<script src="https://js.braintreegateway.com/web/3.25.0/js/client.min.js"></script>
<script src="https://js.braintreegateway.com/web/3.25.0/js/paypal-checkout.min.js"></script>
<script>
paypal.Button.render({
  braintree: braintree,
  client: {
    production: 'CLIENT_TOKEN_FROM_SERVER',
    sandbox: 'CLIENT_TOKEN_FROM_SERVER'
  },
  env: 'sandbox', // production or 'sandbox'
  commit: true, // This will add the transaction amount to the PayPal button

  payment: function (data, actions) {
    return actions.braintree.create({
      flow: 'checkout', // Required
      amount: 10.00, // Required
      currency: 'EUR', // Required
      enableShippingAddress: true,
      shippingAddressEditable: false,
      shippingAddressOverride: {
        recipientName: 'Poulpi OTako',
        line1: '',
        line2: '',
        city: 'Perpignan',
        countryCode: 'FR',
        postalCode: '66000',
        state: 'France',
        phone: '+33427868423'
      }
    });
  },

  onAuthorize: function (payload) {
    // Submit `payload.nonce` to your server.
  },
}, '#paypal-button');
</script>
<?php
//include 'assets/php/braintree-paypal/ib/Braintree.php';

$gateway = new Braintree_Gateway(array(
    'accessToken' => 'access_token$sandbox$t8mb4ydrkjp2s573$eb245406747761815f3c3ada574023e2',
));
?>
