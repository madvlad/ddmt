<?php
include("config.php");

$homedir = getcwd();
  foreach(array('audio') as $type){
      if(isset($_FILES["${type}-blob"])){
          $fileName = $_POST["${type}-filename"];
          $sessDir = $_POST["${type}-sessID"];
          mkdir("audioDir/$sessDir");
          $uploadDirectory = "audioDir/$sessDir/$fileName";
          $sess = $_POST['sid'];
          $use = $_POST['uid'];
          if (!move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $uploadDirectory)) {
            echo("problem moving uploaded file");
          }
          mysqli_query($con, "UPDATE `test_takers` SET `uAFN` = '".$fileName."' WHERE `sessID` ='".$sess."' AND `testID` ='".$use."'");
      }
   }
chdir("audioDir");
exec("bash audioLoop.sh $sessDir");
chdir($homedir);
?>

