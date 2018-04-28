<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Catalogue</title>
    <?php include 'assets/php/allcss.php'; ?>
    <link rel="stylesheet" href="/assets/css/catalogue.css">
    <link rel="stylesheet" href="/assets/css/avis.css">
  </head>

  <body>
    <?php
    include 'assets/php/nav.php';
    include 'assets/php/fonction-catalogue.php';
    ?>

    <div style="display:  inline-block; vertical-align:  top;margin: 20px;">
      <nav>
        <div class="range">
          <form action="/catalogue.php">
            <?php if (!empty($categorie)) {?><input type="hidden" name="categorie" value="<?php echo $categorie ?>"><?php } ?>
            <?php if (!empty($type)) {?><input type="hidden" name="type" value="<?php echo $type ?>"><?php } ?>
            <?php if (!empty($stars)) {?><input type="hidden" name="stars" value="<?php echo $stars ?>"><?php } ?>
            Prix de : <input type="range" name="maxprice" min="0" max="100" value="<?php echo $maxprice ?>">€
            <?php if (!empty($search)) {?><input type="hidden" name="search" value="<?php echo $search ?>"><?php } ?>
            <input type="submit">
          </form>
        </div>
        <div class="rectangle">
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=0'); ?>"><div class="starsbox stars stars0"></div> <div class="etplus">&plus</div></a> <!-- Met le "&plus" en face des étoiles -->
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=1'); ?>"><div class="starsbox stars stars1"></div> <div class="etplus">&plus</div></a>
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=2'); ?>"><div class="starsbox stars stars2"></div> <div class="etplus">&plus</div></a>
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=3'); ?>"><div class="starsbox stars stars3"></div> <div class="etplus">&plus</div></a>
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=4'); ?>"><div class="starsbox stars stars4"></div> <div class="etplus">&plus</div></a>
          <a href="/catalogue.php?<?php echo genurl('stars', 'stars=5'); ?>"><div class="starsbox stars stars5"></div></a>
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
          } else {
            $imgproduitrep = $reqphotoproduit->fetch();
            $imgproduit = '/assets/img/imagesupload/'.$imgproduitrep["Photo"];
          }

          //selectionne la moyenne des notes du produit
          $reqpmoyenne = $bdd->prepare("SELECT ROUND(AVG(Note), 1) as 'moyenne' FROM avis WHERE IDProduit = ? GROUP BY IDProduit");
          $reqpmoyenne->execute(array($row["IDProduit"]));
          $dbrepmoyenne = $reqpmoyenne->fetch();
          $moyenavis = (float)$dbrepmoyenne['moyenne'];

          //Afficher le produit
          ?>
          <a href="/produit.php?id=<?php echo $row["IDProduit"];?>" class="articleElm articleBox">
            <div class="articleNom">
              <?php echo $row["LibelleProduit"];?>
            </div>
            <div class="imgBox">
              <img src="<?php echo $imgproduit; ?>" alt="">
            </div>
            <div class="stars <?php echo affichestar($moyenavis); ?>" style="height: 26px; width: 148px; float: left; margin: 8px 16px;"></div>
            <div class="articlePrix">
              <?php echo $row["PrixUnitaireHT"]; ?>
            </div>
          </a>
          <?php
        }
        ?>

      </div>
    </div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
    <script src="/assets/js/avis.js"></script>
  </body>
</html>
