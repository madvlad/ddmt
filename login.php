<?php
$f = fopen("config.php",'r');
$line = fgets($f);
fclose($f);
if($line != "<?php\n"){
  header("location:install.php"); 
}

$con = null;
?>

<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css">
<script src="js/hide.js"></script>
<script src="js/lostPass.js"></script>
</head>
<body>
<div class="lrounder" id="hidround" onClick="showAdmin()"></div>
<div class="rrounder"></div>
<div class="clearbar"></div>
<div class = "container">
 <div class="container login">
<form action="loginUser.php" method="post" class="form-signin" id = "login_form" 
style="visibility:hidden;">
<h2 class="form-signin-heading">Admin Login</h2>
<input type="text" name="username" size="20" placeholder="Username">
<input type="password" name="password" size="20" placeholder="Password"></br>
<input type="submit" value="Log In" class="submitButton">
<button type="button" class="removalButton" onclick="uhOh();">Forgot Username/Password</button>
</form>
</div>
 <div class="container login">
<form action="loginTester.php" method="post" class="form-signin" id = "testlog_form" >

<input type="text" name="sessID" size="20" placeholder="1 2 3">
<input type="text" name="testID" size="20" placeholder="A B C"></br>
<input type="image" src="img/check.png" class="noTextSubmit" alt="Verify Test">
</form>
</div>
</div>
</body>
</html>

<?php

include("CloseSession.php");

?>
