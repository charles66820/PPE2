<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <title>Commandes</title>
      <?php include 'assets/php/allcss.php'; ?>
      <style>
      div#connexion {
        margin-left: 450px;
      }
      </style>
  </head>
  <body>
    <?php include 'assets/php/nav.php';
    //vérifie si on est connecté
    if (isset($_SESSION['id'])) {
      //vérification du droit d'accès car l'admin voit TOUTES les commandes
      if (isset($_SESSION['pseudo']) == 'Admin') { ?>

    <div class="container">
      <h2>Commandes :</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID Commande</th>
            <th>Date de la commande</th>
            <th>Total HT</th>
            <th>Total TVA</th>
            <th>Frais de port TTC</th>
            <th>Frais de port HT</th>
            <th>ID Client</th>
            <th>Adresse de facturation</th>
          </tr>

    <?php
        $reqcommande = $bdd->prepare("SELECT * FROM commande, produits WHERE commande.IDProduit = produits.IDProduit");
        $reqcommande->execute();
        $dbrep = $reqcommande->fetchAll();
        foreach ($dbrep as $row){
          echo "<tr>";
          echo "<td>".$row['IDCommande']."</td>"; //Affiche dans la colonne les infos de la bdd
          echo "<td>".$row['DateCommande']."</td>";
          echo "<td>".$row['TotalHT']."</td>";
          echo "<td>".$row['TotalTVA']."</td>";
          echo "<td>".$row['FraisPortTTC']."</td>";
          echo "<td>".$row['FraisPortHT']."</td>";
          echo "<td>".$row['IDClient']."</td>";
          echo "<td>".$row['IDAdresseFacturation']."</td>";
          echo "<td>".$row['IDAdresseLivraison']."</td>";
          echo "</tr>";
        }
        ?>
      </thead>
    </table>
  </div>

<?php } else { // si pas admin alors on ne voit que sa propre commande ?>
  <div class="container">
    <h2>Vos commandes :</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Date de la commande</th>
          <th>Total TVA</th>
          <th>Frais de port TTC</th>
          <th>ID Client</th>
          <th>Adresse de facturation</th>
          <th>Adresse de livraison</th>
          <th>Produit</th>
          <th>Prix unitaire HT</th>
        </tr>
        <?php
        $reqcommande = $bdd->prepare("SELECT DateCommande, TotalTVA, FraisPortTTC, IDClient, IDAdresseFacturation, IDAdresseLivraison, LibelleProduit, PrixUnitaireHT FROM commande, produits WHERE commande.IDProduit = produits.IDProduit AND IDClient = ?");
        $reqcommande->execute(array($_SESSION['id']));
        $dbrep = $reqcommande->fetchAll();
        foreach ($dbrep as $row){
          echo "<tr>";
          echo "<td>".$row['DateCommande']."</td>";
          echo "<td>".$row['TotalTVA']."</td>";
          echo "<td>".$row['FraisPortTTC']."</td>";
          echo "<td>".$row['IDClient']."</td>";
          echo "<td>".$row['IDAdresseFacturation']."</td>";
          echo "<td>".$row['IDAdresseLivraison']."</td>";
          echo "<td>".$row['LibelleProduit']."</td>";
          echo "<td>".$row['PrixUnitaireHT']."</td>";
          echo "</tr>";
        }
      }
    } else { ?>
      <div id="connexion">
        <?php echo "Vous devez être connecté pour accéder à vos commandes !"; ?><br/>
      <a href="connexion.php"><br />Clique ici pour te connecter 🐙</a>
      </div>
    <?php }
    ?>
  </thead>
</table>
</div>

    <?php include 'assets/php/footer.php'; ?>
    <script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/BSanimation.js"></script>
  </body>
</html>
