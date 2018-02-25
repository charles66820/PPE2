<?php
session_start();

//connexion a la bdd
try {
  $bdd = new PDO('mysql:host=ppe2.ddns.net;dbname=ppe2', 'PPE', 'PPE123');
} catch (Exception $e) {
  echo 'Erreur de connexion a la bdd : '.$e;
}
?>
