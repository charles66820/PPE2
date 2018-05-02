<?php
$login = $_GET['log'];
$ = $_GET['cle'];

// Récupération de la clé correspondant au $login dans la base de données
$stmt = $dbh->prepare("SELECT cle,actif FROM client WHERE Speudo like :Speudo ");
if($stmt->execute(array(':Speudo' => $speudo)) && $row = $stmt->fetch())
{
  $clebdd = $row['cle'];	// Récupération de la clé
  $actif = $row['actif']; // $actif contiendra alors 0 ou 1
}


// On teste la valeur de la variable $actif récupérée dans la BDD
if($actif == '1') // Si le compte est déjà actif on prévient
{
  echo "Votre compte est déjà actif !";
}
else // Si ce n'est pas le cas on passe aux comparaisons
{
  if($cle == $clebdd) // On compare nos deux clés
  {
    // Si elles correspondent on active le compte !
    echo "Votre compte a bien été activé !";

    // La requête qui va passer notre champ actif de 0 à 1
    $stmt = $dbh->prepare("UPDATE client SET actif = 1 WHERE Speudo like :Speudo ");
    $stmt->bindParam(':Speudo', $speudo);
    $stmt->execute();
  }
  else // Si les deux clés sont différentes on provoque une erreur...
  {
    echo "Erreur ! Votre compte ne peut être activé...";
  }
?>
