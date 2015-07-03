<?php
	$allowedExts = array("gif", "png", "jpeg", "jpg");

	$path = "./img/chesspieces/" . $_GET["themeName"];

	if(file_exists($path)){
		// Make way for the new definition of the theme!

		$files = glob($path + "/*");

		foreach($files as $file){
			if(is_file($file)){
				unlink($file);
			}
		}

		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Content-Type: application/xml; charset=utf-8");
	}

	if(true){
		mkdir($path);
		copy($_GET["bB"], $path . "/bB.png");
		copy($_GET["bK"], $path . "/bK.png");
		copy($_GET["bN"], $path . "/bN.png");
		copy($_GET["bP"], $path . "/bP.png");
		copy($_GET["bQ"], $path . "/bQ.png");
		copy($_GET["bR"], $path . "/bR.png");
		copy($_GET["wB"], $path . "/wB.png");
		copy($_GET["wK"], $path . "/wK.png");
		copy($_GET["wN"], $path . "/wN.png");
		copy($_GET["wP"], $path . "/wP.png");
		copy($_GET["wQ"], $path . "/wQ.png");
		copy($_GET["wR"], $path . "/wR.png");

		header("Location: ".$_SERVER["HTTP_REFERER"]);

		// If a browser doesn't support this for some reason...

		echo "\nYour browser should take you back automatically.<br>If not... <a href=\"javascript:history.go(-1)\">click here</a>.";
	} else {
		echo "Error!! Your theme has not been saved because there already exists a theme with that name!";
		echo "\nYour browser should take you back automatically.<br>If not... <a href=\"javascript:history.go(-1)\">click here</a>.";
	}	
?>
