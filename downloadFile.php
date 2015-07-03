<?php
	include("config.php");
	$sessID = $_GET['sess'];
	$query2 = "SELECT `trans` from `testers` WHERE `sessID` = '".$sessID."';";
	$res = mysqli_query($con, $query2);
	$fetch = mysqli_fetch_array($res);
	$text = $fetch[0];
	$fn = $sessID ."log.txt";
	header("Content-Disposition: attachment; filename=".$fn."");
	header("Content-Type: application/force-download");
	print $text;
//	header("Connection: close");
	include("CloseSession.php");	
?>
