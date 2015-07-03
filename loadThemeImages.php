<?php
	$themeName = $_POST["themeName"];

	$imageDir = "img/chesspieces/".$themeName."/";

	$images = glob($imageDir."*.png");

	echo json_encode($images);
?>
