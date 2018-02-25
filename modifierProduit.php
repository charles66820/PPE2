<!-- 3ligne peut être temporaire -->
<?php include './assets/php/setting.bdd.php'; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<script src="./assets/js/jquery-3.3.1.min.js"></script>
<script src="./assets/js/bootstrap.bundle.min.js"></script>

<?php
//charger les information actuelle du produit

//sql SELECT * FROM produit where id=$_GET['id']
//le resultat remplie des variable
$nomproduit = "toto";
$prix = 99;
$reference = "AXTEQ7F";
$quantite = 297;
$categorie;//je sais pas comment change la selection du select
$description = "or zjfi dj sdffsdojf dsd fsdf fd jsdf jj j fdsjf djjkfds";


echo $_GET['id'];

//modifier
if (isset($_POST['formmodifierproduit'])) {
  echo htmlspecialchars($_POST['nomproduit'])." : ".htmlspecialchars($_POST['prix'])." : ".htmlspecialchars($_POST['reference'])." : ".htmlspecialchars($_POST['quantite'])." : ".htmlspecialchars($_POST['categorie'])." : ".htmlspecialchars($_POST['description']);
}
?>

<!-- pour ajouter un produit -->
<style media="screen">
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
                  var_dump($row);
                  echo '<option value="'.$row["IdCategorie"].'">'.$row["LibelleCategorie"].'</option>';
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
          <img src="" style="width:80px;">
          <img src="" style="width:80px;">
          <img src="" style="width:80px;">
          <img src="" style="width:80px;">
          <img src="" style="width:80px;">
          <div class="addx" id="">
            <div class="line-x"></div>
            <div class="line-y"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="container mt-3">
      <button type="button" class="btn btn-danger float-left btn-lg" onclick="document.location.replace('modifierCatalogue.php')">Annuler</button>
      <button type="submit" name="formmodifierproduit" class="btn btn-success float-right btn-lg">Valider</button>
    </div>
  </form>
</div>
