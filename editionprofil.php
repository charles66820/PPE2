<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <title>Editer mon profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <?php include 'assets/php/allcss.php'; ?>
  </head>

  <body>
    <!-- Barre de navigation -->
    <?php include 'assets/php/nav.php';

    //Faire en sorte que les données soient chargées de la bdd pour les voir avant de les modifier

          //teste si la propriétée id est présente
          if (isset($_GET['IDClient'])) {

            //teste s'il y a un id set
            if (!empty($_GET['IDClient'])) {

              $idclient = $_GET['IDClient'];

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
                  $requser = $bdd->prepare("UPDATE `Uclient` SET `Pseudo` = ?, `Nom` = ?, `Prenom` = ?, `Email` = ?, `Telephone` = ?, `Civilite` = ?, `MotDePasse` = ? WHERE IDClient = ?");
                  $requser->execute(array($pseudo, $nomuser, $prenomuser, $mailuser, $teluser, $civilite, $mdpuser, $iduser));
                  header("Location: profil.php");
                }
                else {
                  echo "Les champs pseudo, email, mot de passe et civilité doivent être complétés !";
                }
              }

              //charge les information actuelles de l'utilisateur

              //sql SELECT * FROM utilisateur where
              $requser = $bdd->prepare("SELECT * FROM client WHERE IDClient = ?");
              $requser->execute(array($_GET['IDClient']));
              $dbrep = $requser->fetch();

              //le résultat remplit les variables
              $pseudo = $dbrep['Pseudo'];
              $nomuser = $dbrep['Nom'];
              $prenomuser = $dbrep['Prenom'];
              $mailuser = $dbrep['Email'];
              $teluser = $dbrep['Telephone'];
              $civilite = $dbrep['civilite'];
              $mdpuser = $dbrep['MotDePasse'];
              ?>

              <form method="post">
                <input type="text" name="Nom" value="<?php echo $dbrep["Nom"]; ?>">
                <input type="text" name="Prenom" value="<?php echo $dbrep["Prenom"]; ?>">
                <input type="text" name="Email" value="<?php echo $dbrep["Email"]; ?>">
                <input type="text" name="Telephone" value="<?php echo $dbrep["Telephone"]; ?>">
                <input type="text" name="Civilite" value="<?php echo $dbrep["Civilite"]; ?>">
                <input type="text" name="Pseudo" value="<?php echo $dbrep["Pseudo"]; ?>">
                <input type="text" name="MotDePasse" value="<?php echo $dbrep["MotDePasse"]; ?>">
                <div>
                  <button type="submit" name="formmodifieruser" class="btn btn-success btn-lg float-right">Modifier</button>
                </div>
              </form>

              <?php
            } else {
              ?>
              <div class="container mt-3 text-center">
              <font color="red">Erreur : aucun utilisateur selectionné</font>
              <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('composant.php')">Retour</button>
              </div>
              <?php
            }
          } else {
            ?>
            <div class="container mt-3 text-center">
            <font color="red">Erreur : propriétée id introuvable</font>
            <button type="button" class="btn btn-danger btn-lg" onclick="document.location.replace('composant.php')">Retour</button>
            </div>
          <?php } ?>

            <?php

    // if(isset($_SESSION['id'])) {
    //   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
    //   $requser->execute(array($_SESSION['id']));
    //   $user = $requser->fetch();
    //
    //   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
    //     $newpseudo = htmlspecialchars($_POST['newpseudo']);
    //     $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
    //     $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
    //     header('Location: profil.php?id='.$_SESSION['id']);
    //   }
    //
    //   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
    //     $newmail = htmlspecialchars($_POST['newmail']);
    //     $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
    //     $insertmail->execute(array($newmail, $_SESSION['id']));
    //     header('Location: profil.php?id='.$_SESSION['id']);
    //   }
    //
    //   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
    //     $mdp1 = sha1($_POST['newmdp1']);
    //     $mdp2 = sha1($_POST['newmdp2']);
    //
    //     if($mdp1 == $mdp2) {
    //       $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
    //       $insertmdp->execute(array($mdp1, $_SESSION['id']));
    //       header('Location: profil.php?id='.$_SESSION['id']);
    //
    //     } else {
    //       $msg = "Vos deux mots de passe ne correspondent pas !";
    //     }
    //   }
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
            <!--nom-->
            <tr>
              <td align="right">
                <label>Nom : </label>
              </td>
              <td>
                <input type="text" name="newnom" placeholder="Nom"/>
              </td>
            </tr>
            <!--prénom-->
            <tr>
              <td align="right">
                <label>Prénom : </label>
              </td>
              <td>
                <input type="text" name="newprenom" placeholder="prenom"/>
              </td>
            </tr>
            <!--civilité-->
            <tr>
              <td align="right">
                <label>Civilité : </label>
              </td>
              <td>
                <input type="text" name="newcivilite" placeholder="Civilité"/>
              </td>
            </tr>
            <!--tel-->
            <tr>
              <td align="right">
                <label>N° de téléphone : </label>
              </td>
              <td>
                <input type="text" name="newtel" placeholder="N° de téléphone"/>
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
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
