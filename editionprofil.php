<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Editer mon profil</title>
    <?php include 'assets/php/allcss.php'; ?>
    <link rel="stylesheet" href="assets/css/Profile-Edit-FormProfil.css">
  </head>
  <body>
    <!-- Barre de navigation -->
    <?php include 'assets/php/nav.php';

    //teste si la propriétée id est présente
    if (isset($_SESSION['id'])) {

      //teste s'il y a un id set
      if (!empty($_SESSION['id'])) {

        $idclient = $_SESSION['id'];

        //si le bouton "Valider" est clické
        if (isset($_POST['formmodifieruser'])) {
          //teste si les champs ne sont pas vides
          if (!empty($_POST['Pseudo']) && !empty($_POST['Email']) && !empty($_POST['MotDePasse']) && !empty($_POST['Civilite'])) {

            //variables
            $pseudo = htmlspecialchars($_POST['Pseudo']);
            $mailuser = htmlspecialchars($_POST['Email']);
            $mdpuser = htmlspecialchars($_POST['MotDePasse']);
            $nomuser = htmlspecialchars($_POST['Nom']);
            $prenomuser = htmlspecialchars($_POST['Prenom']);
            $civilite = htmlspecialchars($_POST['Civilite']);
            $teluser = htmlspecialchars($_POST['Telephone']);

            //le PDO
            $requser = $bdd->prepare("UPDATE `client` SET `Pseudo` = ?, `Nom` = ?, `Prenom` = ?, `Email` = ?, `Telephone` = ?, `Civilite` = ?, `MotDePasse` = ? WHERE IDClient = ?");
            $requser->execute(array($pseudo, $nomuser, $prenomuser, $mailuser, $teluser, $civilite, $mdpuser, $idclient));
            header("Location: profil.php");
          }else {
            echo "Les champs pseudo, email, mot de passe et civilité doivent être complétés !";
          }
        }
      }
      //charge les information actuelles de l'utilisateur

      //sql SELECT * FROM utilisateur where
      $requser = $bdd->prepare("SELECT * FROM client WHERE IDClient = ?");
      $requser->execute(array($idclient));
      $dbrep = $requser->fetch();

      ?>
      <div class="container profile profile-view" id="profile">
        <div class="row">
          <div class="col-md-12 alert-col relative">
            <div class="alert alert-info absolue center" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <span>message du profil</span>
            </div>
          </div>
        </div>
        <form method="post">
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
                    <input type="test" name="newtel" class="form-control" placeholder="N° de téléphone" value="<?php echo $dbrep['']; ?>" />
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-row">
                <div class="col-md-12 content-right">
                  <button class="btn btn-primary form-btn" type="submit">Sauvegarder</button>
                  <button class="btn btn-danger form-btn" type="reset">Annuler</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <label for="Complement">Complément d'adresse : </label>
      <input type="text" placeholder="Complément d'adresse" id="Complement" name="Complement" value="" />

      <label for="CodePostal">Code postal : </label>
      <input type="text" placeholder="Code postal" id="CodePostal" name="CodePostal" value="" />

      <label for="Ville">Ville : </label>
      <input type="text" placeholder="Ville" id="Ville" name="Ville" value="" />

      <label for="Pays">Pays : </label>

      <input type="text" placeholder="Pays" id="Pays" name="Pays" value="" />

      <input type="submit" value="Mettre à jour mon profil" />
    </form>

    <?php



    } else {
      header("Location: connexion.php");
    }
    //footer
    include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
    <script src="/assets/js/Profile-Edit-FormProfil.js"></script>
  </body>
</html>
