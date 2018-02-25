<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="./assets/img/logoIcon.gif"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="./assets/css/catalogue.css">
  </head>
  <body>
    <?php include './assets/php/nav.php'; ?>

    <div class="container">
      <div class="text-right">
        <button type="button" class="btn btn-success btn-lg mb-3" onclick="document.location.replace('ajouterproduit.php')">Ajouter un produit</button>
      </div>
    </div>
    <div class="container articleBox">
      <?php
      //création de requet sql
      // TODO: faire de requet sql en fonction de chix dans le menu (navbar)

      //resultat de la base de donnéer
      //en atendent c'est un tableau a deux dimention
      $dbrep = array(array('id'=>'2', 'nom'=>"Poulpe", 'prix'=>"10.0€", 'imgNom'=>"test1.jpg",'star'=>"stars2", 'description'=>'testtttt'),
      array('id'=>'5', 'nom'=>"Poulpe2", 'prix'=>"20.0€", 'imgNom'=>"test2.jpeg",'star'=>"stars4_5", 'description'=>'testtttt'),
      array('id'=>'6', 'nom'=>"Poulpe3", 'prix'=>"20.0€", 'imgNom'=>"test3.jpg",'star'=>"stars3", 'description'=>'testtttt'),
      array('id'=>'13', 'nom'=>"Poulpe4", 'prix'=>"20.0€", 'imgNom'=>"test4.jpg",'star'=>"stars0_5", 'description'=>'testtttt'),
      array('id'=>'69', 'nom'=>"Poulpe99", 'prix'=>"20.0€", 'imgNom'=>"test4.jpg",'star'=>"stars0_5", 'description'=>'testtttt'),
      array('id'=>'28', 'nom'=>"Poulpe5", 'prix'=>"20.0€", 'imgNom'=>"test5.jpg",'star'=>"stars3_5", 'description'=>'testjyfuydtttt'));

      //chargement des produit du catalogue
      foreach ($dbrep as $row) {
        echo '
        <div class="articleElm" style="height: 323px;">
          <div class="articleNom">'.$row["nom"].'</div>
          <div class="imgBox">
            <img src="./assets/img/imagesUpload/'.$row["imgNom"].'" alt="">
          </div>
          <div class="text-center m-1">
            <button type="button" class="btn btn-warning" onclick="document.location.replace(\'modifierproduit.php?id='.$row["id"].'\')">Modifier</button>
          </div>
          <div class="text-center" style="width: 182px; float: left;">
            <button type="button" class="btn btn-danger" onclick="document.location.replace(\'modifierCatalogue.php?id='.$row["id"].'\')">Supprimer</button>
          </div>
          <div class="articlePrix">'.$row["prix"].'</div>
        </div>';
      }
      ?>
    </div>

    <?php include './assets/php/footer.php'; ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
