<?php
require 'setting.bdd.php';

//test si l'utilisateur est connecter
if (isset($_SESSION['id'])) {
  if (isset($_POST['modifiecompte'])) {
    //remplie les variable avec les donner du form
    $newpseudo = !empty($_POST['newpseudo']) ? htmlspecialchars($_POST['newpseudo']) : null ;
    $newmail = !empty($_POST['newmail']) ? htmlspecialchars($_POST['newmail']) : null ;
    $newnom = !empty($_POST['newnom']) ? htmlspecialchars($_POST['newnom']) : null ;
    $newprenom = !empty($_POST['newprenom']) ? htmlspecialchars($_POST['newprenom']) : null ;
    $newcivilite = (!empty($_POST['newcivilite']) && strlen($_POST['newcivilite']) <= 60 ) ? htmlspecialchars($_POST['newcivilite']) : null ;
    $newtel = !empty($_POST['newtel']) ? htmlspecialchars($_POST['newtel']) : null ;
    $newmdp1 = (!empty($_POST['newmdp1']) && strlen($_POST['newmdp1']) <= 13 ) ? htmlspecialchars($_POST['newmdp1']) : null ;
    $newmdp2 = (!empty($_POST['newmdp2']) && strlen($_POST['newmdp2']) <= 13 ) ? htmlspecialchars($_POST['newmdp2']) : null ;
    if ($newpseudo == 'Admin' && $_SESSION['pseudo'] != 'Admin') {
      header('HTTP/1.1 500 Internal Server Error');
      print 'erreur vous de pouver pas être admin! :(';
      die();
    }
    //test si l'email n'est pas null
    if ($newmail != null) {
      //récupére les adresse email identique a celle dans le form
      $reqemail = $bdd->prepare("SELECT Email FROM client WHERE client.Email = ? AND client.IDClient <> ?");
      $reqemail->execute(array($newmail, $_SESSION['id']));
      //si l'adresse email n'ai pas utiliser alors on continue
      if ($reqemail->rowCount() == 0) {
        //teste la longuer des chaine
        if (strlen($_POST['newpseudo']) <= 20 ) {
          if (strlen($_POST['newnom']) <= 20) {
            if (strlen($_POST['newprenom']) <= 13) {
              if (strlen($_POST['newtel']) <= 13) {
                //test si il faut changer le mdp
                if ($newmdp1 != '' && $newmdp1 != null) {
                  //test si le mots de passe est le mots de passe de confirmation sont identique
                  if ($newmdp1 == $newmdp2) {
                    //modifie l'utilisateur ainsi que sont mdp
                    $requpdateuser = $bdd->prepare("UPDATE client SET client.Pseudo = ?, client.Email = ?, client.MotDePasse = ?, client.Nom = ?, client.Prenom = ?, client.Civilite = ?, client.Telephone = ? WHERE client.IDClient = ?");
                    $requpdateuser->execute(array($newpseudo, $newmail, sha1($newmdp1), $newnom, $newprenom, $newcivilite, $newtel, $_SESSION['id']));
                    $msg = "Profil sauvegarder et mots de passe changer";
                  } else {
                    $msg = "Le mots de passe et le mots de passe de confirmation doive être identique";
                  }
                }else {
                  //modifie l'utisilateur
                  $requpdateuser = $bdd->prepare("UPDATE client SET client.Pseudo = ?, client.Email = ?, client.Nom = ?, client.Prenom = ?, client.Civilite = ?, client.Telephone = ? WHERE client.IDClient = ?");
                  $requpdateuser->execute(array($newpseudo, $newmail, $newnom, $newprenom, $newcivilite, $newtel, $_SESSION['id']));
                  $msg = "Profil sauvegarder";
                }
                //test si il faut changer l'image ou non
                if (!empty($_FILES['avatar-file']['name'])) {
                  //récupére le nom de l'image actuelle
                  $reqavatar = $bdd->prepare("SELECT client.AvatarUrl FROM client WHERE client.IDClient = ?");
                  $reqavatar->execute(array($_SESSION['id']));

                  $avatar = $reqavatar->fetch()['AvatarUrl'];
                  if (!empty($avatar)) {
                    //supprime l'image
                    @unlink("../assets/img/imagesupload/".$avatar);
                  }

                  $path = "../img/imagesupload/";
                  $name = basename($_FILES['avatar-file']["name"]);
                  $actual_name = pathinfo($name,PATHINFO_FILENAME);
                  $extension = pathinfo($name, PATHINFO_EXTENSION);
                  $imageFileType = strtolower($extension);
                  $uploadOk = 1;
                  $causeerreur = 'inconnue';

                  $i = 1;
                  while(file_exists($path.$actual_name.".".$extension)){
                    $actual_name = (string)$actual_name.$i;
                    $name = $actual_name.".".$extension;
                    $i++;
                  }

                  if ($_FILES['avatar-file']["size"] > 5000000) {
                    $uploadOk = 0;
                    $causeerreur = 'image trop lourde';
                  }

                  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "ico") {
                    $uploadOk = 0;
                    $causeerreur = 'ce fichier n\'est pas une image';
                  }

                  if ($uploadOk && @move_uploaded_file($_FILES['avatar-file']["tmp_name"], $path.$name)) {
                    $requpdateavatar = $bdd->prepare("UPDATE client SET client.AvatarUrl = ? WHERE client.IDClient = ?");
                    $requpdateavatar->execute(array($name, $_SESSION['id']));
                    $msg .= "Et l'avatar a bien êtait modifier";
                  } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    print $causeerreur;
                    die();
                  }
                }
              }else {
                $msg = "Le numéro de téléphone ne dois pas faire plus de 13 character de longue!";
              }
            }else {
              $msg = "Le prénom ne dois pas faire plus de 50 character de longue!";
            }
          } else {
            $msg = "Le nom ne dois pas faire plus de 50 character de longue!";
          }
        }else {
          $msg = "Le Pseudo ne dois pas faire plus de 20 character de longue!";
        }
      } else {
        $msg = "L'adresse email est déjà utiliser.";
      }
    } else {
      $msg = "l'adressee email ne peut pas étre nue est ne dois pas faire plus de 60 character de longue!";
    }
    echo $msg;
  }
  if (isset($_POST['Token'])) {
    $reqtoken = $bdd->prepare("SELECT * FROM client WHERE client.Token = ? AND client.IDClient = ?");
    $reqtoken->execute(array($_POST['Token'], $_SESSION['id']));
    if ($reqtoken->rowCount() == 1) {
      $reqsetactif = $bdd->prepare("UPDATE client SET client.Actif = 1 WHERE client.IDClient = ?");
      $reqsetactif->execute(array($_SESSION['id']));
    } else {
      $msg = 'mauvais token :(';
    }
    echo $msg;
  }
  if (isset($_POST['addadresse'])) {
    $adresse = !empty($_POST['adresse']) ? htmlspecialchars($_POST['adresse']) : null ;
    $Complement = !empty($_POST['Complement']) ? htmlspecialchars($_POST['Complement']) : null ;
    $CodePostal = !empty($_POST['CodePostal']) ? htmlspecialchars($_POST['CodePostal']) : null ;
    $Ville = !empty($_POST['Ville']) ? htmlspecialchars($_POST['Ville']) : null ;
    $Pays = !empty($_POST['Pays']) ? htmlspecialchars($_POST['Pays']) : null ;

    if (strlen($_POST['adresse']) <= 100 && $_POST['adresse'] != null) {
      if (strlen($_POST['Complement']) <= 100) {
        if (strlen($_POST['CodePostal']) <= 10 && $_POST['CodePostal'] != null) {
          if (strlen($_POST['Ville']) <= 50 && $_POST['Ville'] != null) {
            if (strlen($_POST['Pays']) <= 50 && $_POST['Pays'] != null) {
              $bdd->prepare("INSERT INTO adresse(Voie, Complement, CodePostal, Ville, Pays, IDClient) VALUES (?, ?, ?, ?, ?, ?)")->execute(array($adresse, $Complement, $CodePostal, $Ville, $Pays, $_SESSION['id']));
              $msg = "nouvelle adresse ajouter";
            } else {
              $msg = "Le Pays ne dois pas être vide et ne dois pas faire plus de 50 character de longue!";
            }
          } else {
            $msg = "La ville ne dois pas être vide et ne dois pas faire plus de 50 character de longue!";
          }
        } else {
          $msg = "Le code postal ne dois pas être vide et ne dois pas faire plus de 10 character de longue!";
        }
      } else {
        $msg = "Le complement adresse ne dois pas faire plus de 100 character de longue!";
      }
    } else {
      $msg = "L'adresse ne dois pas être vide et ne dois pas faire plus de 100 character de longue!";
    }
    echo $msg;
  }

  if (isset($_POST['adressevalue']) && !empty($_POST['adressevalue'])) {
    $bdd->prepare("DELETE FROM adresse WHERE IDAdresse = ? AND IDClient = ?")->execute(array(htmlspecialchars($_POST['adressevalue']), $_SESSION['id']));
    $msg = 'adresse supprimer avec succés';
    echo $msg;
  }

  if (isset($_POST['defaultaddress'])) {
    //select l'adresse par raport au client pour s'assurée que l'addresse apartien au client
    $reqselectadresse = $bdd->prepare("SELECT * FROM adresse WHERE adresse.IDAdresse = ? AND adresse.IDClient = ?");
    $reqselectadresse->execute(array(htmlspecialchars($_POST['idadresse']), $_SESSION['id']));
    if ($reqselectadresse->rowCount() == 1) {
      $bdd->prepare("UPDATE client SET iddefaultadresse = ? WHERE IDClient = ?")->execute(array(htmlspecialchars($_POST['idadresse']), $_SESSION['id']));
    }
  }
}
?>
