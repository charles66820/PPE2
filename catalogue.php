<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="./style/bootstrap.min.css">
    <link href="./style/catalogue.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'nav.php'; ?>
    <article>
      <div class="rechercheBar">
        <label>test</label>
        <input type="radio" name="truc" value="truc">
        <input type="radio" name="truc" value="truc2">
      </div>
      <div class="articleBox">
        <?php
        $dbrep = array(array('id'=>'2', 'nom'=>"Poulpe", 'prix'=>"10.0€", 'imgNom'=>"test1.jpg",'star'=>"stars2"),
        array('id'=>'5', 'nom'=>"Poulpe2", 'prix'=>"20.0€", 'imgNom'=>"test2.jpeg",'star'=>"stars4_5"),
        array('id'=>'6', 'nom'=>"Poulpe3", 'prix'=>"20.0€", 'imgNom'=>"test3.jpg",'star'=>"stars3"),
        array('id'=>'13', 'nom'=>"Poulpe4", 'prix'=>"20.0€", 'imgNom'=>"test4.jpg",'star'=>"stars0_5"),
        array('id'=>'28', 'nom'=>"Poulpe5", 'prix'=>"20.0€", 'imgNom'=>"test5.jpg",'star'=>"stars2_5"));

        foreach ($dbrep as $row) {
          echo '<a href="article.php?'.$row["id"].'" class="articleElm">
          <div class="imgBox">
            <img src="./img/imagesUpload/'.$row["imgNom"].'" alt="">
          </div>
          <div class="articleNom">
          '.$row["nom"].'
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
    </article>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
