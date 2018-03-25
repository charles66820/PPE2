<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Editer mon profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logoIcon.gif"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/Footer-Clean.css">
    <link rel="stylesheet" href="/assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="/assets/css/stylesF.css">
  </head>

  <body>
    <!-- Barre de navigation -->
    <?php include 'assets/php/nav.php'; ?>


    <?php
    // TODO: Faire en sorte que les données soient chargées de la bdd pour les voir avant de les modifier

    if(isset($_SESSION['id'])) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
      $requser->execute(array($_SESSION['id']));
      $user = $requser->fetch();
      if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
      }
      if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
        $newmail = htmlspecialchars($_POST['newmail']);
        $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
        $insertmail->execute(array($newmail, $_SESSION['id']));
        header('Location: profil.php?id='.$_SESSION['id']);
      }
      if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);
        if($mdp1 == $mdp2) {
          $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
          $insertmdp->execute(array($mdp1, $_SESSION['id']));
          header('Location: profil.php?id='.$_SESSION['id']);
        } else {
          $msg = "Vos deux mots de passe ne correspondent pas !";
        }
      }
    ?>

    <div align="center">
      <h2>Editer mon profil</h2>
      <div>
        <form method="POST" action="" enctype="multipart/form-data">
          <table>
            <!--pseudo-->
            <tr>
              <td align="right">
                <label>Pseudo : </label>
              </td>
              <td>
                <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" />
              </td>
            </tr>
            <!--mail-->
            <tr>
              <td align="right">
                <label>Mail : </label>
              </td>
              <td>
                <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" />
              </td>
            </tr>
            <!--mdp-->
            <tr>
              <td align="right">
                <label>Mot de passe : </label>
              </td>
              <td>
                <input type="password" name="newmdp1" placeholder="Mot de passe"/>
              </td>
            </tr>
            <!--mdp2-->
            <tr>
              <td align="right">
                <label>Confirmation du mot de passe : </label>
              </td>
              <td>
                <input type="password" name="newmdp2" placeholder="Confirmation du mdp" />
              </td>
            </tr>
          </table><br />

          <!--partie pour l'adresse-->
          <div class="adresse">
            <h4>Adresse</h4><br />
              <table>
                <!-- n° et voie -->
                <tr>
                  <td align="right">
                    <label for="Voie">N° et voie : </label>
                  </td>
                  <td>
                    <input type="text" placeholder="N° et voie" id="Voie" name="Voie" value="<?php if(isset($Voie)) { echo $Voie; } ?>" />
                  </td>
                </tr>
                <!--complement d'adresse-->
                <tr>
                  <td align="right">
                    <label for="Complement">Complément d'adresse : </label>
                  </td>
                  <td>
                    <input type="text" placeholder="Complément d'adresse" id="Complement" name="Complement" value="<?php if(isset($Complement)) { echo $Complement; } ?>" />
                  </td>
                </tr>
                <!--code postal-->
                <tr>
                  <td align="right">
                    <label for="CodePostal">Code postal : </label>
                  </td>
                  <td>
                    <input type="text" placeholder="Code postal" id="CodePostal" name="CodePostal" value="<?php if(isset($CodePostal)) { echo $CodePostal; } ?>" />
                  </td>
                </tr>
                <!--Ville-->
                <tr>
                  <td align="right">
                    <label for="Ville">Ville : </label>
                  </td>
                  <td>
                    <input type="text" placeholder="Ville" id="Ville" name="Ville" value="<?php if(isset($Ville)) { echo $Ville; } ?>" />
                  </td>
                </tr>
                <!--pays-->
                <tr>
                  <td align="right">
                    <label for="Pays">Pays : </label>
                  </td>
                  <td>
                    <input type="text" placeholder="Pays" id="Pays" name="Pays" value="<?php if(isset($Pays)) { echo $Pays; } ?>" />
                  </td>
                </tr>
              </table><br />

          <input type="submit" value="Mettre à jour mon profil" />
        </form>
        <?php if(isset($msg)) { echo $msg; } ?>
      </div>
    </div>

    <?php
    }else {
      header("Location: connexion.php");
    }

    //footer
    include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
