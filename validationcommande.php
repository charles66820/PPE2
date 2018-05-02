<?php
include "assets/php/setting.bdd.php";
include "assets/php/fonctions-panier.php";
include 'assets/php/allcss.php';
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
    $nbArticles = count($_SESSION['panier']['idproduit']);
    for ($i=0 ;$i < $nbArticles ; $i++){
      $contenuMail .=
      '
      <div class="col-12 col-md-12 mb-2" style="box-shadow: 1px 0 5px 0 rgba(0,0,0,0.2);">
        <div class="row">
          <div class="col-xs-2 col-sm-6 col-md-8 col-lg-9">
            <label class="col-form-label">'.htmlspecialchars($_SESSION['panier']['LibelleProduit'][$i]).'</label>
          </div>
          <div class="col-xs-1 col-sm-6 col-md-4 col-lg-3">
            <label class="col-form-label">'.htmlspecialchars($_SESSION['panier']['prixUnitaireHT'][$i]).'€</label>
            <label class="col-form-label pull-right m-1">'.htmlspecialchars($_SESSION['panier']['quantiteProduit'][$i]).'</label>
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
          <label>&nbsp;Prix total HT :'.MontantGlobal().'€</label>
        </div>
      </div>
    </div>
  </body>
</html>
';
echo $contenuMail;
 ?>
