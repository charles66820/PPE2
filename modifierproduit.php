<!DOCTYPE html>
<?php include 'assets/php/setting.bdd.php'; ?>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Modifier un produit</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="/assets/img/logoIcon.gif"/>
      <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
      <link href="/assets/css/images.css" rel="stylesheet">
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
                  if (!empty($_POST['imgsJSON'])) {

                    //récuper l'id des photoproduit par raport au produit id
                    $selectIdImageExiste = $bdd->prepare("SELECT IDPhotoProduit FROM photoproduit WHERE IDProduit = ?");
                    $selectIdImageExiste->execute(array($idproduit));
                    $idImageExiste = $selectIdImageExiste->fetchAll();

                    $listeDesImages = json_decode($_POST['imgsJSON'], true);
                    foreach ($listeDesImages as $image) {//pour chaque image
                      if ($image["id"] == null) {//test si l'image est nouvelle
                        //on ajoute l'image
                        $insertPhotoProduit = $bdd->prepare("INSERT INTO photoproduit(IDProduit, Photo) VALUES(?, ?)");
                        $insertPhotoProduit->execute(array($idproduit, $image["imagename"]));
                      }else{
                        for ($i=0; $i < sizeof($idImageExiste); $i++) {//test si l'image existe et si il faut la metre a jour
                          if ($image["id"] == $idImageExiste[$i]["IDPhotoProduit"]) {
                            array_splice($idImageExiste, $i, 1);//enléve l'id de l'image existente de la liste
                            $UpdatePhotoProduit = $bdd->prepare("UPDATE photoproduit SET Photo = ? WHERE IDPhotoProduit = ?");
                            $UpdatePhotoProduit->execute(array($image["imagename"], $image["id"]));
                          }
                        }
                      }
                    }
                    //supprime la liste des images restante
                    foreach ($idImageExiste as $id) {
                      $deletePhotoProduit = $bdd->prepare("DELETE FROM photoproduit WHERE IDPhotoProduit = ?");
                      $deletePhotoProduit->execute(array($id["IDPhotoProduit"]));
                    }
                    echo '<script> console.log("image teeeeest"); document.location.replace("modifiercatalogue.php")</script>';

                  }else {
                    //supprime toute les image existente
                    $deletePhotoProduit = $bdd->prepare("DELETE FROM photoproduit WHERE IDProduit = ?");
                    $deletePhotoProduit->execute(array($idproduit));
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
          if (isset($dbrep["idtaille"])) {
            $taille = $dbrep["idtaille"];
          }
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
                    <input type="text" class="form-control" name="nomproduit" id="nomproduit" value="<?php echo $nomproduit ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Prix Unitaire HT :</label>
                    <input type="text" class="form-control" name="prix" id="prixproduit" value="<?php echo $prix ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Référence :</label>
                    <input type="text" class="form-control" name="reference" id="referenceproduit" value="<?php echo $reference ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Quantité :</label>
                    <input type="text" class="form-control" name="quantite" id="quantiteproduit" value="<?php echo $quantite ?>">
                  </div>
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">Catégorie :</label>
                    <select class="form-control" name="categorie" id="categorieproduit">
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
                </div>
                <div class="col-sm-5">
                  <div class="form-inline m-2">
                    <label class="mr-1">taille :</label>
                    <select class="form-control" name="" id="taille">
                      <?php
                      //charge les categorie
                      $reqcategorie = $bdd->prepare("SELECT * FROM taille");
                      $reqcategorie->execute();
                      $categorieinfo = $reqcategorie->fetchAll();
                      foreach ($categorieinfo as $row) {
                        if ($row["IdCategorie"] == $taille) {
                          echo '<option value="'.$row["idtaille"].'" selected="selected">'.$row["libelleTaille"].'</option>';
                        }else {
                          echo '<option value="'.$row["idtaille"].'">'.$row["libelleTaille"].'</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group m-2">
                <label class="mr-1">Description :</label>
                <textarea class="form-control" rows="5" name="description" id="descriptionproduit" style="min-height:100px;"><?php echo $description ?></textarea>
              </div>
            </div>

            <!-- gestion des image -->
            <div class="col-xl-6">
              <div class="m-2" style="overflow:auto; position:relative">
                <img class="rounded mx-auto d-block" id="imgproduit" src="" data-bs-hover-animate="pulse" style="width:422px; max-width:none; height:385px;">
                <button type="button" class="btn btn-danger" id="btmremoveimgproduit">X</button>
                <button type="button" class="btn btn-warning m-1" id="btmmodifiimgproduit">changer l'image</button>
                <div id="addimgproduit" style="position:absolute; background-color:white; top:0; left:0; width:100%; height:100%; min-width:422px; display:none; border: 2px solid rgba(0, 0, 0, 0);">
                  <div class="container text-center" style="position:absolute; top: 0; bottom: 0; margin: auto; height: 50%;">
                    <h2 id="tiredropimg" class="text-primary">Envoyer une image</h2>
                    <p class="text-primary">Glissé déposer votre image ou cliqué ici.</p>
                    <div id="progressbarimg" class="progress" style="display:none">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" style="width:0%">0%</div>
                    </div>
                    <button type="button" class="btn btn-danger m-2" style="display:none" id="btmcancelmodifiimgproduit">annuler</button>
                  </div>
                </div>
                  <input type="file" style="display:none;">
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
                <div class="addx" id="btmaddimgproduit">
                  <div class="line-x"></div>
                  <div class="line-y"></div>
                </div>
              </div>
            </div>
            <!-- Contient la liste des images en JSON -->
            <input type="hidden" name="imgsJSON" id="imgsJSON" value="">
          </div>
          <div class="container mt-3 text-center">
            <button type="button" class="btn btn-danger float-left btn-lg" id="btncancel">Annuler</button>
            <?php
            if(isset($erreur)) {
              echo '<font color="red">'.$erreur."</font>";
            }
            ?>
            <input type="text" name="idproduit" value="<?php if(isset($_GET['id'])) { echo $_GET['id'];} ?>" style="display:none">
            <button type="button" class="btn btn-success float-right btn-lg" data-toggle="modal" data-target="#produitconfirme">Valider</button>
          </div>
          <!-- modale de confirmation -->
          <div class="modal fade" id="produitconfirme">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Modifier le produit</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modalbody"></div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Annuler</button>
                  <button type="submit" name="formmodifierproduit" class="btn btn-success btn-lg float-right" id="btndone">Valider</button>
                </div>
              </div>
            </div>
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
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/functionimage.js"></script>
    <script src="/assets/js/adminimage.js"></script>
    <script src="/assets/js/modaladdandeditproduit.js"></script>
  </body>
</html>
