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
    //Vérification du droit d'accès
    if (isset($_SESSION['id']) && $_SESSION['pseudo'] == 'Admin') {

      //Si on clique sur le bouton "valider"
      if (isset($_POST['formajouterproduit'])) {

        //Variables
        $nomproduit = htmlspecialchars($_POST['nomproduit']);
        $prix = floatval(htmlspecialchars($_POST['prix']));
        $reference = htmlspecialchars($_POST['reference']);
        $quantite = intval(htmlspecialchars($_POST['quantite']));
        $categorie = intval(htmlspecialchars($_POST['categorie']));
        $description = htmlspecialchars($_POST['description']);


        //Teste si les champs ne sont pas vides
        if (!empty($_POST['nomproduit']) && !empty($_POST['prix']) && !empty($_POST['reference']) && !empty($_POST['quantite']) && !empty($_POST['categorie']) && !empty($_POST['description'])) {

          //Teste si les types sont correctes
          if (is_numeric($_POST['prix']) && is_numeric($_POST['quantite']) && is_numeric($_POST['categorie'])) {

            //Vérifie si la référence n'existe pas
            $reqref = $bdd->prepare("SELECT Reference FROM produits WHERE Reference = ?");
            $reqref->execute(array($reference));
            $refexist = $reqref->rowCount();
            if($refexist == 0) {
              //Ajoute le produit
              $insertproduit = $bdd->prepare("INSERT INTO produits(LibelleProduit, PrixUnitaireHT, Reference, QuantiteProduit, IdCategorie, DescriptionProduit) VALUES(?, ?, ?, ?, ?, ?)");
              $insertproduit->execute(array($nomproduit, $prix, $reference, $quantite, $categorie, $description));

              //Teste s'il y a une image envoyée
              if (!empty($_POST['ingsJSON'])) {
                $reqProduitId = $bdd->prepare("SELECT IDProduit FROM produits WHERE Reference = ?");
                $reqProduitId->execute(array($reference));
                // TODO: Insère dans photoproduit la photo avec idproduit
                echo '<script> console.log("image teeeeest"); document.location.replace("modifierCatalogue.php")</script>';

              }else {
                echo '<script> console.log("Pas d\'image ajouter. Image par default utiliser"); document.location.replace("modifierCatalogue.php")</script>';
              }
            }else {
              $erreur = "La reference \"".$reference."\" est déjà utilisé !";
            }
          }else {
            $erreur = "Le champ Prix Unitaire HT et/ou Quantité ne doit contenir que des chiffres !";
          }
        }else {
          $erreur = "Tous les champs doivent être complétés !";
        }
      }
      ?>

      <!-- Pour ajouter un produit -->
      <div class="container">
        <h1>Ajouter un produit</h1>
        <form action="" method="post">
          <div class="row bg-light rounded">
            <div class="col">
              <div class="row">
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Nom du Produit :</label>
                    <input type="text" class="form-control" name="nomproduit" id="">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Prix Unitaire HT :</label>
                    <input type="text" class="form-control" name="prix" id="">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Référence :</label>
                    <input type="text" class="form-control" name="reference" id="">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Quantité :</label>
                    <input type="text" class="form-control" name="quantite" id="">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Catégorie :</label>
                    <select class="form-control" name="categorie" id="">
                      <?php
                      //charge les categorie
                      $reqcategorie = $bdd->prepare("SELECT * FROM categorie");
                      $reqcategorie->execute();
                      $categorieinfo = $reqcategorie->fetchAll();
                      foreach ($categorieinfo as $row) {
                        echo '<option value="'.$row["IdCategorie"].'">'.$row["LibelleCategorie"].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group m-2">
                <label class="mr-1">Description :</label>
                <textarea class="form-control" rows="5" name="description" id="" style="min-height:100px;"></textarea>
              </div>
            </div>

            <!-- gestion des image -->
            <div class="col-xl-6">
              <div class="m-2" style="overflow:auto">
                <img class="rounded mx-auto d-block" src="assets/img/4424460.jpg" data-bs-hover-animate="pulse" style="width:422px; max-width:none; height:385px;">
              </div>
              <div class="m-2">
                <img src="" style="width:80px;height:80px;">
                <img src="" style="width:80px;height:80px;">
                <img src="" style="width:80px;height:80px;">
                <img src="" style="width:80px;height:80px;">
                <img src="" style="width:80px;height:80px;">
                <div class="addx" id="">
                  <div class="line-x"></div>
                  <div class="line-y"></div>
                </div>
              </div>
            </div>
            <!-- Contient la liste des images en JSON -->
            <input type="text" name="ingsJSON" id="ingsJSON" value="" style="display:none;">
          </div>
          <div class="container mt-3 text-center">
            <button type="button" class="btn btn-danger float-left btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Annuler</button>
            <?php
            if(isset($erreur)) {
              echo '<font color="red">'.$erreur."</font>";
            }
            ?>
            <button type="submit" name="formajouterproduit" class="btn btn-success float-right btn-lg">Valider</button>
          </div>
        </form>
      </div>
      <?php
      }else {
      ?>
      <div class="container mt-3 text-center">
        <font color="red">Vous n'avez pas les droits pour accéder à cette page</font>
      </div>
      <?php
      }
      ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <script src="'assets/js/ajouterproduit.js'"></script>
  </body>
</html>
