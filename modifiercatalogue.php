<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title></title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <?php include 'assets/php/allcss.php'; ?>
      <link rel="stylesheet" href="/assets/css/catalogue.css">
  </head>
  <body>
    <?php
    include 'assets/php/nav.php';
    if (isset($_SESSION['id']) && $_SESSION['pseudo'] == 'Admin') {
      if (isset($_POST['delproduit'])) {
        $reqdel = $bdd->prepare("DELETE FROM photoproduit WHERE IDProduit = ?");
        $reqdel->execute(array($_POST['id']));
        $reqdel = $bdd->prepare("DELETE FROM produits WHERE IDProduit = ?");
        $reqdel->execute(array($_POST['id']));
      }
    ?>

    <div class="container">
      <div class="text-right">
        <button type="button" class="btn btn-success btn-lg mb-3" onclick="document.location.replace('ajouterproduit.php')">Ajouter un produit</button>
      </div>
    </div>
    <div class="container">
      <?php
        //création de requête sql
        // TODO: faire la requête sql en fonction du choix dans le menu (navbar)
        $reqproduit = $bdd->prepare("SELECT * FROM produits");
        $reqproduit->execute();
        $dbrep = $reqproduit->fetchAll();

        //chargement des produits du catalogue
        foreach ($dbrep as $row) {
          //recuperer l'image par rapport à l'id du produit
          $reqphotoproduit = $bdd->prepare("SELECT * FROM photoproduit WHERE IDProduit = ?");
          $reqphotoproduit->execute(array($row["IDProduit"]));
          $produitexist = $reqphotoproduit->rowCount();

          //teste s'il y a une photo pour le produit ou pas
          if ($produitexist == 0) {
            $imgproduit = '/assets/img/defaultproduitimg.png';
          }else {
            $imgproduitrep = $reqphotoproduit->fetch();
            $imgproduit = '/assets/img/imagesupload/'.$imgproduitrep["Photo"];
          }

          //afficher le produit
          echo '
          <div class="articleElm articleBox" style="height: 338px;">
            <div class="articleNom">'.$row["LibelleProduit"].'</div>
            <div class="imgBox">
              <img src="'.$imgproduit.'" alt="">
            </div>
            <div class="text-center m-1">
              <button type="button" class="btn btn-warning" onclick="document.location.href = \'modifierproduit.php?id='.$row["IDProduit"].'\'">Modifier</button>
            </div>
            <div class="text-center" style="width: 182px; float: left;">
              <form class="" action="" method="post">
                <input type="text" name="id" value="'.$row["IDProduit"].'" style="display:none">
                <button type="submit" class="btn btn-danger" name="delproduit">Supprimer</button>
              </form>
            </div>
            <div class="articlePrix">'.$row["PrixUnitaireHT"].'€</div>
          </div>';
        }
      }else {
      ?>
      <div class="container mt-3 text-center">
        <font color="red">Vous n'avez pas les droits pour accéder à cette page!</font>
      </div>
      <?php
      }
      ?>
    </div>
    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
