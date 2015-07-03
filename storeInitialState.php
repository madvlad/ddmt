<?php
	echo "compile test\n";

	$database="lingStudyDB";
	$server="localhost";
	$db_user="max";
	$db_pass="fish123";
	$table="testGame";

	$con=mysqli_connect($server,$db_user,$db_pass,$database);

	$sessID = $_GET["sessID"];

	if(mysqli_connect_errno()){
		echo "Failed to connect to database.";
	}

	for($i = 0; $i < 6; $i++){
		$boardChar = chr(65 + $i);
		$board = "board" . chr(65 + $i);
		$varname = "\$_GET[\"" . $board . "\"]";

		echo $varname;

		if(isset($varname)){
			$insertBoard = $_GET[$board];

			echo "setting " . $board . " to : " . $insertBoard . "\n";

			$query = "UPDATE `testGame` SET initBoard = '$insertBoard' WHERE `sessID` = '$sessID' and `playerID` = '$boardChar';";
         $query2 = "UPDATE `testers` SET `hsu`= 1 WHERE `sessID` = '$sessID';";
			if(!mysqli_query($con, $query)){
				die('Error: ' . mysqli_error($con));
			}

		} else {
			echo "Failed: Did not find board.";			

			break;
		}
      mysqli_query($con,$query2);
}

mysqli_close($con);
header("Location: ./sess_log.php");
?>
