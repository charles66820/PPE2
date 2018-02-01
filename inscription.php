<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>

    <?php
    //$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', '');

    if(isset($_POST['forminscription'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $pseudo = htmlspecialchars($_POST['pseudo']); /* fonction qui permet d'enlever tous les caractères html */
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $mdp = sha1($_POST['mdp']); /* fonction qui permet la sécurisation du mdp */
        $mdp2 = sha1($_POST['mdp2']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $cp = htmlspecialchars($_POST['cp']);
        $ville = htmlspecialchars($_POST['ville']);
        $telephone = htmlspecialchars($_POST['telephone']);

        if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
            $pseudolength = strlen($pseudo); /* trouve le nombre de caractère */
            if($pseudolength <= 20) {
              $reqpseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
              $reqpseudo->execute(array($pseudo));
              $pseudoexist = $reqpseudo->rowCount(); /* fonction qui compte le nombre de colonne existante pour ce que l'on a rentré */
              if($pseudoexist == 0) {
                if($mail == $mail2) {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) { /* fonction qui permet de voir si c'est bien un email */
                        $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                        $reqmail->execute(array($mail));
                        $mailexist = $reqmail->rowCount();
                        if($mailexist == 0) {
                            if($mdp == $mdp2) {
                                $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
                                $insertmbr->execute(array($pseudo, $mail, $mdp));
                                $erreur = "<br />Votre compte a bien été créé !<br /><a href=\"../index.php\"><br />Revenir sur la page d'accueil</a>";
                            } else {
                                $erreur = "Vos mots de passes ne correspondent pas !";
                            }
                        } else {
                            $erreur = "Adresse mail déjà utilisée !";
                        }
                    } else {
                        $erreur = "Votre adresse mail n'est pas valide !";
                    }
                } else {
                    $erreur = "Vos adresses mail ne correspondent pas !";
                }
              } else {
                $erreur = "Pseudo déjà utilisé !";
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
    <h1>Inscription</h1><br />

    <form method="POST" action="">
        <table>
            <tr>
              <td align="right">
                  <label for="nom">Nom :</label>
              </td>
              <td>
                  <input type="nom" placeholder="Votre nom" id="nom" name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
              </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="prenom">Prénom :</label>
                </td>
                <td>
                    <input type="prenom" placeholder="Votre prénom" id="prenom" name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="pseudo">Pseudo :</label>
                </td>
                <td>
                    <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" /> <!--permet de laisser afficher apres validation si erreur-->
                </td>
            </tr>
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
            <tr>
                <td align="right">
                    <label for="adresse">Adresse :</label>
                </td>
                <td>
                    <input type="adresse" placeholder="Votre adresse" id="adresse" name="adresse" value="<?php if(isset($adresse)) { echo $adresse; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="cp">Code postal :</label>
                </td>
                <td>
                    <input type="cp" placeholder="Votre code postal" id="cp" name="cp" value="<?php if(isset($cp)) { echo $cp; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="ville">Ville :</label>
                </td>
                <td>
                    <input type="ville" placeholder="Votre ville" id="ville" name="ville" value="<?php if(isset($ville)) { echo $ville; } ?>" />
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="telephone">Téléphone :</label>
                </td>
                <td>
                    <input type="telephone" placeholder="Votre n° de téléphone" id="telephone" name="telephone" value="<?php if(isset($telephone)) { echo $telephone; } ?>" />
                </td>
            </tr>
        </table>
        <br /><input type="submit" name="forminscription" value="Je m'inscris" />
    </form>
    <?php
        if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
        }
    ?>
    </div>

  </body>
</html>
