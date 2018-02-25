<!-- 3ligne peut être temporaire -->
<?php include 'setting.bdd.php'; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./assets/css/bootstrap.min.css">


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
  <h1>Ajouter un produit</h1>
  <form class="" action="" method="post">
    <div class="row bg-light rounded">
      <div class="col">
        <div class="row">
          <div class="col-sm-5">
            <div class="form-inline m-2">
              <label class="mr-1">Nom du Produit :</label>
              <input type="text" class="form-control" id="">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-inline m-2">
              <label class="mr-1">Prix Unitair HT :</label>
              <input type="text" class="form-control" id="">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-inline m-2">
              <label class="mr-1">Reference :</label>
              <input type="text" class="form-control" id="">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-inline m-2">
              <label class="mr-1">Quantité :</label>
              <input type="text" class="form-control" id="">
            </div>
          </div>
          <div class="col-sm-5">
            <div class="form-inline m-2">
              <label class="mr-1">categorie :</label>
              <select class="form-control" name="categorie" id="">
                <?php
                //charge les categorie
                $requser = $bdd->prepare("SELECT * FROM categorie");
                $requser->execute(array($pseudoconnect, $mdpconnect));
                $categorieinfo = $requser->fetch();
                foreach ($categorieinfo as $row) {
                  echo '<option value="'.$row['IdCategorie'].'">'.$row['LibelleCategorie'].'</option>';
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group m-2">
          <label for="comment" class="mr-1">Comment:</label>
          <textarea class="form-control" rows="5" id="comment" style="min-height:100px;"></textarea>
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
      <button type="submit" class="btn btn-success float-right btn-lg">Valider</button>
    </div>
  </form>
</div>

<script src="./assets/js/jquery-3.3.1.min.js"></script>
<script src="./assets/js/bootstrap.bundle.min.js"></script>
