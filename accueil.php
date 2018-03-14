<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Accueil</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="./assets/img/logoIcon.gif"/>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="./assets/css/accueil.css">
      <link rel="stylesheet" href="./assets/css/Footer-Clean.css">
      <link rel="stylesheet" href="./assets/css/Pretty-Footer.css">
      <link rel="stylesheet" href="./assets/css/stylesF.css">
  </head>
  <body>
    <?php include './assets/php/nav.php'; ?>
    <div class="highlight-phone">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="intro">
              <h2 style="height:50px;color:#2a6bab;font-size:36px;"><span style="text-decoration: underline;">Bienvenue</span></h2>
              <p style="height:20px;font-size:22px;">Hey, bienvenue sur Ô'Tako ! Je suis Poulpi et je suis là pour te guider.</p>
              <p style="font-size:22px;height:20px;">Si tu es nouveau, viens vite t'inscrire et deviens un membre de la Tako Family ! </p><br/>
              <a class="btn btn-primary" role="button" href="inscription.php" style="background-color:rgb(27,159,167);height:75px;margin:15px;width:300px;padding:20px;font-size:20px;">M'inscrire maintenant !</a>
            </div>
          </div>
          <div class="col-sm-4" style="background-image:url(&quot;assets/img/poulpe8.jpg&quot;);">
            <div class="d-none d-md-block iphone-mockup"></div>
          </div>
        </div>
      </div>
    </div>
    <!-- pauline -->
    <div id="slider">
      <figure>
        <img src="./assets/img/promo13.jpg" alt>
        <img src="./assets/img/promo12.jpg" alt>
        <img src="./assets/img/promo14.jpg" alt>
        <img src="./assets/img/promo3.jpg" alt>
        <img src="./assets/img/promo5.jpg" alt>
        <img src="./assets/img/promo1.jpg" alt>
      </figure>
    </div>
    <?php include './assets/php/footer.php'; ?>
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
