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
                      <input class="form-control" type="text" placeholder="Search" aria-describedby="basic-addon1">
                    </div>
                </form>
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" href="accueil.php">Accueil</a>
                    </li>
                    <li class="dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Figurines</a>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" role="presentation" href="#">Pop</a>
                          <a class="dropdown-item" role="presentation" href="#">Nenedoroid</a>
                          <a class="dropdown-item" role="presentation" href="#">Officiel</a>
                        </div>
                    </li>
                    <li class="dropdown">
                      <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Vêtement</a>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" role="presentation" href="#">Homme</a>
                          <a class="dropdown-item" role="presentation" href="#">Femme</a>
                          <a class="dropdown-item" role="presentation" href="#">Enfant</a>
                          <a class="dropdown-item" role="presentation" href="#">Cosplay</a>
                          <a class="dropdown-item" role="presentation" href="#">Kigurumi</a>
                          <a class="dropdown-item" role="presentation" href="#">Bijoux</a>
                          <a class="dropdown-item" role="presentation" href="#">Sous-vêtements</a>
                          <a class="dropdown-item" role="presentation" href="#">Bonnets & Casquettes</a>
                        </div>
                    </li>
                    <li class="dropdown">
                      <a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#">Compte</a>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" role="presentation" href="editionprofil.php">Identifiez vous !</a>
                          <a class="dropdown-item" role="presentation" href="inscription.php">Nouveau client !</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
