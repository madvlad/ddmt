<html>
<head>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="js/installJS.js"></script>
<title>Install DDMT</title>
</head>
<body>
<div class="lrounder"></div>
<div class="rrounder"></div>
<div class="clearbar"></div>
<div class="installDiv">
<form method="post" class="installForm" action="installScript.php">
<h1>Director-Matcher Task Toolkit Install</h1>
<hr>
<h2>Database Credentials</h2>
<hr>
<h4>Database Account Name  <input type="text" name="accname" class="installIn"></h4>
<h4>Database Account Password  <input type="password" name="accpass" id="ap" class="installIn"></h4>
<h4>Password Confirmation  <input type="password" name="accpasscon" id="apc" class="installIn"></h4>
<hr>
<h2>DDMT Set Up</h2>
<hr>
<h4>DDMT Admin Name  <input type="text" name="adname" class="installIn"></h4>
<h4>DDMT Admin Password  <input type="password" name="adpass" id = "adp" class="installIn"></h4>
<h4>DDMT Password Confirmation  <input type="password" name="adpasscon" id="adpc" class="installIn"></h4>
<h4>DDMT Admin Email  <input type="email" name="admail" class="installIn"></h4>
<h4>PeerJS Key  <input type="text" name="peerJS" class="installIn"></h4>
<button type="submit" class="submitButtonCenter" id="installSystem">Install System</button>
</form>
</div>
</body>
</html>
