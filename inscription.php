<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/img/logoIcon.gif"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="./assets/css/inscription.css"> -->
  </head>
  <body>
    <?php
    //navbar
    include './assets/php/nav.php';

    //tretement inscription
    if(isset($_POST['forminscription'])) {
      $pseudo = htmlspecialchars($_POST['pseudo']); /* fonction qui permet d'enlever tous les caractères html */
      $mail = htmlspecialchars($_POST['mail']);
      $mail2 = htmlspecialchars($_POST['mail2']);
      $mdp = sha1($_POST['mdp']); /* fonction qui permet la sécurisation du mdp */
      $mdp2 = sha1($_POST['mdp2']);
      $nom = htmlspecialchars($_POST['nom']);
      $prenom = htmlspecialchars($_POST['prenom']);
      $civilite = htmlspecialchars($_POST['civilite']);
      $telephone = htmlspecialchars($_POST['telephone']);
      $avatarurl = 'defaultavatarurl.svg';

      if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
        $pseudolength = strlen($pseudo); /* trouve le nombre de caractère */
        if($pseudolength <= 20) {
          $reqpseudo = $bdd->prepare("SELECT * FROM client WHERE Pseudo = ?");
          $reqpseudo->execute(array($pseudo));
          $pseudoexist = $reqpseudo->rowCount(); /* fonction qui compte le nombre de colonne existante pour ce que l'on a rentré */
          if($pseudoexist == 0) {
            if($mail == $mail2) {
              if(filter_var($mail, FILTER_VALIDATE_EMAIL)) { /* fonction qui permet de voir si c'est bien un email */
                $reqmail = $bdd->prepare("SELECT * FROM client WHERE Email = ?");
                $reqmail->execute(array($mail));
                $mailexist = $reqmail->rowCount();
                if($mailexist == 0) {
                  if($mdp == $mdp2) {
                    $insertmbr = $bdd->prepare("INSERT INTO client(Pseudo, Email, MotDePasse, Nom, Prenom, Civilite, Telephone, AvatarUrl) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertmbr->execute(array($pseudo, $mail, $mdp, $nom, $prenom, $civilite, $telephone, $avatarurl));
                    $erreur = "<br />Votre compte a bien été créé !<br /><a href=\"./accueil.php\"><br />Revenir sur la page d'accueil</a>";
                    
                  } else {
                    $erreur = "Vos mots de passes ne correspondent pas !";
                  }
                } else {
                  $erreur = "Le Adresse mail déjà utilisée !";
                  //
                }
              } else {
                $erreur = "Votre adresse mail n'est pas valide !";
              }
            } else {
              $erreur = "Vos adresses mail ne correspondent pas !";
            }
          } else {
            $erreur = "Le pseudo \"".$pseudo."\" est déjà utilisé !";
          }
        } else {
          $erreur = "Votre pseudo ne doit pas dépasser 20 caratères !";
        }
      } else {
        $erreur = "Tous les champs doivent être complétés !";
      }
    }
    ?>

    <!-- formulaire d'inscription -->
    <div>
      <h1>Inscription</h1>
      <br/>
      <form method="POST" action="">
        <table>

          <!-- pseudo -->
          <tr>
            <td align="right">
              <label for="pseudo">Pseudo :</label>
            </td>
            <td>
              <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" /> <!--permet de laisser afficher apres validation si erreur-->
            </td>
          </tr>

          <!-- mail -->
          <tr>
            <td align="right">
              <label for="mail">Mail :</label>
            </td>
            <td>
              <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <label for="mail2">Confirmation du mail :</label>
            </td>
            <td>
              <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
            </td>
          </tr>

          <!-- mdp -->
          <tr>
            <td align="right">
              <label for="mdp">Mot de passe :</label>
            </td>
            <td>
              <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
            </td>
          </tr>
          <tr>
            <td align="right">
              <label for="mdp2">Confirmation du mot de passe :</label>
            </td>
            <td>
              <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
            </td>
          </tr>

          <!-- nom -->
          <tr>
            <td align="right">
              <label for="nom">Nom :</label>
            </td>
            <td>
              <input type="nom" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
            </td>
          </tr>

          <!-- prenom -->
          <tr>
            <td align="right">
              <label for="prenom">Prénom :</label>
            </td>
            <td>
              <input type="prenom" placeholder="Votre prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
            </td>
          </tr>

          <!-- telephone -->
          <tr>
            <td align="right">
              <label for="telephone">Téléphone :</label>
            </td>
            <td>
              <input type="telephone" placeholder="Votre n° de téléphone" id="telephone" name="telephone" value="<?php if(isset($telephone)) { echo $telephone; } ?>" />
            </td>
          </tr>

          <!-- civilite -->
          <tr>
            <td align="right">
              <label>civilite :</label>
            </td>
            <td>
              <input type="radio" name="civilite" value="homme" checked> homme<br>
              <input type="radio" name="civilite" value="femme"> femme<br>
            </td>
          </tr>

        </table>
        <br />
        <input type="submit" name="forminscription" value="Je m'inscris" />
      </form>
      <?php
        if(isset($erreur)) {
          echo '<font color="red">'.$erreur."</font>";
        }
      ?>
    </div>
    <?php include './assets/php/footer.php'; ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
