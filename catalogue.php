<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logoIcon.gif"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/catalogue.css">
    <link rel="stylesheet" href="/assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="/assets/css/stylesF.css">
  </head>

  <body>
    <?php include 'assets/php/nav.php'; ?>

    <div class="col-md-4" style="float: left; width: 280px;">
      <nav>
        <div class="range">
          <form action="/action_page.php">
            Prix de : <input type="range" name="points" min="0" max="100">€
            <input type="submit">
          </form>
        </div>
        <div class="rectangle">
        <?php
        if ( isset($_GET['type']) && isset($_GET['categorie']) ) {
          $categorie = "categorie=".$_GET['categorie']."&";
          $type ="type=".$_GET['type']."&";
        }elseif(isset($_GET['categorie'])) {
          $categorie = "categorie=".$_GET['categorie']."&";
          $type = '';
        } else
        {
          $categorie = '';
          $type = '';
        }
        ?>
          <a href="catalogue.php?<?php echo $categorie.$type ?>stars=1"><div class="stars1"></div> <div class="etplus" style="top: 10px;">&plus</div> <a/> <!-- Met le "&plus" en face des étoiles -->
          <a href="catalogue.php?<?php echo $categorie.$type ?>stars=2"><div class="stars2"></div> <div class="etplus" style="top: 45px;">&plus</div> <a/>
          <a href="catalogue.php?<?php echo $categorie.$type ?>stars=3"><div class="stars3"></div> <div class="etplus" style="top: 80px;">&plus</div> <a/>
          <a href="catalogue.php?<?php echo $categorie.$type ?>stars=4"><div class="stars4"></div> <div class="etplus" style="top: 115px;">&plus</div> <a/>
          <a href="catalogue.php?<?php echo $categorie.$type ?>stars=5"><div class="stars5"></div> <div class="etplus" style="top: 115px;">&plus</div> <a/>
        </div>
      </nav>
    </div>
    <div class="col-md-8" style="display: inline-block;">
      <div class="container articleBox">
        <?php
        //Création de la requête sql
        // TODO: Faire la requête sql en fonction du choix dans le menu (navbar)
        $reqproduit = $bdd->prepare("SELECT * FROM produits");
        $reqproduit->execute();
        $dbrep = $reqproduit->fetchAll();

        //Chargement des produits du catalogue
        foreach ($dbrep as $row) {
          //Récupère l'image par raport à l'id du produit
          $reqphotoproduit = $bdd->prepare("SELECT * FROM photoproduit WHERE IDProduit = ?");
          $reqphotoproduit->execute(array($row["IDProduit"]));
          $produitexist = $reqphotoproduit->rowCount();

          //Teste s'il y a une photo pour le produit ou pas
          if ($produitexist == 0) {
            $imgproduit = '/assets/img/defaultproduitimg.png';
          }else {
            $imgproduitrep = $reqphotoproduit->fetch();
            $imgproduit = '/assets/img/imagesupload/'.$imgproduitrep["Photo"];
          }

          //Afficher le produit
          echo '<a href="produit.php?id='.$row["IDProduit"].'" class="articleElm">
          <div class="articleNom">
          '.$row["LibelleProduit"].'
          </div>
          <div class="imgBox">
            <img src="'.$imgproduit.'" alt="">
          </div>
          <div class="stars3_5'./*stars0_5 ou stars4_5*/'" style="height: 35px; width: 182px; float: left;">
          </div>
          <div class="articlePrix">
          '.$row["PrixUnitaireHT"].'
          </div>
          </a>';
        }
        ?>
      </div>
    </div>
    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
