<?php
function affichestar($avg){
  if ($avg == 0) {
    $result = "stars0";
  } elseif ($avg <= 0.5) {
    $result = "stars0_5";

  } elseif ($avg <= 1){
    $result = "stars1";

  } elseif ($avg <= 1.5) {
    $result = "stars1_5";

  } elseif ($avg <= 2) {
    $result = "stars2";

  } elseif ($avg <= 2.5) {
    $result = "stars2_5";

  } elseif ($avg <= 3) {
    $result = "stars3";

  } elseif ($avg <= 3.5) {
    $result = "stars3_5";

  } elseif ($avg <= 4) {
    $result = "stars4";

  } elseif ($avg <= 4.5) {
    $result = "stars4_5";

  }else {
    $result = "stars5";
  }
  return $result;
}
?>
