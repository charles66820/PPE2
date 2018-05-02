<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8" >
      <title>Connexion</title>
      <?php include 'assets/php/allcss.php'; ?>
      <style>
      div#inscription {
        margin: 0 auto;
        width: 332px;
      }
      </style>
  </head>
  <body>
    <!-- Barre de navigation -->
    <?php
    include 'assets/php/nav.php';
    if(isset($_POST['formconnexion'])) {
      $pseudoconnect = htmlspecialchars($_POST['pseudoconnect']);
      $mdpconnect = sha1($_POST['mdpconnect']);
      if(!empty($pseudoconnect) AND !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT client.IDClient, client.Pseudo, client.Email, client.AvatarUrl FROM client WHERE Pseudo = ? AND MotDePasse = ?");
        $requser->execute(array($pseudoconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
          $userinfo = $requser->fetch();
          $_SESSION['id'] = $userinfo['IDClient'];
          $_SESSION['pseudo'] = $userinfo['Pseudo'];
          $_SESSION['mail'] = $userinfo['Email'];
          $_SESSION['avatarurl'] = $userinfo['AvatarUrl'];

          //Remplacement du header("Location: index.php"); par du js à cause d'une erreur
          echo '<script> document.location.replace("accueil.php"); </script>';
        } else {
          $erreur = "<br />Mauvais pseudo ou mauvais mot de passe !";
        }
      } else {
        $erreur = "<br />Tous les champs doivent être complétés !";
      }
    }
    ?>
    <div align="center">
      <div class="container">
        <div class="card card-container" style="max-width: 350px; padding: 40px 40px;">
          <h2>Connexion</h2>
          <br /><br />
          <form method="POST">
            <div class="form-group">
              <input type="text" class="form-control"name="pseudoconnect" placeholder="Pseudo" />
            </div>
            <div class="form-group">
              <input type="password" class="form-control"name="mdpconnect" placeholder="Mot de passe" />
            </div>

            <br /><br />
            <input type="submit" class="btn btn-primary" name="formconnexion" value="Se connecter" />
          </form>
          <?php
          if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
          }
          ?>
        </div>
      </div>
    </div>

    <div id="inscription">
      <a href="inscription.php"><br />Toujours pas inscrit ? Rejoins le club Ô'Tako 🐙</a>
    </div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
