<?php

/**
* Verifie si le panier existe, le créé sinon
* @return booleen
*/
function creationPanier(){
  if (!isset($_SESSION['panier'])){
    $_SESSION['panier']=array();
    $_SESSION['panier']['idproduit'] = array();
    $_SESSION['panier']['LibelleProduit'] = array();
    $_SESSION['panier']['quantiteProduit'] = array();
    $_SESSION['panier']['prixUnitaireHT'] = array();
    $_SESSION['panier']['verrou'] = false;
  }
  return true;
}


/**
* Ajoute un article dans le panier
* @param string $libelleProduit
* @param int $qteProduit
* @param float $prixProduit
* @return void
*/
function ajouterArticle($idProduit, $quantiteProduit) {
  global $bdd;
  //recupération dans la bdd grace a l'id
  $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE produits.IDProduit = ?");
  $reqproduit->execute(array($idProduit));
  $repproduit = $reqproduit->fetch();
  $LibelleProduit = $repproduit['LibelleProduit'];
  $prixUnitaireHT = $repproduit['PrixUnitaireHT'];
  if ($repproduit['QuantiteProduit'] <= 0 || $quantiteProduit > $repproduit['QuantiteProduit']) {
    return false;
  } else {

    //Si le panier existe
    if (creationPanier() && !isVerrouille()) {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($idProduit, $_SESSION['panier']['idproduit']);

      if ($positionProduit !== false) {
        if ($_SESSION['panier']['quantiteProduit'][$positionProduit] + $quantiteProduit <= $repproduit['QuantiteProduit']) {
          $_SESSION['panier']['quantiteProduit'][$positionProduit] += $quantiteProduit;
        } else {
          $_SESSION['panier']['quantiteProduit'][$positionProduit] = $quantiteProduit;
        }
      } else {
        //Sinon on ajoute le produit
        array_push( $_SESSION['panier']['idproduit'],$idProduit);
        array_push( $_SESSION['panier']['LibelleProduit'],$LibelleProduit);
        array_push( $_SESSION['panier']['quantiteProduit'],$quantiteProduit);
        array_push( $_SESSION['panier']['prixUnitaireHT'],$prixUnitaireHT);
        // PDO insert in bdd
      }
      return true;
    } else {
      echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
      return false;
    }
  }
}

/**
* Modifie la quantité d'un article
* @param $LibelleProduit
* @param $quantiteProduit
* @return void
*/
function modifierQTeArticle($idProduit, $quantiteProduit){
  global $bdd;
  //recupération dans la bdd grace a l'id
  $reqproduit = $bdd->prepare("SELECT * FROM produits WHERE produits.IDProduit = ?");
  $reqproduit->execute(array($idProduit));
  $repproduit = $reqproduit->fetch();

  //Si le panier éxiste
  if (creationPanier() && !isVerrouille()) {
    //Si la quantité est positive on modifie sinon on supprime l'article
    if ($quantiteProduit > 0) {
      if ($quantiteProduit <= $repproduit['QuantiteProduit']) {
        //Recharche du produit dans le panier
        $positionProduit = array_search($idProduit, $_SESSION['panier']['idproduit']);

        if ($positionProduit !== false) {
          $_SESSION['panier']['quantiteProduit'][$positionProduit] = $quantiteProduit ;
          //pdo
        }
      }
    } else {
      supprimerArticle($idProduit);
    }
  } else {
    echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
  }
}

/**
* Supprime un article du panier
* @param $LibelleProduit
* @return unknown_type
*/
function supprimerArticle($idProduit){
  //Si le panier existe
  if (creationPanier() && !isVerrouille()) {
    //Nous allons passer par un panier temporaire
    $tmp = array();
    $tmp['idproduit'] = array();
    $tmp['LibelleProduit'] = array();
    $tmp['quantiteProduit'] = array();
    $tmp['prixUnitaireHT'] = array();
    $tmp['verrou'] = $_SESSION['panier']['verrou'];

    for($i = 0; $i < count($_SESSION['panier']['idproduit']); $i++) {
      if ($_SESSION['panier']['idproduit'][$i] !== $idProduit) {
        array_push( $tmp['idproduit'],$_SESSION['panier']['idproduit'][$i]);
        array_push( $tmp['LibelleProduit'],$_SESSION['panier']['LibelleProduit'][$i]);
        array_push( $tmp['quantiteProduit'],$_SESSION['panier']['quantiteProduit'][$i]);
        array_push( $tmp['prixUnitaireHT'],$_SESSION['panier']['prixUnitaireHT'][$i]);
      }
    }
    //On remplace le panier en session par notre panier temporaire à jour
    $_SESSION['panier'] =  $tmp;
    //On efface notre panier temporaire
    unset($tmp);
    //pdo remove all panier ligne du client avec l'idProduit = $idProduit
  } else {
    echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
  }
}

/**
* Montant total du panier
* @return int
*/
function MontantGlobal(){
  $total=0;
  for($i = 0; $i < count($_SESSION['panier']['idproduit']); $i++) {
    $total += $_SESSION['panier']['quantiteProduit'][$i] * $_SESSION['panier']['prixUnitaireHT'][$i];
  }
  return $total;
}


/**
* Fonction de suppression du panier
* @return void
*/
function supprimePanier(){
  unset($_SESSION['panier']);
  //pdo supprimer toute les ligne panier du client
}

/**
* Permet de savoir si le panier est verrouillé
* @return booleen
*/
function isVerrouille(){
  if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou']) {
    return true;
  } else {
    return false;
  }
}

/**
* Compte le nombre d'articles différents dans le panier
* @return int
*/
function compterArticles() {
  if (isset($_SESSION['panier'])) {
    return count($_SESSION['panier']['idproduit']);
  } else {
    return 0;
  }
}
?>
