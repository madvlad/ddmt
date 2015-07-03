<?php
	include('config.php');
	$temp = $_POST['name'];
	$delq = "DELETE FROM `boardTemplates` WHERE templateName='$temp'";
	echo $temp;
   $res = mysqli_query($con,$delq);
?>
