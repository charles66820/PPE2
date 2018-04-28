<?php
include("assets/php/setting.bdd.php");
include("assets/php/fonctions-panier.php");

$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récuperation des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:null )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;

   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$l);
   //On verifie que $p soit un float
   $p = floatval($p);

   //On traite $q qui peut être un entier simple ou un tableau d'entiers

   if (is_array($q)){
      $quantiteArticle = array();
      $i=0;
      foreach ($q as $contenu){
         $quantiteArticle[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);

}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($l,$q,$p);
         break;

      Case "suppression":
         supprimerArticle($l);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($quantiteArticle) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['LibelleProduit'][$i],round($QteArticle[$i]));
         }
         break;

      Default:
         break;
   }
} ?>

<!DOCTYPE html>
<html>
<head>
<title>Votre panier</title>
<?php include 'assets/php/allcss.php'; ?>
</head>
<body>

<form method="post" action="panier.php">
<table style="width: 400px">
	<tr>
		<td colspan="4">Votre panier</td>
	</tr>
	<tr>
		<td>Libellé</td>
		<td>Quantité</td>
		<td>Prix Unitaire</td>
		<td>Action</td>
	</tr>


	<?php
	if (creationPanier())
	{
	   $nbArticles=count($_SESSION['panier']['LibelleProduit']);
	   if ($nbArticles <= 0)
	   echo "<tr><td>Votre panier est vide </ td></tr>";
	   else
	   {
	      for ($i=0 ;$i < $nbArticles ; $i++)
	      {
	         echo "<tr>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['LibelleProduit'][$i])."</ td>";
	         echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['quantiteProduit'][$i])."\"/></td>";
	         echo "<td>".htmlspecialchars($_SESSION['panier']['prixUnitaireHT'][$i])."</td>";
	         echo "<td><a href=\"".htmlspecialchars("panier.php?action=suppression&l=".rawurlencode($_SESSION['panier']['LibelleProduit'][$i]))."\">XX</a></td>";
	         echo "</tr>";
	      }

	      echo "<tr><td colspan=\"2\"> </td>";
	      echo "<td colspan=\"2\">";
	      echo "Total : ".MontantGlobal();
	      echo "</td></tr>";

	      echo "<tr><td colspan=\"4\">";
	      echo "<input type=\"submit\" value=\"Rafraichir\"/>";
	      echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

	      echo "</td></tr>";
	   }
	}
	?>
</table>
</form>
    <div class="container">
        <div class="row">
            <div class="col" style="width:59px;"><label class="col-form-label" style="width:80px;height:67px;">Nom</label></div>
            <div class="col"><label class="col-form-label">Prix</label></div>
            <div class="col" style="width:98px;"><label class="col-form-label">Quantité</label></div>
            <div class="col"><button class="btn btn-primary" type="button">-</button><button class="btn btn-primary" type="button">+</button></div>
        </div>
        <div class="row">
            <div class="col" style="width:59px;"><label class="col-form-label" style="width:80px;height:67px;">&nbsp;Nom (en stock ou pas)&nbsp;</label></div>
            <div class="col"><label class="col-form-label">Prix</label></div>
            <div class="col" style="width:98px;"><label class="col-form-label">Quantité</label></div>
            <div class="col"><button class="btn btn-primary" type="button">-</button><button class="btn btn-primary" type="button">+</button></div>
        </div><button class="btn btn-primary float-right" type="button">Valider</button></div><label>Sous-total (nre d'article) :</label><label>&nbsp;Prix total (...€) :</label>
        <script src="/assets/js/jquery-3.3.1.min.js"></script>
        <script src="/assets/js/bootstrap.bundle.min.js"></script>
        <script src="/assets/js/BSanimation.js"></script>
</body>
</html>
