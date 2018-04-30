<?php
$header="Mime-Version: 1.0\r\n";
$header.='From:"PrimFX.com"<support@primfx.com>'."\n";
$header.='Content-Type:text/html; charset="utf-8"'."\n";
$header.='Content-Transfer-Encoding: 8bit';

$message='
<html>
  <body>
    <div align="centre".>
      J\'ai test !!!!!
      <br/>
    </div>
  </body>
</html>
';
mail("kevin.le.lurcat@gmail.com", "test", $message, $header);
 ?>
