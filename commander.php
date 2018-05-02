<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>commander</title>
    <?php include 'assets/php/allcss.php'; ?>
  </head>
  <body>
    <?php include 'assets/php/nav.php';
    if (isset($_SESSION['id'])) {
      ?>
      <div class="container">
        <h2>Adresse de facturation</h2>
        <select class="" name="">
          <?php
          $reqselectadresse = $bdd->prepare("SELECT * FROM adresse WHERE IDClient = ?");
          $reqselectadresse->execute(array($_SESSION['id']));
          $repselectadresse = $reqselectadresse->fetchAll();
          foreach ($repselectadresse as $row) {
            ?>
            <option value="<?php echo $row['IDAdresse']; ?>"><?php echo $row['Voie']." ".$row['Complement']." | ".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];?></option>
            <?php
          }
          ?>
        </select>
      </div>
      <?php
    }
    include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
