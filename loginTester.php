<?php
if(isset($_POST) && !empty($_POST))
{
session_start();
include("config.php");

$sessID = mysqli_real_escape_string($con,stripslashes($_POST['sessID']));
$testID = mysqli_real_escape_string($con,stripslashes($_POST['testID']));

$match2 = "select `STID`, `hSU` from $tests where sessID = '".$sessID."';";

$qry2 = mysqli_query($con,$match2);

$num_rows2 = mysqli_num_rows($qry2);
$res = mysqli_fetch_array($qry2);
if ($num_rows2 <= 0 || $res[1] == 0){
   header("location:login.php");
 }
    else{
        $_SESSION['sess'] = $_POST["sessID"];
        $_SESSION['test'] = $_POST["testID"];
        $sessCheck = $_POST["sessID"];
        $testCheck = $_POST["testID"];
        //Check to ensure that the tester hasn't finished the test
        $testqry = "SELECT `sessStat` FROM `test_takers` WHERE `sessID` = $sessCheck AND `testID` = '$testCheck';";
        $check = mysqli_query($con,$testqry);
        $res = mysqli_fetch_row($check);
          if($res[0] != 2){

            header("location:player.php?sessID=".$sessID."&testID=".$testID);
        }
        else{
          echo "Sorry, you have already tested!";
                                                      
   }
     }
}
?>
