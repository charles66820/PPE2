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

    <div style="display:  inline-block; vertical-align:  top;margin: 20px;">
      <nav>
        <div class="range">
          <form>
            <?php if (!empty($categorie)) {?><input type="hidden" name="categorie" value="<?php echo $categorie ?>"><?php } ?>
            <?php if (!empty($type)) {?><input type="hidden" name="type" value="<?php echo $type ?>"><?php } ?>
            <?php if (!empty($stars)) {?><input type="hidden" name="stars" value="<?php echo $stars ?>"><?php } ?>
            Prix de : <input type="range" name="maxprice" min="0" max="100" value="<?php echo $maxprice ?>">€
            <?php if (!empty($search)) {?><input type="hidden" name="search" value="<?php echo $search ?>"><?php } ?>
            <input type="submit">
          </form>
        </div>
        <div class="rectangle">
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=0'); ?>"><div class="starsbox stars stars0"></div> <div class="etplus">&plus</div> </a> <!-- Met le "&plus" en face des étoiles -->
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=1'); ?>"><div class="starsbox stars stars1"></div> <div class="etplus">&plus</div> </a> <!-- Met le "&plus" en face des étoiles -->
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=2'); ?>"><div class="starsbox stars stars2"></div> <div class="etplus">&plus</div> </a>
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=3'); ?>"><div class="starsbox stars stars3"></div> <div class="etplus">&plus</div> </a>
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=4'); ?>"><div class="starsbox stars stars4"></div> <div class="etplus">&plus</div> </a>
          <a href="catalogue.php?<?php echo genurl('stars', 'stars=5'); ?>"><div class="starsbox stars stars5"></div></a>
        </div>
      </nav>
    </div>
    <div class="col-md-8" style="display: inline-block;">
      <div class="container" style="min-height:300px;">
        <?php
        //Création de la requête sql
        // TODO: Faire la requête sql en fonction du choix dans le menu (navbar)
        //selectionne tous le produit. requet par default
        $sql = "SELECT produits.IDProduit, produits.LibelleProduit, produits.PrixUnitaireHT FROM produits WHERE produits.IDProduit = produits.IDProduit ";

        //selection les produit avec la sous categorie qui est égale a la valeur de $type
        if (!empty($type)) {
          $sql = "SELECT produits.IDProduit, produits.LibelleProduit, produits.PrixUnitaireHT FROM produits, souscategorie WHERE produits.IdCategorie = souscategorie.IdCategorie AND souscategorie.nomsouscat = '".$type."' ";
        }

        $stars;// selesction le produit en fontion de la moyende des avie une requet sql dans une autre avec un est plus grant ou égale (peut sajouter dans nimportquelle requet)

        $maxprice;//selectionne les produit qui on un prix plu petit ou éguale au prix dans $maxprice (peut sajouter dans nimportquelle requet)
        if (!empty($maxprice)) {
          $sql .="AND produits.PrixUnitaireHT <= '".$maxprice."'";
        }

        $search;//crée une requete sql qui recherche la valeur re $search dans le lbl du produit, dans la reference du produit et dans description du produit on utilise LIKE %$search% (peut sajouter dans nimportquelle requet)



        //récuprére les profuit avec une requet sql
        $reqproduit = $bdd->prepare($sql);
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
          echo '<a href="produit.php?id='.$row["IDProduit"].'" class="articleElm articleBox">
          <div class="articleNom">
          '.$row["LibelleProduit"].'
          </div>
          <div class="imgBox">
            <img src="'.$imgproduit.'" alt="">
          </div>
          <div class="stars stars3_5'./*stars0_5 ou stars4_5*/'" style="height: 26px; width: 148px; float: left; margin: 8px 16px;">
          </div>
          <div class="articlePrix">
          '.$row["PrixUnitaireHT"].'
          </div>
          </a>';
        }
        ?>
      </div>
    </div>

    <!-- pour gérée l'avie avec les étoiles -->
    <div id="starsselecteur" class="stars0">
      <img src="assets/img/empty_star.png" style="margin-left:0px;" alt="1 étoiles" height="28" width="28" data-star="1">
      <img src="assets/img/empty_star.png" alt="2 étoiles" height="28" width="28" data-star="2">
      <img src="assets/img/empty_star.png" alt="3 étoiles" height="28" width="28" data-star="3">
      <img src="assets/img/empty_star.png" alt="4 étoiles" height="28" width="28" data-star="4">
      <img src="assets/img/empty_star.png" alt="5 étoiles" height="28" width="28" data-star="5">
      <input type="hidden" name="avis" value="0">
    </div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/avis.js"></script>
  </body>
</html>
