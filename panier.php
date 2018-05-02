<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Votre panier</title>
    <?php include 'assets/php/allcss.php'; ?>
  </head>
  <body>
    <?php include 'assets/php/nav.php';
    include("assets/php/fonctions-panier.php");

    if (isset($_POST['quentiterplus']) && !empty($_POST['quentiterplus']) && isset($_POST['produitidlignepanier']) && !empty($_POST['produitidlignepanier'])) {
      modifierQTeArticle(intval(htmlspecialchars($_POST['produitidlignepanier'])), intval(htmlspecialchars($_POST['quentiterplus'])));
    }
    if (isset($_POST['quentitermoins']) && isset($_POST['produitidlignepanier']) && !empty($_POST['produitidlignepanier'])) {
      modifierQTeArticle(intval(htmlspecialchars($_POST['produitidlignepanier'])), intval(htmlspecialchars($_POST['quentitermoins'])));
    }
    ?>
    <div class="container pb-1" style="box-shadow: 1px 0 5px 0 rgba(0,0,0,0.2);">
      <div class="col-12 col-md-12 mb-2">
        <div class="row">
          <div class="col col-sm-6 col-md-8 col-lg-9"><label class="col-form-label">Nom</label></div>
          <div class="col col-sm-2 col-md-1 col-lg-1"><label class="col-form-label">Prix</label></div>
          <div class="col col-sm-4 col-md-3 col-lg-2"><label class="col-form-label pull-right">Quantité</label></div>
        </div>
      </div>
      <?php

      if (creationPanier()){
        $nbArticles = count($_SESSION['panier']['idproduit']);
        if ($nbArticles <= 0){
          ?>
          <div class="ml-2 mb-5">Votre panier est vide</div>
          <?php
        } else {
          for ($i=0 ;$i < $nbArticles ; $i++){
            ?>
            <div class="col-12 col-md-12 mb-2" style="box-shadow: 1px 0 5px 0 rgba(0,0,0,0.2);">
              <div class="row">
                <div class="col-xs-2 col-sm-6 col-md-8 col-lg-9">
                  <label class="col-form-label"><?php echo htmlspecialchars($_SESSION['panier']['LibelleProduit'][$i]) ?></label>
                </div>
                <div class="col-xs-1 col-sm-6 col-md-4 col-lg-3">
                  <label class="col-form-label"><?php echo htmlspecialchars($_SESSION['panier']['prixUnitaireHT'][$i]) ?>€</label>
                  <form method="post" style="display: initial;">
                    <input type="hidden" name="produitidlignepanier" value="<?php echo htmlspecialchars($_SESSION['panier']['idproduit'][$i]) ?>">
                    <button class="btn btn-primary pull-right m-1" name="quentiterplus" value="<?php echo htmlspecialchars($_SESSION['panier']['quantiteProduit'][$i])+1 ?>" type="submit">+</button>
                  </form>
                  <form method="post" style="display: initial;">
                    <input type="hidden" name="produitidlignepanier" value="<?php echo htmlspecialchars($_SESSION['panier']['idproduit'][$i]) ?>">
                    <button class="btn btn-primary pull-right m-1" name="quentitermoins" value="<?php echo htmlspecialchars($_SESSION['panier']['quantiteProduit'][$i])-1 ?>" type="submit">-</button>
                  </form>
                  <label class="col-form-label pull-right m-1"><?php echo htmlspecialchars($_SESSION['panier']['quantiteProduit'][$i]) ?></label>
                </div>
              </div>
            </div>
            <?php
          }
        }
      }
      ?>
      <div class="mb-3">
        <div class="col-xs-1">
          <label>Sous-total (nbre d'articles) : <?php echo compterArticles(); ?></label>
        </div>
        <div class="col-xs-1">
          <label>&nbsp;Prix total HT : <?php echo MontantGlobal(); ?>€</label>
          <button class="btn btn-primary pull-right" type="button" onclick="document.location.href='commander.php'">Passer la commande</button>
        </div>
      </div>
    </div>
    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
