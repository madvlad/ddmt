<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="js/recovery.js"></script>
</head>
<body>
<div class="lrounder" id="hidround" onClick="showAdmin()"></div>
<div class="rrounder"></div>
<div class="clearbar"></div>
<div class = "container">
<form class="form-recovery" id="recoveryEmail" action='sendRecov.php'>
Please enter the email associated with your account: <input type="text" id="recemail" name="email">
<button type="button" class="submitButton" onclick = "shootOutEmail();">Recover Account</button>
</form>
</div>
</body>
</html>

<?php

include("CloseSession.php");

?>
