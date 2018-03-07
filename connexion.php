<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8" >
      <title>Connexion</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="./assets/img/logoIcon.gif"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="./assets/css/connexion.css">
  </head>
  <body>

    <!-- Barre de navigation -->
    <?php
    include './assets/php/nav.php';

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

          //remplachement du header("Location: index.php); par du js a cause d'une erreur
          echo '<script> document.location.replace("accueil.php"); </script>';
        } else {
          $erreur = "<br />Mauvais pseudo ou mot de passe !";
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
      <a href="inscription.php"><br />Bonjour. Toujours pas inscrit ? Rejoignez le club Ô'Tako ;-)</a>
    </div>

    <?php include './assets/php/footer.php'; ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
