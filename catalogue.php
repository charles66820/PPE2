<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="./style/catalogue.css" rel="stylesheet">
  </head>
  <body>
    <article>
      <div class="rechercheBar">
        <label>test</label>
        <input type="radio" name="truc" value="truc">
        <input type="radio" name="truc" value="truc2">
      </div>
      <div class="articleBox">
        <div class="articleElm">
          <div class="imgBox">
            <img src="./img/imagesUpload/test1.jpg" alt="">
          </div>
          <div class="articleNom">

          </div>
          <div class="articleStar">

          </div>
          <div class="articlePrix">

          </div>
        </div>
        <?php
        $dbrep = array(array('nom'=>"test1", 'prix'=>"10.0€", 'imgNom'=>"test1.jpg",'star'=>".star-4-5"),
        array('nom'=>"test2", 'prix'=>"20.0€", 'imgNom'=>"test1.jpg",'star'=>".star-4-5"),
        array('nom'=>"test2", 'prix'=>"20.0€", 'imgNom'=>"test1.jpg",'star'=>".star-4-5"),
        array('nom'=>"test2", 'prix'=>"20.0€", 'imgNom'=>"test1.jpg",'star'=>".star-4-5"),
        array('nom'=>"test2", 'prix'=>"20.0€", 'imgNom'=>"test1.jpg",'star'=>".star-4-5"));
        foreach ($dbrep as $row) {
          echo '<div class="articleElm">
          <div class="imgBox">
            <img src="./img/imagesUpload/'.$row["imgNom"].'" alt="">
          </div>
          <div class="articleNom">
          '.$row["nom"].'
          </div>
          <div class="articleStar">

          </div>
          <div class="articlePrix">
          '.$row["prix"].'
          </div>
           </div>';
        }
        ?>
      </div>
    </article>
  </body>
</html>
