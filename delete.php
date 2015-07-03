<?php
if($_REQUEST['functionName'] == 'addel'){
	$id = $_REQUEST['inputvar'];
	mysqli_query("DELETE FROM `admins` WHERE `isAD` = $id");
}
?>
