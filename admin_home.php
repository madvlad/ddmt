<?php
include("sessionGuard.php");
include("config.php");
//Redirect in the event a transcribe is where they should not be.
include("redirectTranscriber.php");
if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
// Now checking user name and password is entered or not.
$username = mysqli_real_escape_string($con,stripslashes($_POST['username']));
$password = mysqli_real_escape_string($con,stripslashes($_POST['password']));
$mail = mysqli_real_escape_string($con,$_POST['email']);
if($_POST['admin'] == 'Yes'){
  $adminCheck = true;
}
else{
  $adminCheck = false;
}
$check = "SELECT * from `".$admin."` where adName = '".$username."'";
$idq = "SELECT adID FROM `".$admin."` ORDER BY adID DESC LIMIT 1";
$idh = mysqli_query($con,$idq);
$max_id = mysqli_fetch_row($idh);
$id = $max_id[0] + 1;
$qry = mysqli_query($con,$check);
$num_rows = mysqli_num_rows($qry); 

if($num_rows > 0){

echo "The username you have entered already exists. Please try another username.";
}
else{
// Now inserting record in database
mysqli_query($con,"INSERT INTO `".$admin."` (`adID`, `adName`, `adPass`, `email`, `isAD` ) VALUES ('".$id."', 
'".$username."', '".$password."', '".$mail."', '".$admin."')") or die(mysqli_error($con));;
}
}

?>
<!--- Html starts here--->
<!DOCTYPE html>
<html>
<head>
<title>Admin Home</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css"/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script src="js/delete.js"></script>

</head>
<body>
<?php include('navigationBar.php')?>

<div class="contain">
<form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="form-add">
<div class="header"><h2>Add New Account</h2></div>
 <table>
    <tr>
      <td>Username:</td>
      <td> <input type="text" name="username" size="20" placeholder="Username"><span class="required">*</span></td>
    </tr>
             
    <tr>
      <td>Password:</td>
      <td><input type="password" name="password" size="20" placeholder="Password"><span class="required">*</span></td>
     </tr>
     
  <tr>
      <td>Email:</td>
      <td> <input type="email" name="email" size="20" placeholder="Email@email.com"><span class="required">*</span></td>
    </tr>
  <tr>
<tr>
	<td>User Type:</td>
	<td><input type="radio" name="admin" value="Yes">Admin
   <input type="radio" name="admin" value="No" checked>Transcriber</td>
       </tr>
<tr><td><input type="submit" value="Create User" class="submitButton"></td>
     </tr>
 </table>
</form>
</div>

<div class="dataTableDiv">
<?php include("adTable.php"); ?>
</div>

</body>
</html>

<?php include("CloseSession.php");?>
