<?php
include("sessionGuard.php");
include("config.php");
if(!empty($_POST['sessid'])){
$sessID = mysqli_real_escape_string($con,stripslashes($_POST['sessid']));
$number = mysqli_real_escape_string($con,stripslashes($_POST['numberOf']));
$theme = mysqli_real_escape_string($con,stripslashes($_POST['themeOf']));
$wBox = mysqli_real_escape_string($con,stripslashes($_POST['whiteBoxColor']));
$bBox = mysqli_real_escape_string($con,stripslashes($_POST['blackBoxColor']));
$surveyUrl = mysqli_real_escape_string($con,stripslashes($_POST['surveyUrl']));
$confeds = mysqli_real_escape_string($con,stripslashes($_POST['confeds']));
$conscriA = mysqli_real_escape_string($con, stripslashes($_POST['confedtextA']));
$conscriB = mysqli_real_escape_string($con, stripslashes($_POST['confedtextB']));
$conscriC = mysqli_real_escape_string($con, stripslashes($_POST['confedtextC']));
$conscriD = mysqli_real_escape_string($con, stripslashes($_POST['confedtextD']));
$conscriE = mysqli_real_escape_string($con, stripslashes($_POST['confedtextE']));

$tempName = mysqli_real_escape_string($con,stripslashes($_POST['templateOf']));

if (isset($_POST['grid'])) {
	$grid = 1;
} else {
	$grid = 0;
}


$setBoard = false;
/* Vaguely meh  way to handle things - if the template is set, overwrite blank/other board settings with the template settings */

if(isset($_POST['useTemplate'])){
  $tQ = "SELECT * FROM `boardTemplates` WHERE `templateName` = '" .$tempName. "'";
  $res = mysqli_query($con,$tQ);
  $setBoard = true;
  $row = mysqli_fetch_row($res);
  $theme = $row[2];
  $grid = $row[3];
  $wBox = $row[4];
  $bBox = $row[5];
  $surveyUrl = $row[6];
}

/*
	This file is honestly atrocious. We should clean it up some time before the next version. Updating these to fit with any DB changes is soul crushing and scary.
			- David 5/22/2014
*/

$check = "SELECT * from `".$tests."` where sessID = '".$sessID."'";
$num_rows = mysqli_num_rows(mysqli_query($con,$check));

$idq = "SELECT STID FROM `".$tests."` ORDER BY STID DESC LIMIT 1";
$idh = mysqli_query($con,$idq);
$max_id = mysqli_fetch_row($idh);
$id = $max_id[0] + 1;

if($num_rows > 0){
	echo("Session already exists!");
}
else{
	mysqli_query($con,"INSERT INTO `".$tests."` (`STID`, `sessID`,`conftext`) VALUES ('".$id."', '".$sessID."', '".$confeds."')") or die (mysql_error());
	switch($number){
		case 6:
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'F'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'F'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
		case 5:
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'E'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'E'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
		case 4:
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'D'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'D'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
		case 3:
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'C'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'C'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
		case 2:
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'A'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$takers."` (`sessID`,`testID`) VALUES ('".$sessID."','".'B'."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'A'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
			mysqli_query($con,"INSERT INTO `".$games."` (`sessID`,`playerID`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`) VALUES ('".$sessID."','".'B'."','".$theme."','".$grid."','".$wBox."','".$bBox."','".$surveyUrl."')") or die (mysqli_error());
			break;
}

}

  switch($confeds){

  case 5:
     mysqli_query($con,"UPDATE `".$takers."` SET `isConfed` = 1 WHERE `sessID` = '".$sessID."' AND `testID` IN ('A','B','C','D','E')");
    break;
  case 4:
     mysqli_query($con,"UPDATE `".$takers."` SET `isConfed` = 1 WHERE `sessID` = '".$sessID."' AND `testID` IN ('A','B','C','D')");
    break;
  case 3:
     mysqli_query($con,"UPDATE `".$takers."` SET `isConfed` = 1 WHERE `sessID` = '".$sessID."' AND `testID` IN ('A','B','C')");
    break;
  case 2:
    mysqli_query($con,"UPDATE `".$takers."` SET `isConfed` = 1 WHERE `sessID` = '".$sessID."' AND `testID` IN ('A','B')");
   break;
  case 1:
     mysqli_query($con,"UPDATE `".$takers."` SET `isConfed` = 1 WHERE `sessID` = '".$sessID."' AND `testID` IN ('A')");
    break;
  }

  switch($confeds){
    case 5:
      mysqli_query($con, "UPDATE `".$takers."` SET `conftext` = '".$conscriE."' WHERE `sessID` ='".$sessID."' AND `testID` = 'E'");
    case 4:
      mysqli_query($con, "UPDATE `".$takers."` SET `conftext` = '".$conscriD."' WHERE `sessID` ='".$sessID."' AND `testID` = 'D'");
   case 3:
      mysqli_query($con, "UPDATE `".$takers."` SET `conftext` = '".$conscriC."' WHERE `sessID` ='".$sessID."' AND `testID` = 'C'");
    case 2:
      mysqli_query($con, "UPDATE `".$takers."` SET `conftext` = '".$conscriB."' WHERE `sessID` ='".$sessID."' AND `testID` = 'B'");
    case 1:
      mysqli_query($con, "UPDATE `".$takers."` SET `conftext` = '".$conscriA."' WHERE `sessID` ='".$sessID."' AND `testID` = 'A'");
  }

}

/* If template, set board */
if(isset($setBoard)){
if($setBoard == true){
  $boardQ = "UPDATE `".$games."` SET `initBoard` = '".$row[1]."' WHERE `sessID` = '".$sessID."';";
  $fixup = mysqli_query($con,$boardQ);
  $sessQ = "UPDATE `".$tests."` SET `hSU` = '1' WHERE `sessID` = '".$sessID."';";
  $fixup2 = mysqli_query($con,$sessQ);
}
}


?>
