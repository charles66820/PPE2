
<?php

// TODO: vérifie si l'utilisateur a le droit de supprimer l'image


//récupère
if (isset($_POST['delImgJSON'])) {
   $lDelImg = json_decode($_POST['delImgJSON'], true);

  foreach ($lDelImg as $img) {
    @unlink("../img/imagesupload/".$img);
  }
}
?>
