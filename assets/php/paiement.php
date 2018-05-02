<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'setting.bdd.php';
include "fonctions-panier.php";
include 'braintree-paypal/lib/Braintree.php';
$mailCommande = new PHPMailer(true);                              // Passing `true` enables exceptions
$mailCommande->SMTPDebug = 0;                                 // Enable verbose debug output
$mailCommande->isSMTP();                                      // Set mailer to use SMTP
$mailCommande->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mailCommande->SMTPAuth = true;                               // Enable SMTP authentication
$mailCommande->Username = 'cornichon66820@gmail.com';                 // SMTP username
$mailCommande->Password = 'concombre';                           // SMTP password
$mailCommande->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mailCommande->Port = 465;// or 587                           // TCP port to connect to

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

  $reqselectlignepgnierproduit = $bdd->prepare("SELECT * FROM lignepanier, produits WHERE lignepanier.IDProduit = produits.IDProduit AND lignepanier.IDClient = ?");
  $reqselectlignepgnierproduit->execute(array($_SESSION['id']));
  if ($reqselectlignepgnierproduit->rowCount() <= 0){
    echo '<script> document.location.replace("/accueil.php"); </script>';
  } else {
    $reppp = $reqselectlignepgnierproduit->fetchAll();
    $totalht = 0;
    $fraitport = 10;
    foreach ($reppp as $rows) {
      $totalht += (htmlspecialchars($rows['PrixUnitaireHT']) * intval(htmlspecialchars($rows['quantite'])));
    }
    $prixttc = (($totalht+$fraitport)*1.2);
  }
  $reqinsetcommande = $bdd->prepare("INSERT INTO `commande`(`TotalHT`, `TotalTVA`, `FraisPortHT`, `IDClient`, `IDAdresseFacturation`, `IDAdresseLivraison`) VALUES (?, ?, ?, ?, ?, ?)");
  $reqinsetcommande->execute(array($totalht, $prixttc, $fraitport, $_SESSION['id'], htmlspecialchars($_POST['adressefacturation']), htmlspecialchars($_POST['adresselivreson'])));
  $commandeid = $bdd->lastInsertId();

  foreach ($reppp as $rowx) {
    $reqinsetcontenucommande = $bdd->prepare("INSERT INTO `contenucommande`(`PrixUnitaireHT`, `QuantiteContenu`, `IDTauxTaxe`, `IDCommande`, `idproduit`) VALUES (?, ?, ?, ?, ?)");
    $reqinsetcontenucommande->execute(array(htmlspecialchars($rowx['PrixUnitaireHT']), intval(htmlspecialchars($rowx['quantite'])), 1, intval($commandeid), intval(htmlspecialchars($rowx['IDProduit']))));
  }
  supprimePanier();

  $reqmailclient = $bdd->prepare("SELECT Email FROM client WHERE IDClient = ?");
  $reqmailclient->execute(array($_SESSION['id']));
  //Recipients
  $mailCommande->setFrom('cornichon66820@gmail.com');
  $mailCommande->addAddress($reqmailclient->fetch()['Email']);
  $mailCommande->Subject = 'Votre commande';

  $contenuMail = '
  <html>
    <body>
    <div class="container pb-1" style="box-shadow: 1px 0 5px 0 rgba(0,0,0,0.2);">
      <div class="col-12 col-md-12 mb-2">
        <div class="row">
          <div class="col col-sm-6 col-md-8 col-lg-9"><label class="col-form-label">Nom</label></div>
          <div class="col col-sm-2 col-md-1 col-lg-1"><label class="col-form-label">Prix</label></div>
          <div class="col col-sm-4 col-md-3 col-lg-2"><label class="col-form-label pull-right">Quantité</label></div>
        </div>
      </div>';
      foreach ($reppp as $rowz) {

        $contenuMail .=
        '
        <div class="col-12 col-md-12 mb-2" style="box-shadow: 1px 0 5px 0 rgba(0,0,0,0.2);">
          <div class="row">
            <div class="col-xs-2 col-sm-6 col-md-8 col-lg-9">
              <label class="col-form-label">'.htmlspecialchars($rowz['LibelleProduit']).'</label>
            </div>
            <div class="col-xs-1 col-sm-6 col-md-4 col-lg-3">
              <label class="col-form-label">'.htmlspecialchars($rowz['prixUnitaireHT']).'€</label>
              <label class="col-form-label pull-right m-1">'.htmlspecialchars($rowz['quantiteProduit']).'</label>
            </div>
          </div>
        </div>
        ';
      }
      $contenuMail .= '
        <div class="mb-3">
          <div class="col-xs-1">
            <label>Sous-total (nre d article) :'.compterArticles().'</label>
          </div>
          <div class="col-xs-1">
          <label>&nbsp;Prix total HT :'.$totalht.'€</label>
            <label>&nbsp;Prix total TTC :'.$prixttc.'€</label>
          </div>
          <h3>Votre commande a été expédier ! Vous le resevez dans 2 semaines.</h3>
        </div>
      </div>
    </body>
  </html>
  ';

  $mailCommande->Body = $contenuMail;
  $mailCommande->AltBody = 'utilise une messageri qui supporte le html';
  $mailCommande->send();
  echo '<script> document.location.replace("/commandes.php"); </script>';
}



if ($result->success) {
  print_r("Success ID: " . $result->transaction->id);
} else {
  print_r("Error Message: " . $result->message);
}
?>
