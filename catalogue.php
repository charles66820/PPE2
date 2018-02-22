<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>catalogue</title>
    <link rel="icon" href="./assets/img/logoIcon.gif"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link href="./assets/css/catalogue.css" rel="stylesheet">
  </head>

  <body>
    <?php include 'nav.php'; ?>

<div class="col-md-2" style="float: left;">
  <nav>
    <div class="range">
    <form action="/action_page.php">
    Prix de : <input type="range" name="points" min="0" max="100">€
    <input type="submit">
    </form>
    </div>
    <div class="rectangle">
      <div class="stars1"></div> <div class="etplus" style="top: 10px;" >&plus</div> <!-- Met le "&plus" en face des étoiles -->
      <div class="stars2"></div> <div class="etplus" style="top: 45px;">&plus</div>
      <div class="stars3"></div> <div class="etplus" style="top: 80px;">&plus</div>
      <div class="stars4"></div> <div class="etplus" style="top: 115px;">&plus</div>
      <div class="stars5"></div>
    </div>
  </nav>
</div>
<div class="col-md-10" style="display: inline-block;">



    <div class="articleBox">
      <?php
      $dbrep = array(array('id'=>'2', 'nom'=>"Poulpe", 'prix'=>"10.0€", 'imgNom'=>"test1.jpg",'star'=>"stars2", 'description'=>'testtttt'),
      array('id'=>'5', 'nom'=>"Poulpe2", 'prix'=>"20.0€", 'imgNom'=>"test2.jpeg",'star'=>"stars4_5", 'description'=>'testtttt'),
      array('id'=>'6', 'nom'=>"Poulpe3", 'prix'=>"20.0€", 'imgNom'=>"test3.jpg",'star'=>"stars3", 'description'=>'testtttt'),
      array('id'=>'13', 'nom'=>"Poulpe4", 'prix'=>"20.0€", 'imgNom'=>"test4.jpg",'star'=>"stars0_5", 'description'=>'testtttt'),
      array('id'=>'69', 'nom'=>"Poulpe99", 'prix'=>"20.0€", 'imgNom'=>"test4.jpg",'star'=>"stars0_5", 'description'=>'testtttt'),
      array('id'=>'28', 'nom'=>"Poulpe5", 'prix'=>"20.0€", 'imgNom'=>"test5.jpg",'star'=>"stars3_5", 'description'=>'testjyfuydtttt'));

      foreach ($dbrep as $row) {
        echo '<a href="produit.php?id='.$row["id"].'" class="articleElm">
        <div class="articleNom">
        '.$row["nom"].'
        </div>
        <div class="imgBox">
          <img src="./assets/img/imagesUpload/'.$row["imgNom"].'" alt="">
        </div>
        <div class="articleNom">
        '.$row["description"].'
        </div>
        <div class="'.$row["star"].' articleStar">
        </div>
        <div class="articlePrix">
        '.$row["prix"].'
        </div>
        </a>';
      }
      ?>
    </div>


</div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
