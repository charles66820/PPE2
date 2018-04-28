<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8" >
      <title>Connexion</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <?php include 'assets/php/allcss.php'; ?>
      <style>
      div#inscription {
        margin: 0 auto;
        width: 450px;
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
      <h2>Connexion</h2>
      <br /><br />
      <form method="POST" action="">
        <input type="text" name="pseudoconnect" placeholder="Pseudo" />
        <input type="password" name="mdpconnect" placeholder="Mot de passe" />
        <br /><br />
        <input type="submit" name="formconnexion" value="Se connecter" />
      </form>
      <?php
      if(isset($erreur)) {
        echo '<font color="red">'.$erreur."</font>";
      }
      ?>
    </div>

    <div id="inscription">
      <a href="inscription.php"><br />Toujours pas inscrit ? Rejoins le club Ô'Tako 🐙</a>
    </div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
