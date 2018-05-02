<?php
session_start();

//connexion à la bdd
try {
  $bdd = new PDO('mysql:host=ppe2.ddns.net;dbname=ppe2', 'PPE', 'PPE123');
} catch (Exception $e) {
  echo 'Erreur de connexion à la bdd : '.$e->getMessage();
  die();
}
?>
