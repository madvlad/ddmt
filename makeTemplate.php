<?php
   include('config.php');
   $sessID = $_POST['id'];
   $templateName = $_POST['template'];
   $board = "SELECT `initBoard`,`theme`,`grid`,`whiteBoxColor`,`blackBoxColor`,`surveyUrl`  FROM `testGame` WHERE `sessID` = $sessID;";
   echo $templateName;
   $res = mysqli_query($con,$board);
   $row = mysqli_fetch_row($res);
   $makeTemp = "INSERT INTO `boardTemplates` VALUES ('".$templateName."', '".$row[0]."', '".$row[1]."', '".$row[2]."', '".$row[3]."','".$row[4]."', '".$row[5]."');";
   $res2 = mysqli_query($con, $makeTemp);

?>

