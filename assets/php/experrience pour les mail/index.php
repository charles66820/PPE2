<?php
$message = "j'enoie un message";

$message = wordwrap($message, 70, "\r\n");

mail('kevin.le.lurcat@gmail.com', 'Mon Sujet', $message);

?>
