<?php
if(isset($_POST) && !empty($_POST)){

session_start();
include("config.php"); //including config.php in our file


  $username = mysqli_real_escape_string($con,stripslashes($_POST['username'])); //Storing username in $username variable.
$password = mysqli_real_escape_string($con,stripslashes($_POST['password'])); //Storing password in $password variable.

$match = "select adID, isAd from $admin where adName = '".$username."' and adPass = '".$password."';";
$nameMatch = "select adName from $admin where adName = '".$username."';";
$qry = mysqli_query($con,$match);
$qry2 = mysqli_query($con,$nameMatch);
$num_rows = mysqli_num_rows($qry);
$num_rows2 = mysqli_num_rows($qry2);
$obtain_results = mysqli_fetch_array($qry);


 if ($num_rows <= 0) { 
  if($num_rows2 > 0){
    $file = "js/returnNoPass.js";
  }
  else{
    $file = "js/returnToLogin.js";
   }
   echo '<html><head><script type="text/javascript" src="'.
   $file .'"></script>';
   echo'<link rel="stylesheet" type="text/css" href="css/lingStudy.css">';
   echo'</head><body></body></html>';
} else {

        $_SESSION['user']= $_POST["username"];
         $_SESSION['adr'] = $obtain_results[1];
         if($_SESSION['adr'] == 1){
            header("location:admin_home.php");
         }
         else{
            header("location:sess_log.php");
         }
    }



}
?>
