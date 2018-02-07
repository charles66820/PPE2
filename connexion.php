<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" >
    <title>Connexion</title>
    <link rel="stylesheet" href="./assets/css/.css" >
</head>
<body>

<!-- Barre de navigation -->


<!--Ancre-->
<div>
    <a class="bouton-footer" href=#footer><img src="./img/down.png" alt="aller en bas de la page"/></a>
    <a class="bouton-top" href="#"><img src="./img/top.png" alt="aller en haut de la page"/></a>
</div>


<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'PPE', 'PPE123');

if(isset($_POST['formconnexion'])) {
    $mailconnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnect = sha1($_POST['mdpconnect']);
    if(!empty($mailconnect) AND !empty($mdpconnect)) {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1) {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: profil.php?id=".$_SESSION['id']);
        } else {
            $erreur = "<br />Mauvais mail ou mot de passe !";
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
        <input type="email" name="mailconnect" placeholder="Mail" />
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

<a href="inscription.php"><br />Bonjour. Toujours pas inscrit ? Rejoignez le club Ô'Tako ;-)</a>

</body>
<footer>
    <a id="footer"></a>
</footer>
</html>
