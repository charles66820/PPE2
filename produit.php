<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Untitled</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logoIcon.gif"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="/assets/css/stylesF.css">
    <link rel="stylesheet" href="/assets/css/avis.css">
    <link rel="stylesheet" href="/assets/css/styleavis.css">
  </head>

  <body>
    <?php include 'assets/php/nav.php'; ?>
    <div>
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="m-2" style="overflow:auto; position:relative">
              <img class="rounded mx-auto d-block" id="imgproduit" src="/assets/img/defaultproduitimg.png" data-bs-hover-animate="pulse" style="width:422px; max-width:none; height:385px;">
            </div>

            <div class="m-2" id="listimgproduit">
              <?php
              //récupére le nom et l'id des photo du produit
              $reqphotoproduit = $bdd->prepare("SELECT * FROM photoproduit WHERE IDProduit = ?");
              $reqphotoproduit->execute(array($_GET['id']));
              $photosProduit = $reqphotoproduit->fetchAll();
              //affiche les images qui sont existente dans la bdd
              foreach ($photosProduit as $photo) {
                echo '<img src="/assets/img/imagesupload/'.$photo["Photo"].'" data-image-id="'.$photo["IDPhotoProduit"].'" style="width:80px;height: 80px; margin:0 2px">';
              }
              ?>
            </div>
          </div>
          <div class="col-md-4">

            <?php
            $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE IDProduit = ?");
            $reqproduit->execute(array($_GET['id']));
            $produit = $reqproduit->fetch();
             ?>

            <div>
              <h1 class="text-capitalize text-center"><?php echo $produit['LibelleProduit']; ?></h1>
            </div>
            <div>
              <?php
              $QuantiteProduit = $produit['QuantiteProduit'];
              if ($QuantiteProduit > 0) { ?>
                <h5 class="text-left text-success"><i class="fa fa-check"></i>&nbsp;Produit disponible en stock</h5>
              <?php
            } else { ?>
              <h5 class="text-left text-danger"><i class="fa fa-close"></i>&nbsp;Produit indisponible</h5>
            <?php } ?>
            </div>
            <div>
              <h4 class="text-right" style="margin-top:18px;max-width:68px;height:33px;">Avis :&nbsp;</h4>
            </div>
            <div class="float-right d-flex" style="background-color:#9d1616;font-size:22px;width:170px;margin-top:-35px;margin-right:32px;">
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
              <i class="fa fa-star"></i>
            </div>
            <div>
              <h5 class="text-center" style="margin-top:16px;margin-left:10px;padding-top:0px;padding-left:-1px;font-size:25px;width:120px;">Quantité :&nbsp;</h5>
              <div>
                <select class="float-right" style="height:26px;margin-top:-34px;margin-right:24px;">
                  <optgroup label="Quantité">
                    <?php
                    for ($x = 1; $x <= $QuantiteProduit; $x++)  { ?>
                      <option value="<?php echo $x ?>"><?php echo $x ?></option>
                    <?php }
                    ?>
                  </optgroup>
                </select>
              </div>
              <div>
                <h5 class="text-center" style="margin-top:22px;margin-left:10px;padding-top:0px;padding-left:-1px;font-size:25px;width:120px;">Taille :&nbsp;</h5>
                <div>
                  <select class="float-right" style="height:26px;margin-top:-33px;margin-right:25px;">
                    <optgroup label="Taille">
                      <option value="1" selected="">XS</option>
                      <option value="2">S</option>
                      <option value="3">M</option>
                      <option value="4">L</option>
                      <option value="5">XL</option>
                      <option value="6">XXL</option>
                    </optgroup>
                  </select>
                </div>
              </div>
            </div>
            <div>
              <h1 class="text-center text-warning" style="padding-top:26px;max-width:292px;margin-top:-10px;margin-left:0px;padding-right:0px;padding-left:0px;font-size:47px;"><?php echo $produit['PrixUnitaireHT']; ?> €</h1>
            </div>
              <div><button class="btn btn-primary" type="button" disabled="disabled" data-bs-hover-animate="tada" style="width:295px;height:80px;margin-top:18px;font-size:31px;">Ajouter au panier&nbsp;</button></div>
            </div>
          </div>
          <div style="margin-top:19px;">
            <div>
              <h1>Description&nbsp;</h1>
            </div>
          <div>
            <p><i class="icon ion-android-send"></i>Paragraphe</p>
            <p><i class="icon ion-android-send"></i>Paragraphe</p>
            <p><i class="icon ion-android-send"></i>Paragraphe</p>
          </div>
        </div>
      </div>
    </div>

    <!-- les commentaires -->
    <div class="container">
      <?php
  //teste si l'utilisateur est connecté
      if (isset($_SESSION['id'])) {
        if (isset($_POST['commentSubmit'])){
          $idclient = intval(htmlspecialchars($_POST['IDClient']));
          $titreavis = htmlspecialchars($_POST['titreAvis']);
          $avis = intval(htmlspecialchars($_POST['avis']));
          $message = htmlspecialchars($_POST['message']);
          $sql = "INSERT INTO avis (IDClient, Titre, Description, Note, IDProduit) VALUES (?, ?, ?, ?, ?)";
          $reqinser = $bdd->prepare($sql);
          $reqinser->execute(array($idclient, $titreavis, $message, $avis, $produit['IDProduit']));
        }

      ?>
        <form class="form form-group" method='POST'>
          <!-- pour gérée l'avis avec les étoiles -->
          <div id="starsselecteur" class="stars0">
            <img src="/assets/img/empty_star.png" style="margin-left:0px;" alt="1 étoiles" height="28" width="28" data-star="1">
            <img src="/assets/img/empty_star.png" alt="2 étoiles" height="28" width="28" data-star="2">
            <img src="/assets/img/empty_star.png" alt="3 étoiles" height="28" width="28" data-star="3">
            <img src="/assets/img/empty_star.png" alt="4 étoiles" height="28" width="28" data-star="4">
            <img src="/assets/img/empty_star.png" alt="5 étoiles" height="28" width="28" data-star="5">
            <input type="hidden" name="avis" value="0">
          </div>
          <input type='hidden' name='IDClient' value="<?php echo $_SESSION['id'];?>">
          <input type='text' name='titreAvis' placeholder="Titre ou résumé pour votre commentaire (requis)">
          <textarea class="textarea-avis" name='message' placeholder="Entrez ici votre commentaire"></textarea><br>
          <button class="button-avis" type='submit' name='commentSubmit'>Comment</button>
        </form>
        <?php } else {
          echo "Vous devez être connecté pour écrire un commentaire";
        } ?>



    </div>

    <div>
      <div class="container">
        <div class="row">
          <?php
          $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE IdCategorie = ? LIMIT 4"); //récupère tous les produits qui ont le même idcatégorie que le produit de la page
          $reqproduit->execute(array($produit['IdCategorie']));
          $lesproduits = $reqproduit->fetchAll();
          foreach ($lesproduits as $unproduit) {
            //Récupère l'image par raport à l'id du produit
            $reqphotoproduit = $bdd->prepare("SELECT * FROM photoproduit WHERE IDProduit = ?");
            $reqphotoproduit->execute(array($unproduit["IDProduit"]));
            $produitexist = $reqphotoproduit->rowCount();
            //Teste s'il y a une photo pour le produit ou pas
            if ($produitexist == 0) {
              $imgproduit = '/assets/img/defaultproduitimg.png';
            }else {
              $imgproduitrep = $reqphotoproduit->fetch();
              $imgproduit = '/assets/img/imagesupload/'.$imgproduitrep["Photo"];
            }
          ?>
            <div class="col-md-3">
            <div>
            <h3 class="text-center" style="text-overflow: ellipsis;overflow: hidden;white-space: nowrap;"><?php echo $unproduit['LibelleProduit'] ?></h3>
            <img class="rounded" src="<?php echo $imgproduit ?>" style="width:139px;margin-left:54px;">
            <div><button class="btn btn-primary btn-lg" type="button" style="width:255px;height:50px;margin-top:1px;">Voir le produit</button></div>
            </div>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    </div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/image.js"></script>
    <script src="/assets/js/avis.js"></script>
    <!-- <script src="/assets/js/script.min.js"></script> -->
</body>
</html>
