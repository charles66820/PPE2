

<?php
function affichestar($avg){
  if ($avg == 0) {
    $result = "stars0";
  }
  if ($avg <= 0.5) {
    $result = "stars0_5";

  } else if ($avg <= 1){
    $result = "stars1";

  } else if ($avg <= 1.5) {
    $result = "stars1_5";

  } else if ($avg <= 2) {
    $result = "stars2";

  } else if ($avg <= 2.5) {
    $result = "stars2_5";

  } else if ($avg <= 3) {
    $result = "stars3";

  } else if ($avg <= 3.5) {
    $result = "stars3_5";

  } else if ($avg <= 4) {
    $result = "stars4";

  } else if ($avg <= 4.5) {
    $result = "stars4_5";

  }else {
    $result = "stars5";
  }
  return $result;
}
?>
