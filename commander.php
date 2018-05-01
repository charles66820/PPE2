<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <div class="container">
      <h2>Adresse de facturation</h2>
      <?php
      foreach($selectadresse as $row) { //Permet de donner les adresses du client
        $id = $row['IDClient'];
        $reqselectadresse = $bdd->prepare("SELECT * FROM adresse WHERE IDClient = ?");
        $reqselectadresse->execute(array($_SESSION['id']));
        $repselectadresse = $reqselectadresse->fetch()
        ?>

      <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Adresses
          <span class="caret"></span></button>
          <ul class="dropdown-menu">
            <li><a href="#"><?php echo $row['Voie'] ?></a></li>
          </ul>
        </div>
      </div>

  </body>
</html>
