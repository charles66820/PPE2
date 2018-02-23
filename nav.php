<?php
session_start();

//connexion a la bdd
$bdd = new PDO('mysql:host=127.0.0.1;dbname=ppe2', 'PPE', 'PPE123');

?>
<head>
  <link rel="stylesheet" href="./assets/css/imgNav.css">
</head>
<div>
  <nav class="navbar navbar-light navbar-expand-md">
    <div class="container">
      <a class="navbar-brand" href="accueil.php">
        <img class="imgLogo" src="./assets/img/logoPoulpe.png"/>
      </a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse"id="navcol-1">
        <form class="form-inline navbar-left">
          <div class="input-group">
            <span id="basic-addon1" class="input-group-addon">
              <i class="fa fa-search"></i>
            </span>
            <input class="form-control" type="text" placeholder="Recherche" aria-describedby="basic-addon1">
          </div>
        </form>
        <ul class="nav navbar-nav ml-auto">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" href="accueil.php">Accueil</a>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Figurines</a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Pop</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Nenedoroid</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Officiel</a>
            </div>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Vêtement </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Homme</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Femme</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Enfant</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Cosplay</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Kigurumi</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Bijoux</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Sous-vêtements</a>
              <a class="dropdown-item" role="presentation" href="catalogue.php?">Bonnets & Casquettes</a>
            </div>
          </li>
          <?php
          if (isset($_SESSION['id'])) {
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Compte </a>
                <div class="dropdown-menu" role="menu">
                  <a class="dropdown-item" role="presentation" href="connexion.php">Identifiez vous !</a>
                  <a class="dropdown-item" role="presentation" href="inscription.php">Nouveau client !</a>
                </div>
              </li>
            ';
          }else {
            //en cours de dev...

          }
          ?>
          <li class="dropdown">
            <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Compte </a>
            <div class="dropdown-menu" role="menu">
              <a class="dropdown-item" role="presentation" href="connexion.php">Identifiez vous !</a>
              <a class="dropdown-item" role="presentation" href="inscription.php">Nouveau client !</a>
            </div>
          </li>
          <div class="media">
            <div class="media-left">
              <img src="img_avatar1.png" class="media-object" style="width:45px">
            </div>
            <div class="media-body">
              <h4 class="media-heading">John Doe</h4>
            </div>
          </div>
        </ul>
      </div>
    </div>
  </nav>
</div>
