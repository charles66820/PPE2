<?php
//les variable
$categorie = '';
$type = '';
$stars = '';
$maxprice = '';
$search = '';
$urlcategorie = '';
$urltype = '';
$urlstars = '';
$urlmaxprice = '';
$urlsearch = '';

//récupére les valeur "Get" dans l'url
if(isset($_GET['categorie'])) {
  $categorie = $_GET['categorie'];
  $urlcategorie = "categorie=".$categorie;
}

if ( isset($_GET['type'])) {
  $type = $_GET['type'];
  $urltype ="type=".$type;
}

if ( isset($_GET['stars'])) {
  $stars = $_GET['stars'];
  $urlstars ="stars=".$stars;
}

if ( isset($_GET['maxprice'])) {
  $maxprice = $_GET['maxprice'];
  $urlmaxprice ="maxprice=".$maxprice;
}

if ( isset($_GET['search'])) {
  $search = $_GET['search'];
  $urlsearch ="search=".$search;
}

//génére un get url °~°
function genurl($ptype, $data){
  global $urlcategorie, $urltype, $urlstars, $urlmaxprice, $urlsearch;//défini localement les variable globales

  $returnurl = '';

  //démerde toi pour comprendre mdr
  //en sa péremet avec de la concaténation de générée le uri °~°
  if ($ptype == "nav") {
    $returnurl .= $data;
  }else {
     if (!empty($urlcategorie)) {
       $returnurl .= $urlcategorie;
     }
     if (!empty($urltype)) {
       if (!empty($returnurl)) {
         $returnurl .= "&".$urltype;
       }else {
         $returnurl .= $urltype;
       }
     }
  }
  if ($ptype == "stars") {
    if (!empty($returnurl)) {
      $returnurl .= "&".$data;
    }else {
      $returnurl .= $data;
    }
  }else {
    if (!empty($urlstars)) {
      if (!empty($returnurl)) {
        $returnurl .= "&".$urlstars;
      }else {
        $returnurl .= $urlstars;
      }
    }
  }
  if ($ptype == "price") {
    if (!empty($returnurl)) {
      $returnurl .= "&".$data;
    }else {
      $returnurl .= $data;
    }
  }else {
    if (!empty($urlmaxprice)) {
      if (!empty($returnurl)) {
        $returnurl .= "&".$urlmaxprice;
      }else {
        $returnurl .= $urlmaxprice;
      }
    }
  }
  if ($ptype == "search") {
    if (!empty($returnurl)) {
      $returnurl .= "&".$data;
    }else {
      $returnurl .= $data;
    }
  }else {
    if (!empty($urlsearch)) {
      if (!empty($returnurl)) {
        $returnurl .= "&".$urlsearch;
      }else {
        $returnurl .= $urlsearch;
      }
    }
  }
  return $returnurl;
}
?>
