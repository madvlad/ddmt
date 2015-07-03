<?php
$tq = "SELECT `sessID`,`STID`, `hSU` FROM `testers`";
$tq2 = "SELECT `sessID`, `testID`, `sessStat`, `isConfed` FROM `test_takers` ORDER BY `sessID`,`testID` ASC";
$testers = mysqli_query($con,$tq);
$testers2 = mysqli_query($con,$tq2);
$adr = $_SESSION['adr'];
?>
<table class="tabdiv">
<tr><td>Test</td><td>Testers</td><td></td><td></td><td></td></tr>
<?php
if($testers2){
	$title = "";
	while ($row = mysqli_fetch_array($testers2)){
		?>
		<tr>
<?php
$sest = "SELECT `inSession`,`hSU` FROM `testers` WHERE `sessID` = " . $row[0] . ";";
$resses = mysqli_query($con,$sest);
$res = mysqli_fetch_array($resses);
if($title == $row[0]){
 if($row[3] == 1){	
   if($row[2] == 1){
	  echo("<td></td> <td class='progCon'> $row[1] </td>");
   }
   else if ($row[2] == 2){
     echo("<td></td> <td class='doneCon'> $row[1] </td>");
   }
   else{
    echo("<td></td><td class='baseCon'> $row[1] </td>");
   }
  }
  else{
    if($row[2] == 1){
	  echo("<td></td> <td class='prog'> $row[1] </td>");
   }
   else if ($row[2] == 2){
     echo("<td></td> <td class='done'> $row[1] </td>");
   }
   else{
    echo("<td></td><td class='base'> $row[1] </td>");
   }
  }
   echo("<td></td>");
	echo("<td></td>");
	echo("<td></td>");

}
else{
if($res[1] == 0){
  echo("<td> $row[0] </td>");
}
else{
  echo("<td class='setupTest'> $row[0] </td>");
}
 if($row[3] == 1){
   if($row[2] == 1){
	  echo("<td class='progCon'> $row[1] </td>");
   }
   else if ($row[2] == 2){
     echo("<td class='doneCon'> $row[1] </td>");
   }
   else{
    echo("<td class='baseCon'> $row[1] </td>");
   }
  }
  else{
    if($row[2] == 1){
	  echo("<td class='prog'> $row[1] </td>");
   }
   else if ($row[2] == 2){
     echo("<td class='done'> $row[1] </td>");
   }
   else{
    echo("<td class='base'> $row[1] </td>");
   }
  }




if($adr == 1){
  if($res[0] == 1){
    echo("<td>In Progress</td>");
  }
  else if($res[0] == 2){
    echo("<td>Finished</td>");
  }
  else{
	   echo("<td><form action='editBoard.php' method='get'>
	   <input type='hidden' name='sessID' value='$row[0]'></input>
	   <button type='submit' class='submitButton'>Set Up Initial Board</button></form></td>");

}
}
else{
	echo("<td></td>");
}
if($res[0] == 2){
echo("<td><form action='review.php' method='get'>
<input type='hidden' name='sessID' value='$row[0]'></input>
<button type='submit' class='submitButton'>Check Results</button></form></td>");
}
else{
  echo("<td>No Results Yet</td>");
}
if($adr == 1){
   echo("<td>");
   if($res[1] != 0){
	   echo(" <form method='get'> <input type='hidden' name='sessID' value = '$row[0]'></input>
      <button class='submitButton' type='button' onclick='makeTemplate($row[0]);')>Make Template</button</form>");
   }
   echo("<form action='deleteTest.php' method='get'> 
	<input type='hidden' name='sessID' value='$row[0]'></input>
	<button type='button' class='removalButton' onclick='deleteSess($row[0]);'>Delete
	</button></form>");
   echo ("</td>");
}
else{
	echo("<td></td>");
}
$title = $row[0];
}

?>
		</tr>
<?php 
	}
}
?>
</table>

