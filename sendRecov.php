<?php

$email = $_GET["email"];
$user = "Temp";
$message = "Hello $user,\r\nPlease go to the following link in order to reset your password for the DDMT.\r\n"
. "If you did not request this email, ignore it.\r\n";
mail($email,'DDMT Password Reset', $message);
?>
