<?php

/**
 * Verifie si le panier existe, le créé sinon
 * @return booleen
 */
function creationPanier(){
   if (!isset($_SESSION['panier'])){
      $_SESSION['panier']=array();
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
function ajouterArticle($LibelleProduit,$quantiteProduit,$prixUnitaireHT){

   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Si le produit existe déjà on ajoute seulement la quantité
      $positionProduit = array_search($LibelleProduit,  $_SESSION['panier']['LibelleProduit']);

      if ($positionProduit !== false)
      {
         $_SESSION['panier']['quantiteProduit'][$positionProduit] += $quantiteProduit ;
      }
      else
      {
         //Sinon on ajoute le produit
         array_push( $_SESSION['panier']['LibelleProduit'],$LibelleProduit);
         array_push( $_SESSION['panier']['quantiteProduit'],$quantiteProduit);
         array_push( $_SESSION['panier']['prixUnitaireHT'],$prixUnitaireHT);
         // PDO
      }
   }
   else
   echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
}

/**
 * Modifie la quantité d'un article
 * @param $LibelleProduit
 * @param $quantiteProduit
 * @return void
 */
function modifierQTeArticle($LibelleProduit,$quantiteProduit){
   //Si le panier éxiste
   if (creationPanier() && !isVerrouille())
   {
      //Si la quantité est positive on modifie sinon on supprime l'article
      if ($quantiteProduit > 0)
      {
         //Recharche du produit dans le panier
         $positionProduit = array_search($LibelleProduit,  $_SESSION['panier']['LibelleProduit']);

         if ($positionProduit !== false)
         {
            $_SESSION['panier']['quantiteProduit'][$positionProduit] = $quantiteProduit ;
         }
      }
      else
      supprimerArticle($LibelleProduit);
   }
   else
   echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
}

/**
 * Supprime un article du panier
 * @param $LibelleProduit
 * @return unknown_type
 */
function supprimerArticle($LibelleProduit){
   //Si le panier existe
   if (creationPanier() && !isVerrouille())
   {
      //Nous allons passer par un panier temporaire
      $tmp=array();
      $tmp['LibelleProduit'] = array();
      $tmp['quantiteProduit'] = array();
      $tmp['prixUnitaireHT'] = array();
      $tmp['verrou'] = $_SESSION['panier']['verrou'];

      for($i = 0; $i < count($_SESSION['panier']['LibelleProduit']); $i++)
      {
         if ($_SESSION['panier']['LibelleProduit'][$i] !== $LibelleProduit)
         {
            array_push( $tmp['LibelleProduit'],$_SESSION['panier']['LibelleProduit'][$i]);
            array_push( $tmp['quantiteProduit'],$_SESSION['panier']['quantiteProduit'][$i]);
            array_push( $tmp['prixUnitaireHT'],$_SESSION['panier']['prixUnitaireHT'][$i]);
         }

      }
      //On remplace le panier en session par notre panier temporaire à jour
      $_SESSION['panier'] =  $tmp;
      //On efface notre panier temporaire
      unset($tmp);
   }
   else
   echo "Un problème est survenu, veuillez contacter l'administrateur du site.";
}


/**
 * Montant total du panier
 * @return int
 */
function MontantGlobal(){
   $total=0;
   for($i = 0; $i < count($_SESSION['panier']['LibelleProduit']); $i++)
   {
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
}

/**
 * Permet de savoir si le panier est verrouillé
 * @return booleen
 */
function isVerrouille(){
   if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
   return true;
   else
   return false;
}

/**
 * Compte le nombre d'articles différents dans le panier
 * @return int
 */
function compterArticles()
{
   if (isset($_SESSION['panier']))
   return count($_SESSION['panier']['LibelleProduit']);
   else
   return 0;

}

?>
