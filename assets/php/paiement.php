<?php
require 'setting.bdd.php';
include 'braintree-paypal/lib/Braintree.php';

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

  $reqselectadresse = $bdd->prepare("SELECT * FROM lignepanier, produits WHERE lignepanier.IDProduit = produits.IDProduit AND lignepanier.IDClient = ?");
  $reqselectadresse->execute(array($_SESSION['id']));
  if ($reqselectadresse->rowCount() <= 0){
      echo '<script> document.location.replace("accueil.php"); </script>';
    } else {
      foreach ($reqselectadresse->fetchAll() as $rows) {
      echo htmlspecialchars($rows['LibelleProduit']);
      echo htmlspecialchars($rows['PrixUnitaireHT']);
      echo htmlspecialchars($rows['quantite']);
      echo $_POST['adressefacturation'];
      echo $_POST['adresselivreson'];

      }
    }
  }



if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}
?>
