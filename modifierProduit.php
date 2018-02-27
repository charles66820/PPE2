<!DOCTYPE html>
<?php include './assets/php/setting.bdd.php'; ?>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Modifier un produit</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="./assets/img/logoIcon.gif"/>
      <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
      <style>
        .addx{
          vertical-align: middle;
          position: relative;
          width: 80px;
          height: 80px;
          display: inline-block;
          box-shadow: 0 0 2px 0px rgba(0,0,0,0.2);
        }
        .line-x{
          top: calc(50% - 12px);
          left: calc(50% - 40px);
          width: 80px;
          height: 24px;
          background-color: #eee;
          position: absolute;
          border-radius: 8px;
        }
        .line-y{
          top: calc(50% - 40px);
          left: calc(50% - 12px);
          width: 24px;
          height: 80px;
          background-color: #eee;
          position: absolute;
          border-radius: 8px;
        }
      </style>
  </head>
  <body>
    <?php
    //vaérification du drois d'accsé
    if (isset($_SESSION['id']) && $_SESSION['pseudo'] == 'Admin') {

      //teste si la propriéter id est présente
      if (isset($_GET['id'])) {

        //test si il y a un id set
        if (!empty($_GET['id'])) {

          //si le boutton Valider est clicker
          if (isset($_POST['formmodifierproduit'])) {

            //variable
            $idproduit = $_POST['idproduit'];
            $nomproduit = htmlspecialchars($_POST['nomproduit']);
            $prix = intval(htmlspecialchars($_POST['prix']));
            $reference = htmlspecialchars($_POST['reference']);
            $quantite = intval(htmlspecialchars($_POST['quantite']));
            $categorie = intval(htmlspecialchars($_POST['categorie']));
            $description = htmlspecialchars($_POST['description']);


            //test si les champs ne son pas vide
            if (!empty($_POST['nomproduit']) && !empty($_POST['prix']) && !empty($_POST['reference']) && !empty($_POST['quantite']) && !empty($_POST['categorie']) && !empty($_POST['description'])) {

              //test si les type son correcte
              if (is_numeric($_POST['prix']) && is_numeric($_POST['quantite']) && is_numeric($_POST['categorie'])) {

                //vairiffie si la référence n'existe pas
                $reqref = $bdd->prepare("SELECT * FROM produits WHERE Reference = ? AND IDProduit != ?");
                $reqref->execute(array($reference, $idproduit));
                $refexist = $reqref->rowCount();
                if($refexist == 0) {
                  //update le produit
                  $insertproduit = $bdd->prepare("UPDATE produits SET LibelleProduit = ?, PrixUnitaireHT = ?, Reference = ?, QuantiteProduit = ?, IdCategorie = ?, DescriptionProduit = ? WHERE IDProduit = ?");
                  $insertproduit->execute(array($nomproduit, $prix, $reference, $quantite, $categorie, $description, $idproduit));

                  //teste si il y a une image envoyer
                  if (!empty($_POST['ingsJSON'])) {

                    // TODO: insére dans photoproduit le photo avec $idproduit

                    echo '<script> console.log("image teeeeest"); document.location.replace("modifierCatalogue.php")</script>';

                  }else {
                    echo '<script> console.log("Pas d\'image ajouter. Image par default utiliser"); document.location.replace("modifierCatalogue.php")</script>';
                  }
                }else {
                  $erreur = "La reference \"".$reference."\" est déjà utilisé !";
                }
              }else {
                $erreur = "Le champ Prix Unitair HT et/ou Quantité ne dois comptenir que des chiffre !";
              }
            }else {
              $erreur = "Tous les champs doivent être complétés !";
            }
          }

          //charge les information actuelle du produit

          //sql SELECT * FROM produit where
          $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE IDProduit = ?");
          $reqproduit->execute(array($_GET['id']));
          $dbrep = $reqproduit->fetch();

          //le resultat remplie des variable
          $nomproduit = $dbrep["LibelleProduit"];
          $prix = $dbrep["PrixUnitaireHT"];
          $reference = $dbrep["Reference"];
          $quantite = $dbrep["QuantiteProduit"];
          $categorie = $dbrep["IdCategorie"];
          $description = $dbrep["DescriptionProduit"];
      ?>

      <!-- pour modifier un produit -->
      <div class="container">
        <h1>Modifier un produit</h1>
        <form action="" method="post">
          <div class="row bg-light rounded">
            <div class="col">
              <div class="row">
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Nom du Produit :</label>
                    <input type="text" class="form-control" name="nomproduit" id="" value="<?php echo $nomproduit ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Prix Unitair HT :</label>
                    <input type="text" class="form-control" name="prix" id="" value="<?php echo $prix ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Reference :</label>
                    <input type="text" class="form-control" name="reference" id="" value="<?php echo $reference ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Quantité :</label>
                    <input type="text" class="form-control" name="quantite" id="" value="<?php echo $quantite ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">categorie :</label>
                    <select class="form-control" name="categorie" id="">
                      <?php
                      //charge les categorie
                      $reqcategorie = $bdd->prepare("SELECT * FROM categorie");
                      $reqcategorie->execute();
                      $categorieinfo = $reqcategorie->fetchAll();
                      foreach ($categorieinfo as $row) {
                        if ($row["IdCategorie"] == $categorie) {
                          echo '<option value="'.$row["IdCategorie"].'" selected="selected">'.$row["LibelleCategorie"].'</option>';
                        }else {
                          echo '<option value="'.$row["IdCategorie"].'">'.$row["LibelleCategorie"].'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group m-2">
                <label class="mr-1">description :</label>
                <textarea class="form-control" rows="5" name="description" id="" style="min-height:100px;"><?php echo $description ?></textarea>
              </div>
            </div>

            <!-- gestion des image -->
            <div class="col-xl-6">
              <div class="m-2" style="overflow:auto">
                <img class="rounded mx-auto d-block" src="assets/img/4424460.jpg" data-bs-hover-animate="pulse" style="width:422px; max-width:none; height:385px;">
              </div>
              <div class="m-2">
                <img src="" style="width:80px;height: 80px;">
                <img src="" style="width:80px;height: 80px;">
                <img src="" style="width:80px;height: 80px;">
                <img src="" style="width:80px;height: 80px;">
                <img src="" style="width:80px;height: 80px;">
                <div class="addx" id="">
                  <div class="line-x"></div>
                  <div class="line-y"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="container mt-3 text-center">
            <button type="button" class="btn btn-danger float-left btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Annuler</button>
            <?php
            if(isset($erreur)) {
              echo '<font color="red">'.$erreur."</font>";
            }
            ?>
            <input type="text" name="idproduit" value="<?php if(isset($_GET['id'])) { echo $_GET['id'];} ?>" style="display:none">
            <button type="submit" name="formmodifierproduit" class="btn btn-success float-right btn-lg">Valider</button>
          </div>
        </form>
      </div>
      <?php
        }else {
      ?>
      <div class="container mt-3 text-center">
        <font color="red">Erreur : aucun produit selectionner</font>
        <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Retour</button>
      </div>
      <?php
        }
      }else {
      ?>
      <div class="container mt-3 text-center">
        <font color="red">Erreur : propriéter id introuvable</font>
        <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Retour</button>
      </div>
      <?php
      };
    }else {
    ?>
    <div class="container mt-3 text-center">
      <font color="red">vous n'avais pas le drois d'accséder a cette pages</font>
    </div>
    <?php
    }
    ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
