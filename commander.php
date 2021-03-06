<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>commander</title>
    <?php include 'assets/php/allcss.php'; ?>
  </head>
  <body>
    <?php include 'assets/php/nav.php';
    if (isset($_SESSION['id'])) {
      $reqselectadresse = $bdd->prepare("SELECT * FROM adresse WHERE IDClient = ?");
      $reqselectadresse->execute(array($_SESSION['id']));
      $repselectadresse = $reqselectadresse->fetchAll();

      $requser = $bdd->prepare("SELECT client.iddefaultadresse FROM client WHERE IDClient = ?");
      $requser->execute(array($_SESSION['id']));
      $dbrepuser = $requser->fetch();

      $reqselectadresse = $bdd->prepare("SELECT * FROM lignepanier, produits WHERE lignepanier.IDProduit = produits.IDProduit AND lignepanier.IDClient = ?");
      $reqselectadresse->execute(array($_SESSION['id']));

      ?>
      <div class="container">
        <div class="col-12 col-md-12 mb-2">
          <div class="row">
            <div class="col col-sm-6 col-md-8 col-lg-9"><label class="col-form-label">Nom</label></div>
            <div class="col col-sm-2 col-md-1 col-lg-1"><label class="col-form-label">Prix</label></div>
            <div class="col col-sm-4 col-md-3 col-lg-2"><label class="col-form-label pull-right">Quantité</label></div>
          </div>
        </div>
        <?php
        if ($reqselectadresse->rowCount() <= 0){
          echo '<script> document.location.replace("accueil.php"); </script>';
        } else {
          $totalht = 0;
          $fraitport = 10;
          foreach ($reqselectadresse->fetchAll() as $rows) {
            ?>
            <div class="col-12 col-md-12 mb-2">
              <div class="row">
                <div class="col-xs-1 col-sm-6 col-md-8 col-lg-9">
                  <label class="col-form-label"><?php echo htmlspecialchars($rows['LibelleProduit']) ?></label>
                </div>
                <div class="col-11 col-sm-5 col-md-3 col-lg-2">
                  <label class="col-form-label"><?php echo htmlspecialchars($rows['PrixUnitaireHT']) ?>€</label>
                </div>
                  <label class="col-form-label pull-right m-1"><?php echo htmlspecialchars($rows['quantite']) ?></label>
              </div>
            </div>
            <?php
            $totalht += (htmlspecialchars($rows['PrixUnitaireHT']) * intval(htmlspecialchars($rows['quantite'])));
          }
          $prixttc = (($totalht+$fraitport)*1.2);
          ?>
          <div class="col-12 col-md-12 mb-2">
            <div class="row">
              <div class="col-12 col-sm-6 col-md-6">
                <?php echo "prixHT :".$totalht." | frait de port : ".$fraitport." | prixTTC : ".$prixttc?>
              </div>
            </div>
          </div>


          <?php
        }
        ?>
        <form method="post" action="/assets/php/paiement.php">
          <div class="form-row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <h2>Adresse de facturation</h2>
                <select class="form-control" name="adressefacturation">
                  <?php
                  foreach ($repselectadresse as $row) {
                    if ($row['IDAdresse'] == $dbrepuser['iddefaultadresse']) {
                      ?>
                      <option value="<?php echo $row['IDAdresse']; ?>" selected><?php echo $row['Voie']." ".$row['Complement']." | ".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];?></option>
                      <?php
                    } else {
                      ?>
                      <option value="<?php echo $row['IDAdresse']; ?>"><?php echo $row['Voie']." ".$row['Complement']." | ".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <a href="/editionprofil.php">Vous pouver ajouter une nouvelle adresse dans votre profil</a>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <h2>Adresse de livraison</h2>
                <select class="form-control" name="adresselivreson">
                  <?php
                  foreach ($repselectadresse as $row) {
                    if ($row['IDAdresse'] == $dbrepuser['iddefaultadresse']) {
                      ?>
                      <option value="<?php echo $row['IDAdresse']; ?>" selected><?php echo $row['Voie']." ".$row['Complement']." | ".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];?></option>
                      <?php
                    } else {
                      ?>
                      <option value="<?php echo $row['IDAdresse']; ?>"><?php echo $row['Voie']." ".$row['Complement']." | ".$row['CodePostal']." ".$row['Ville'].", ".$row['Pays'];?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
                <a href="/editionprofil.php">Vous pouver ajouter une nouvelle adresse dans votre profil</a>
              </div>
            </div>
          </div>
          <div class="form-row">
            <button type="button" class="mx-auto m-2" id="paypal-button"></button>
          </div>
          <?php
          include 'assets/php/braintree-paypal/lib/Braintree.php';
          $gateway = new Braintree_Gateway(array(
            'accessToken' => 'access_token$sandbox$v743jd8dx9tcqm7d$b74e1af2628d3cfd035f697d05de5fd0',
          ));
          ?>
          <script src="https://www.paypalobjects.com/api/checkout.js" data-version-4></script>
          <script src="https://js.braintreegateway.com/web/3.25.0/js/client.min.js"></script>
          <script src="https://js.braintreegateway.com/web/3.25.0/js/paypal-checkout.min.js"></script>
          <script>
          paypal.Button.render({
            //braintree: braintree,
            client: {
              production: '<?php echo $clientToken = $gateway->clientToken()->generate() ?>',
              sandbox: '<?php echo $clientToken = $gateway->clientToken()->generate() ?>'
            },
            env: 'sandbox',
            commit: true,
            payment: function (data, actions) {
              return actions.braintree.create({
                payment: {transactions: [{amount: { total: '0.01', currency: 'EUR' }}]}//test
              });
            },
            onAuthorize: function (payload) {
              return actions.payment.execute().then(function() {
                alert('Payment Complete!');
              });
            },
          }, '#paypal-button');
          </script>
          <div class="form-row">
            <button type="submit" class="btn btn-success mx-auto m-2" name="validecommande">Valider la commande</button>
          </div>
        </form>
      </div>
      <?php
    } else {
      header("Location: panier.php");
    }
    include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
