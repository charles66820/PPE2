<?php
require 'setting.bdd.php';
include 'genurl.php';
?>
<head>
  <link rel="stylesheet" href="/assets/css/imgNav.css">
</head>
<div>
  <nav class="navbar navbar-light navbar-expand-md">
    <div class="container">
      <a class="navbar-brand" href="/accueil.php">
        <img class="imgLogo" src="/assets/img/logoPoulpe.png"/>
      </a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navcol-1">
        <form class="form-inline navbar-left" action="/catalogue.php">
          <?php if (!empty($categorie)) {?><input type="hidden" name="categorie" value="<?php echo $categorie ?>"><?php } ?>
          <?php if (!empty($type)) {?><input type="hidden" name="type" value="<?php echo $type ?>"><?php } ?>
          <?php if (!empty($stars)) {?><input type="hidden" name="stars" value="<?php echo $stars ?>"><?php } ?>
          <?php if (!empty($maxprice)) {?><input type="hidden" name="maxprice" value="<?php echo $maxprice ?>"><?php } ?>
          <div class="input-group">
            <span id="basic-addon1" class="input-group-addon" onclick="this.parentNode.parentNode.submit()">
              <i class="fa fa-search"></i>
            </span>
            <input class="form-control" type="text" name="search" placeholder="Recherche" aria-describedby="basic-addon1" value="<?php echo $search ?>">
          </div>
        </form>
        <ul class="nav navbar-nav ml-auto">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" href="/accueil.php">Accueil</a>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Figurines</a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=figurines&type=pop'); ?>">Pop</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=figurines&type=nenedoroid'); ?>">Nenedoroid</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=figurines&type=officiel'); ?>">Figurines officielles</a>
            </div>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Vêtements</a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=homme'); ?>">Hommes</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=femme'); ?>">Femmes</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=enfant'); ?>">Enfants</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=cosplay'); ?>">Cosplays</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=kigurumi'); ?>">Kigurumi</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=bijoux'); ?>">Bijoux</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=sous_vetements'); ?>">Sous-vêtements</a>
              <a class="dropdown-item" role="presentation" href="/catalogue.php?<?php echo genurl('nav', 'categorie=vetement&type=bonnets_casquettes'); ?>">Bonnets & Casquettes</a>
            </div>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link active" href="/panier.php"><img class="imgPanier" src="/assets/img/panier.png"/>   Panier</a>
          </li>
          <?php
          //test si un client est connecté
          if (isset($_SESSION['id'])) {

            //affiche les pages de gestion de l'admin
            if ($_SESSION['pseudo'] == 'Admin') {
              $adminoption = '<a class="dropdown-item" role="presentation" href="/modifiercatalogue.php">Modifier le catalogue !</a>';
            }else {
              $adminoption = ' ';
            }

            //afficher le menu connecter
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">
                <img src="/assets/img/'.$_SESSION['avatarurl'].'" style="width:20px;">
                <span>'.$_SESSION['pseudo'].'</span>
              </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" role="presentation" href="/editionprofil.php">Editer mon profil</a>
                <a class="dropdown-item" role="presentation" href="/commandes.php">Historique des commandes</a>'.$adminoption.'
                <a class="dropdown-item" role="presentation" href="/assets/php/deconnexion.php">Déconnectez-vous !</a>
              </div>
            </li>
            ';
          }else {
            //afficher le menu par defaut
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Compte </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" role="presentation" href="/connexion.php">Identifiez vous !</a>
                <a class="dropdown-item" role="presentation" href="/inscription.php">Nouveau client !</a>
              </div>
            </li>';
          }
          ?>

        </ul>
      </div>
    </div>
  </nav>
</div>
