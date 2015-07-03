<?php
include('config.php');
$get = "SELECT `templateName` FROM `boardTemplates`";
$res = mysqli_query($con,$get);
while($value = mysqli_fetch_row($res)){
	echo("<option value='".$value[0]."'>".$value[0]."</option>");
}
?>
