<html>
<head>
<link rel="stylesheet" type="text/css" href="css/lingInstall.css">
</head>
<body>
<div class="backDiv">
<p class="regularText">Install Start</p>
<?php
//Variable setup
$db_user = $_POST['accname'];
$db_pass = $_POST['accpass'];
$peerKey = $_POST['peerJS'];
$adname = $_POST['adname'];
$adpass = $_POST['adpass'];
$admail = $_POST['admail'];
$database="lingStudyDB";
$server="localhost";
$admin="admins";
$tests="testers";
$games="testGame";
$takers="test_takers";
$templates="boardTemplates";
//Connect
$con=mysqli_connect($server,$db_user,$db_pass);
if(mysqli_connect_errno()){
  echo "<p>Failed to connect to the MySQL Install!  Install failed!  Please check your database username and password</p>";
}
else{
  echo"<p class='regularText'>Successfully connected to MySql Server</p>";
}
$creation = "CREATE DATABASE $database";
if(!mysqli_query($con,$creation)){
  echo "<p>Failed to create study database!  Install failed!  Please check with your system admin to ensure MySql is configured properly</p>";
  
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}
else{
  echo "<p class='regularText'>Study database successfully created.</p>";
}
$con=mysqli_connect($server,$db_user,$db_pass,$database);
$checker = true;

$q1 = "CREATE TABLE IF NOT EXISTS `admins` (
  `adID` int(11) NOT NULL,
  `adName` text NOT NULL,
  `adPass` text NOT NULL,
  `email` text NOT NULL,
  `isAd` tinyint(1) NOT NULL,
  PRIMARY KEY (`adID`)
)";

$q2 = "CREATE TABLE IF NOT EXISTS `testers` (
  `STID` int(11) NOT NULL,
  `sessID` int(11) NOT NULL,
  `trans` longtext NOT NULL,
  `conftext` longtext NOT NULL,
  `inSession` int(11) NOT NULL,
  `AFN` longtext NOT NULL,
  `hSU` int(11) NOT NULL,
  KEY `sessID` (`sessID`)
)";

$q3 = "CREATE TABLE IF NOT EXISTS `testGame` (
  `sessID` int(11) NOT NULL,
  `playerID` varchar(100) NOT NULL,
  `playerBoard` varchar(2048) DEFAULT NULL COMMENT 'JSON Stringified',
  `initBoard` varchar(2048) DEFAULT NULL,
  `theme` varchar(1028) NOT NULL,
  `grid` int(11) NOT NULL,
  `whiteBoxColor` varchar(2048) NOT NULL DEFAULT '#7EDAA1',
  `blackBoxColor` varchar(2048) NOT NULL DEFAULT '#7EDAA1',
  PRIMARY KEY (`playerID`,`sessID`),
  KEY `sessID` (`sessID`)
)";

$q4 = "CREATE TABLE IF NOT EXISTS `test_takers` (
  `testID` char(1) NOT NULL,
  `sessID` int(11) NOT NULL,
  `sessStat` int(11) NOT NULL,
  `isConfed` int(11) NOT NULL,
  `uAFN` longtext NOT NULL,
  `conftext` longtext NOT NULL,
  KEY `sessID` (`sessID`)
)";


$q5 = "ALTER TABLE `testGame`
  ADD CONSTRAINT `testGame_ibfk_1` FOREIGN KEY (`sessID`) REFERENCES `testers` (`sessID`) ON DELETE CASCADE ON UPDATE CASCADE;";

$q6 = "ALTER TABLE `test_takers`
  ADD CONSTRAINT `test_takers_ibfk_1` FOREIGN KEY (`sessID`) REFERENCES `testers` (`sessID`) ON DELETE CASCADE ON UPDATE CASCADE;";


$q7 = "CREATE TABLE IF NOT EXISTS `boardTemplates` (
  `templateName` varchar(80) NOT NULL,
  `initBoard` varchar(2048) NOT NULL,
  `theme` varchar(1028) NOT NULL,
  `grid` int(11) NOT NULL,
  `whiteBoxColor` varchar(2048) NOT NULL,
  `blackBoxColor` varchar(2048) NOT NULL,
  `surveyUrl` varchar(2048) NOT NULL,
  PRIMARY KEY (`templateName`)
)";

if(!mysqli_query($con,$q1)){
  echo "<p>Failed to create user table.  Install may have failed!  Please check with your system admin to ensure MySql is configured properly</p>";
  $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}


if(!mysqli_query($con,$q2)){
  echo "<p>Failed to create session table.  Install may have failed!  Please check with your system admin to ensure MySql is configured properly</p>";
  $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}

if(!mysqli_query($con,$q3)){
  echo "<p>Failed to create game table.  Install may have failed!  Please check with your system admin to ensure MySql is configured properly</p>";
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
  $checker = false;
}

if(!mysqli_query($con,$q4)){
  echo "<p>Failed to create tester table.  Install may have failed!  Please check with your system admin to ensure MySql is configured properly</p>";
 $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}

if(!mysqli_query($con,$q7)){
    echo "<p>Failed to create the board template table.  Install may have failed!  Please check with your system admin to ensure MySql is configured properly</p>";
 $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}


if(!mysqli_query($con,$q5)){
  echo "<p>Failed to create game foreign key!  Install failed!  Please check with your system admin to ensure MySql is configured properly</p>";
 $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}

if(!mysqli_query($con,$q6)){
  echo "<p>Failed to create tester foreign key!  Install failed!  Please check with your system admin to ensure MySql is configured properly</p>";
  $checker = false;
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}

if($checker == true){
  echo "<p class='regularText'>Database tables created successfully.</p>";
}

$q7 = "INSERT INTO `admins`(`adID`, `adName`, `adPass`, `email`, `isAd`) VALUES ('1', '$adname','$adpass','$admail','1');";

if(!mysqli_query($con,$q7)){
  echo "<p>Failed to create DDMT administrator!  Please use phpMyAdmin or some other database access to manually add the user to the system.</p>";
  echo "<p>Error code: " . mysqli_error($con) . "</p>";
}
else{
  echo "<p class='regularText'>DDMT admin user created successfully.</p>";
}

//File writing portion -> let us create our config.php!!
$thedir = getcwd();
$file = "$thedir/config.php";
$fp = fopen($file,'w');
if($fp == false){
	echo "<p>Could not open system config file $file!  Please, customize the default with your desired options on the server!</p>";
}
else{
  echo "<p class='regularText'>System config file $file created successfully.</p>";
}
$configFileData='$database="'. "$database" .'";'. " \n".' $server="localhost";'." \n".' $db_user="'
. "$db_user" . '";'." \n".' $db_pass="' . "$db_pass" . '";'." \n".' $admin="admins";'." \n".' $tests="testers";'." \n".''
. '$games="testGame";'." \n".' $takers="test_takers";'." \n".'$templates="boardTemplates";'." \n"
.' $peerJSKey="'."$peerKey".'";'." \n".''
. '$con=mysqli_connect($server,$db_user,$db_pass,$database);';
$final = "<?php \n" . "$configFileData" . "\n?>";

fwrite($fp, $final);
fclose($fp);



//Install oggz
$output = shell_exec("apt-get install oggz-tools");
if($output == 0){
  echo "<p>You must install Oggz command line tools. Please run the included install script on the server or get the tool from its website.</p>";
  echo "<a href='http://www.xiph.org/oggz/'> Oggz</a>";
}
else{
  echo "<p class='regularText'>Install of oggz command line tool successful!  This tool is used for audio recording.</p>";
}

?>
<p class="regularText">End of Install Procedure</p>
</div>
</body>
</html>
