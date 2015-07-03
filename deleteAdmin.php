<?php
	include("config.php");
	$adID = $_POST['id'];
	$delq = "DELETE FROM $admin WHERE adID='$adID'";
	$res = mysqli_query($con,$delq);
   echo $adID;
?>
