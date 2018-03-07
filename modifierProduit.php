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
    //vérification du droit d'accès
    if (isset($_SESSION['id']) && $_SESSION['pseudo'] == 'Admin') {

      //teste si la propriétée id est présente
      if (isset($_GET['id'])) {

        //teste s'il y a un id set
        if (!empty($_GET['id'])) {

          //si le bouton "Valider" est clické
          if (isset($_POST['formmodifierproduit'])) {

            //variables
            $idproduit = $_POST['idproduit'];
            $nomproduit = htmlspecialchars($_POST['nomproduit']);
            $prix = floatval(htmlspecialchars($_POST['prix']));
            $reference = htmlspecialchars($_POST['reference']);
            $quantite = intval(htmlspecialchars($_POST['quantite']));
            $categorie = intval(htmlspecialchars($_POST['categorie']));
            $description = htmlspecialchars($_POST['description']);
            $taille = intval(htmlspecialchars($_POST['taille']));


            //teste si les champs ne sont pas vides
            if (!empty($_POST['nomproduit']) && !empty($_POST['prix']) && !empty($_POST['reference']) && !empty($_POST['quantite']) && !empty($_POST['categorie']) && !empty($_POST['description'])) {

              //teste si les types son correctes
              if (is_numeric($_POST['prix']) && is_numeric($_POST['quantite']) && is_numeric($_POST['categorie'])) {

                //vérifie si la référence n'existe pas
                $reqref = $bdd->prepare("SELECT * FROM produits WHERE Reference = ? AND IDProduit != ?");
                $reqref->execute(array($reference, $idproduit));
                $refexist = $reqref->rowCount();
                if($refexist == 0) {

                  if (empty($_POST['taille'])) {
                    //update le produit
                    $updateproduit = $bdd->prepare("UPDATE produits SET LibelleProduit = ?, PrixUnitaireHT = ?, Reference = ?, QuantiteProduit = ?, IdCategorie = ?, DescriptionProduit = ? WHERE IDProduit = ?");
                    $updateproduit->execute(array($nomproduit, $prix, $reference, $quantite, $categorie, $description, $idproduit));
                  }else {
                    $updateproduit = $bdd->prepare("UPDATE produits SET LibelleProduit = ?, PrixUnitaireHT = ?, Reference = ?, QuantiteProduit = ?, IdCategorie = ?, DescriptionProduit = ?, idtaille = ? WHERE IDProduit = ?");
                    $updateproduit->execute(array($nomproduit, $prix, $reference, $quantite, $categorie, $description, $idproduit, $taille));
                  }

                  //teste s'il y a une image envoyée
                  if (!empty($_POST['ingsJSON'])) {

                    // TODO: insère dans photoproduit la photo avec $idproduit

                    echo '<script> console.log("image teeeeest"); document.location.replace("modifierCatalogue.php")</script>';

                  }else {
                    echo '<script> console.log("Pas d\'image ajouter. Image par default utiliser"); document.location.replace("modifiercatalogue.php")</script>';
                  }
                }else {
                  $erreur = "La référence \"".$reference."\" est déjà utilisée !";
                }
              }else {
                $erreur = "Le champ Prix Unitair HT et/ou Quantité ne doit contenir que des chiffres !";
              }
            }else {
              $erreur = "Tous les champs doivent être complétés !";
            }
          }

          //charge les informations actuelles du produit

          //sql SELECT * FROM produit where
          $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE IDProduit = ?");
          $reqproduit->execute(array($_GET['id']));
          $dbrep = $reqproduit->fetch();

          //le resultat remplis des variables
          $nomproduit = $dbrep["LibelleProduit"];
          $prix = $dbrep["PrixUnitaireHT"];
          $reference = $dbrep["Reference"];
          $quantite = $dbrep["QuantiteProduit"];
          $categorie = $dbrep["IdCategorie"];
          $description = $dbrep["DescriptionProduit"];
          $taille = $dbrep["idtaille"];
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
                    <label class="mr-1">Prix Unitaire HT :</label>
                    <input type="text" class="form-control" name="prix" id="" value="<?php echo $prix ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Référence :</label>
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
                    <label class="mr-1">Catégorie :</label>
                    <select class="form-control" name="categorie" id="">
                      <?php
                      //charge les categories
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
                  <div class="form-inline m-2">
                    <label class="mr-1">taille :</label>
                    <select class="form-control" name="taille" id="taille">
                      <?php
                      //charge les categorie
                      $reqcategorie = $bdd->prepare("SELECT * FROM taille");
                      $reqcategorie->execute();
                      $categorieinfo = $reqcategorie->fetchAll();
                      foreach ($categorieinfo as $row) {
                        echo '<option value="'.$row["idtaille"].'">'.$row["libelleTaille"].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group m-2">
                <label class="mr-1">Description :</label>
                <textarea class="form-control" rows="5" name="description" id="" style="min-height:100px;"><?php echo $description ?></textarea>
              </div>
            </div>

            <!-- gestion des images -->
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
        <font color="red">Erreur : aucun produit selectionné</font>
        <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Retour</button>
      </div>
      <?php
        }
      }else {
      ?>
      <div class="container mt-3 text-center">
        <font color="red">Erreur : propriétée id introuvable</font>
        <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('modifiercatalogue.php')">Retour</button>
      </div>
      <?php
      };
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
  </body>
</html>
