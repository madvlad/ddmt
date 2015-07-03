<?php
include('config.php');
	$sess_ID = $_GET['sess'];
	$text = $_GET['trans'];
	$query = "UPDATE `testers` SET `trans` = '".$text."' WHERE `sessID` = '".$sess_ID."'";
	mysqli_query($con, $query);
include('CloseSession.php');
header("location:review.php?sessID=".$sess_ID);
?>
