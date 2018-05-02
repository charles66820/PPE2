<?php
isset($_GET['bdd'])? require 'setting.bdd.php' : null;
if (isset($_SESSION['id'])) {
  ?>
  <ul class="list-group" style="overflow:auto; height: 420px;" >
    <?php
    $reqcompoparc = $bdd->prepare("SELECT * FROM adresse WHERE adresse.IDClient = ?");
    $reqcompoparc->execute(array($_SESSION['id']));
    foreach ($reqcompoparc->fetchAll() as $row) {
      ?>
        <li class="list-group-item">
          <div class="row">
            <p class="col-9">
              <?php echo $row['Voie']." | ".$row['Complement']."<br>".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];  ?>
            </p>
            <div class="col-3">
              <?php
              $requser = $bdd->prepare("SELECT client.iddefaultadresse FROM client WHERE IDClient = ?");
              $requser->execute(array($_SESSION['id']));
              $dbrepuser = $requser->fetch();
              if ($row['IDAdresse'] == $dbrepuser['iddefaultadresse']) {
                ?>
                <input type="radio" name="defaultaddress[]" data-idadresse="<?php echo $row['IDAdresse']; ?>" onclick="defaultaddress(this)" class="float-right m-1" checked>
                <?php
              } else {
                ?>
                <input type="radio" name="defaultaddress[]" data-idadresse="<?php echo $row['IDAdresse']; ?>" onclick="defaultaddress(this)" class="float-right m-1">
                <?php
              }
              ?>
              <form method="post" style="display:initial;">
                <input type="hidden" name="adressevalue" value="<?php echo $row['IDAdresse']; ?>">
                <button type="submit" class="btn btn-danger float-right" onclick="if (confirm('Êtes-vous sur de vouloir supprimer cette adresse ?')) {return true;}else {return false;}">✗</button>
              </div>
            </form>
          </div>
        </li>
      <?php
    }
    ?>
  </ul>
  <?php
}
?>
