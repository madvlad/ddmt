<?php
	$fname = $_GET["fileName"];
	$path = "img/imgStore/" . $fname;

	$fullpath = realpath($path);
	echo $fullpath;

	if(is_readable($fullpath))
	{

		unlink($fullpath);
	}
	else
	{
		echo "That file does not exist and I don't like what you're trying to do.";
	}
	header("Location: " . $_SERVER["HTTP_REFERER"]);


	echo "<br><br>Your browser should take you back automatically.<br>If not... <a href=\"javascript:history.go(-1)\">click here</a>.";
?>
