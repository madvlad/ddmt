<?php
$database="lingStudyDB";
$server="localhost";
$db_user="max";
$db_pass="fish123";
$table="testGame";

$con=mysqli_connect($server,$db_user,$db_pass,$database);

$theBoard = json_decode(file_get_contents('php://input'), true);

$theBoardStr = implode("|",$theBoard);
$sessID = $_GET["sessID"];
$playerID = $_GET["testID"];


if(mysqli_connect_errno())
{
	echo "Failed to Connect to Database";
}

$query = "UPDATE `testGame` SET playerBoard = '$theBoardStr' WHERE `sessID` = '$sessID' and `playerID` = '$playerID';";

$query2 = "UPDATE `test_takers` SET sessStat = 2 WHERE `sessID` = '$sessID' and `testID` = '$playerID';";

$query3 = "SELECT `sessID` FROM `test_takers` WHERE `sessID` = '$sessID' and `sessStat` = 2;";

$query4 = "SELECT `sessID` FROM `test_takers` WHERE `sessID` = '$sessID';";

mysqli_query($con,$query2);
$q3 = mysqli_query($con,$query3);
$q4 = mysqli_query($con,$query4);

$nr1 = mysqli_num_rows($q3);
$nr2 = mysqli_num_rows($q4);


if($nr2 == $nr1){
  $query5 = "UPDATE `testers` SET `inSession` = 2 WHERE `sessID` = '$sessID';";
  mysqli_query($con,$query5);
}

//echo $query;

if (!mysqli_query($con, $query))
{
	die('Error: ' . mysqli_error($con));	
}

mysqli_close($con);
?>
