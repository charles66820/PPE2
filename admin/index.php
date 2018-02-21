<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>administration</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
  </head>
  <body>
    <?php
    if ($_SESSION['id']) {
      # code...
    }
    // button provisoire
    echo '
    <div>
      <a href="#produits">produit</a>
    </div>';
    ?>

  </body>
</html>
