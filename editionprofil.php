<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Editer mon profil</title>
    <?php include 'assets/php/allcss.php'; ?>
    <link rel="stylesheet" href="/assets/css/Profile-Edit-FormProfil.css">
  </head>
  <body>
    <!-- Barre de navigation -->
    <?php include 'assets/php/nav.php';

    //teste si la propriétée id est présente
    if (isset($_SESSION['id'])) {

      //teste s'il y a un id set
      if (!empty($_SESSION['id'])) {

        $idclient = $_SESSION['id'];

        // //si le bouton "Valider" est clické
        // if (isset($_POST['formmodifieruser'])) {
        //   //teste si les champs ne sont pas vides
        //   if (!empty($_POST['Pseudo']) && !empty($_POST['Email']) && !empty($_POST['MotDePasse']) && !empty($_POST['Civilite'])) {
        //
        //     //variables
        //     $pseudo = htmlspecialchars($_POST['Pseudo']);
        //     $mailuser = htmlspecialchars($_POST['Email']);
        //     $mdpuser = htmlspecialchars($_POST['MotDePasse']);
        //     $nomuser = htmlspecialchars($_POST['Nom']);
        //     $prenomuser = htmlspecialchars($_POST['Prenom']);
        //     $civilite = htmlspecialchars($_POST['Civilite']);
        //     $teluser = htmlspecialchars($_POST['Telephone']);
        //
        //     //le PDO
        //     $requser = $bdd->prepare("UPDATE `client` SET `Pseudo` = ?, `Nom` = ?, `Prenom` = ?, `Email` = ?, `Telephone` = ?, `Civilite` = ?, `MotDePasse` = ? WHERE IDClient = ?");
        //     $requser->execute(array($pseudo, $nomuser, $prenomuser, $mailuser, $teluser, $civilite, $mdpuser, $idclient));
        //   }else {
        //     echo "Les champs pseudo, email, mot de passe et civilité doivent être complétés !";
        //   }
        // }
      }
      //charge les information actuelles de l'utilisateur

      //sql SELECT * FROM utilisateur where
      $requser = $bdd->prepare("SELECT * FROM client WHERE IDClient = ?");
      $requser->execute(array($idclient));
      $dbrep = $requser->fetch();

      ?>
      <div class="container profile profile-view" id="profile">
        <!-- test
        <form method="post">
          <input type="text" name="test" value="truc">
          <input type="submit" name="submit" value="submit">
        </form>
        -->
        <!-- message d'alerte
        <div class="row">
          <div class="col-md-12 alert-col relative">
            <div class="alert alert-info absolue center" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <span>message du profil</span>
            </div>
          </div>
        </div>
      -->
        <form method="post" class="mb-5" id="infouser">
          <div class="form-row profile-row">
            <div class="col-md-4 relative">
              <div class="avatar">
                <div class="avatar-bg center" style=""></div>
              </div>
              <input type="file" name="avatar-file" class="form-control">
            </div>
            <div class="col-md-8">
              <h2>Modifier mon profil</h2>
              <hr>
              <div class="form-row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Pseudo : </label>
                    <input type="text" name="newpseudo" class="form-control" placeholder="Pseudo" value="<?php echo $dbrep['Pseudo']; ?>" />
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Mail : </label>
                    <input type="text" name="newmail" class="form-control" placeholder="Mail" value="<?php echo $dbrep['Email']; ?>" />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Nom : </label>
                    <input type="text" name="newnom" class="form-control" placeholder="Nom" value="<?php echo $dbrep['Nom']; ?>" />
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Prénom : </label>
                    <input type="text" name="newprenom" class="form-control" placeholder="Prenom" value="<?php echo $dbrep['Prenom']; ?>" />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Civilité : </label>
                    <input type="test" name="newcivilite" class="form-control" placeholder="Civilité" value="<?php echo $dbrep['Civilite']; ?>" />
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>N° de téléphone : </label>
                    <input type="test" name="newtel" class="form-control" placeholder="N° de téléphone" value="<?php echo $dbrep['Telephone']; ?>" />
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Mot de passe : </label>
                    <input type="password" name="newmdp1" class="form-control" placeholder="Mot de passe" />
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label>Confirmation du mot de passe : </label>
                    <input type="password" name="newmdp2" class="form-control" placeholder="Confirmation du mdp" />
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-row">
                <div class="col-md-12 content-right">
                  <button class="btn btn-primary form-btn" name="test" value="jghf" type="submit">Sauvegarder</button>
                  <button class="btn btn-danger form-btn" type="reset">Annuler</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        <form method="post" class="mb-5" id="addaddress">
          <div class="form-row">
            <div class="col-md-6 relative">
              <div class="row m-1">
                <h2 class="col-md-6">Adresses</h2>

              </div>
              <div class="col-sm-12 col-md-12">
                <div class="form-group">
                  <ul class="list-group" style="overflow:auto; height: 420px;" >
                    <?php
                    $reqcompoparc = $bdd->prepare("SELECT * FROM adresse WHERE adresse.IDClient = ?");
                    $reqcompoparc->execute(array($idclient));
                    foreach ($reqcompoparc->fetchAll() as $row) {
                      ?>
                      <li class="list-group-item"><?php echo $row['nomComposants']." | ".$row['typeComposants'] ?><input type="checkbox" name="" value=""></li>
                      <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 relative">
              <h2>Ajouter une adresse</h2>
              <hr>
              <div class="col-sm-12 col-md-12">
                <div class="form-group">
                  <label>Adresse : </label>
                  <input type="text" placeholder="Adresse" class="form-control" name="adresse" value="" />

                  <label>Complément d'adresse : </label>
                  <input type="text" placeholder="Complément d'adresse" class="form-control" name="Complement" value="" />

                  <label>Code postal : </label>
                  <input type="text" placeholder="Code postal" class="form-control" name="CodePostal" value="" />

                  <label>Ville : </label>
                  <input type="text" placeholder="Ville" class="form-control" name="Ville" value="" />

                  <label>Pays : </label>
                  <input type="text" placeholder="Pays" class="form-control" name="Pays" value="" />
                </div>
                <hr>
                <button class="btn btn-primary form-btn float-right" type="submit">Ajouter l'adresse</button>
              </div>
            </div>
          </div>
        </form>
        <?php
        if ($dbrep['Actif'] == 0) {
          ?>
          <!--<p>confirmation du compte avec un token </p>-->
          <!-- kevide s'aucupe du mail pour le token -->
          <h2>Confirmation du compte</h2>
          <hr>
          <form method="post" class="mb-5" id="token">
            <label>Entrez le token que vous avez reçu par mail</label>
            <input type="text" placeholder="Token" class="form-control" name="Token" value="" />
            <button class="btn btn-primary form-btn float-right m-2" type="submit">Valider le compte</button>
          </form>
          <hr style="margin-top: 62px">
          <?php
        } ?>
      </div>
    <?php
    } else {
      header("Location: connexion.php");
    }
    //footer
    include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/Profile-Edit-FormProfil.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
