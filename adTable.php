<?php
$uq = "SELECT `adName`, `email`, `isAd`,`adID` FROM `admins`";
$users = mysqli_query($con,$uq);
?>
<table class="tabdiv">
<tr><td>Username</td><td>Email</td><td>User Type</td><td></td></tr>
<?php
if($users){
	while ($row = mysqli_fetch_array($users)){
		?>
		<tr>
<?php
echo("<td> $row[0] </td> <td> $row[1] </td> <td>");
if($row[2] == 1){
	echo(" Admin </td>");
}
else{
	echo(" Transcriber </td>");
}
echo("<td> <form action='deleteAdmin.php' method='get'> 
<input type='hidden' name='id' value='$row[3]'></input>
<button type='button' id='$row[3]' class='removalButton' onclick = 'deleteUser($row[3]);'>Delete
</button></form></td>");

?>
		</tr>
<?php 
	}
}
?>
</table>

