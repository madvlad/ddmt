<?php
$path = "img/chesspieces";
$dirs = glob($path . '/*' , GLOB_ONLYDIR);
foreach($dirs as $value){
	echo("<option value='".basename($value)."'>".basename($value)."</option>");
}
?>
