<?php
session_start();

//connexion à la bdd
try {
  $bdd = new PDO('mysql:host=127.0.0.1;dbname=ppe2', 'root', '123456');
} catch (Exception $e) {
  echo 'Erreur de connexion à la bdd : '.$e->getMessage();
  die();
}
?>
