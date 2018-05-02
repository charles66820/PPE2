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

      }
      //charge les information actuelles de l'utilisateur

      //sql SELECT * FROM utilisateur where
      $requser = $bdd->prepare("SELECT * FROM client WHERE IDClient = ?");
      $requser->execute(array($idclient));
      $dbrep = $requser->fetch();

      $_SESSION['avatarurl'] = $dbrep['AvatarUrl'];

      if ($dbrep['AvatarUrl'] != null) {
        $imageurl = 'assets/img/imagesupload/'.$dbrep['AvatarUrl'];
        $image = 'data: '.mime_content_type($imageurl).';base64,'.base64_encode(file_get_contents($imageurl));
        $styleavatar = 'style="background: url(\''.$image.'\') 50% 50% / cover;";';
      }else {
        $styleavatar = null;
      }
      ?>
      <div class="container profile profile-view" id="profile">
        <div class="row">
          <div class="col-md-12 alert-col position-fixed" style="width:80%; z-index:1000;pointer-events: none;">
            <div class="alert alert-info absolue center" role="alert">
              <span>message du profil</span>
            </div>
          </div>
        </div>
        <form method="post" class="mb-5" id="infouser">
          <div class="form-row profile-row">
            <div class="col-md-4 relative">
              <div class="avatar">
                <div class="avatar-bg center" <?php echo $styleavatar ?>></div>
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
                <input type="hidden" name="modifiecompte">
                <div class="col-md-12 content-right">
                  <button class="btn btn-primary form-btn" type="submit">Sauvegarder</button>
                  <button class="btn btn-danger form-btn" type="reset">Annuler</button>
                </div>
              </div>
            </div>
          </div>
        </form>
          <div class="form-row">
            <div class="col-md-6 relative">
              <div class="row m-1">
                <h2 class="col-md-6">Adresses</h2>
                <div class="col-md-6">
                  <p class="absolute" style="bottom: 0px;right: 0px;position: absolute;">adresse par default</p>
                </div>
              </div>
              <div class="col-sm-12 col-md-12">
                <script>
                function defaultaddress(e) {
                  let elmRoleId = $(e).attr("data-idadresse");
                  $.post( "/assets/php/editprofil.php", { defaultaddress: '', idadresse: elmRoleId }).done(function( data ) { console.log(data)});
                }
                </script>
                <div class="form-group" id="adresses">
                  <?php
                  include 'assets/php/loadaddress.php';
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 relative">
              <h2>Ajouter une adresse</h2>
              <hr>
              <form method="post" class="mb-5" id="addaddress">
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
                  <input type="hidden" name="addadresse">
                  <button class="btn btn-primary form-btn float-right" type="submit">Ajouter l'adresse</button>
                </div>
              </form>
            </div>
          </div>
        <?php
        if ($dbrep['Actif'] == 0) {
          ?>
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
