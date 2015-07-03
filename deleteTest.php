<?php
	include('config.php');
	$sessID = $_POST['sessID'];
	$delq = "DELETE FROM `testers` WHERE sessID='$sessID'";
	echo $sessID;
   $res = mysqli_query($con,$delq);
	$dirPath = "audioDir/".$sessID;
	
	system("rm -rf ".$dirPath);
?>
