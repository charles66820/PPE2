<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Erreur 500</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
      <?php include 'assets/php/allcss.php'; ?>
      <style>
      .potitionerror{
        margin: 10% auto;
      }
      html{
        height: 100%;
      }
      body{
        height: 100%;
      }
      section{
        min-height: 85%;
      }
      </style>
  </head>
  <body>
    <?php include '../php/nav.php'; ?>
    <div class="error potitionerror">
      <div class="container-floud">
        <div class="col-xs-12 ground-color text-center">
          <h1>Oops!</h1>
          <h2>500 Internal Server Error</h2>
          <h2 class="error-details">Erreur interne au serveur, réessayez plus tard ! :'(</h2>
        </div>
      </div>
    </div>
    <?php include '../php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
