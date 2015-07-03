<?php 
include("config.php");
include("sessionGuard.php");?>
<!doctype html>

<html>
<head>
	<meta charset="utf-8" />
	<title>Reviewing Test Results</title>
	<link rel="stylesheet" href="css/chessboard-0.3.0.css" />
	<link rel="stylesheet" href="css/lingStudy.css" />
</head>
<body>

<div class="midbar">
<input type="button" id="exportButton" value="Export Session" class="boardButton" onclick="popup('export.php?sessID=<?php echo $_GET["sessID"] ?>')" />
<center>
Session ID:<?php echo $_GET["sessID"] ?><br><br>

<div id="list" style="width: 250px">

</div>
<br>

<input type="button" id="gridToggle" value="Toggle Grid" class="boardButton">
<input type="button" id="restartSession" value="To Initial Step" class="boardButton" />
<input type="button" id="prevStep" value="Prev Step" class="boardButton" />
<input type="button" id="nextStep" value="Next Step" class="boardButton" />
<br>
<input type="button" value="Back To Results" onclick="location.href='./sess_log.php';"
 class = "boardButton">
<br>
<label for="turn" id="turnNum"></label>
</center>

</div>

<script src="js/json3.min.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/chessboard-0.3.0.js"></script>

<script>
function popup(url) 
{
 var width  = 900;
 var height = screen.height;
 var left   = (screen.width  - width)/2;
 var top    = (screen.height - height)/2;
 var params = 'width='+width+', height='+height;
 params += ', top='+top+', left='+left;
 params += ', directories=no';
 params += ', location=no';
 params += ', menubar=no';
 params += ', resizable=no';
 params += ', scrollbars=no';
 params += ', status=no';
 params += ', toolbar=no';
 newwin=window.open(url,'windowname5', params);
 if (window.focus) {newwin.focus()}
 return false;
}
	<?php
		$database="lingStudyDB";
		$server="localhost";
		$db_user="max";
		$db_pass="fish123";
		$table="testGame";
		$id="playerID";
		$sessID = $_GET["sessID"];

		$link=mysql_connect($server,$db_user,$db_pass);
		mysql_select_db($database,$link);
		
		$count = 0;
		
		$query="SELECT * FROM `testGame` WHERE `sessID` = '$sessID';";

		$rows = array();

		$result=mysql_query($query);

		//Fetch the transcription data for later too
		$query2 = "SELECT `trans` from `testers` WHERE `sessID` = '".$sessID."';";
		$transQ = mysqli_query($con, $query2);
		$transRow = mysqli_fetch_array($transQ);
		$transData = $transRow[0];
      //And audio files
      $query3 = "SELECT `testID`, `uAFN`, `sessID` FROM `test_takers` WHERE `sessID` = '".$sessID."';";
      $audQ = mysqli_query($con,$query3);

		while($newRow = mysql_fetch_array($result)){
			
			array_push($rows,$newRow[2]);
			$theme = $newRow[4];
			$grid = $newRow[5];
			$whiteBoxColor = $newRow[6];
			$blackBoxColor = $newRow[7];
		}

		echo "var boardTheme = \"" . $theme . "\";\n";

		echo "var historyArr = [";

		for($i = 0; $i < sizeof($rows); $i++){
			$boardHistChar = chr(65 + $i);

			$boardHist = explode("|", $rows[$i]);

			echo json_encode($boardHist) . ",";
		}
		
		echo "0];\n";
		echo "var gridOn = ".$grid.";\n";	
		echo "var boxAColor = \"".$whiteBoxColor."\";\n";
		echo "var boxBColor = \"".$blackBoxColor."\";\n";
		mysql_close();
	?>
var history = function(hist){
	for (x in hist){
		console.log(x);
	}
};

var init = function(){
var count = 0;
var boards = new Array();

var onChange = function(){
	//historyArrA.push(board1.fen());
	//historyArrB.push(board2.fen());
}

var cfg = {
	pieceTheme: 'img/chesspieces/' + boardTheme + '/{piece}.png', 
	draggable: false,
	onChange: onChange
};

var allBoards = document.getElementById("list");

for(var i = 0; i < historyArr.length - 1; i++){
	var boardName = "board" + (i+1);	

	var newDiv = document.createElement("div");
	newDiv.setAttribute("id","board" + (i+1));
	newDiv.setAttribute("style","size: 250px");

	var playerName = document.createTextNode("Player " + String.fromCharCode(i+65));

	allBoards.appendChild(playerName);
	allBoards.appendChild(newDiv);

	boards[i] = new ChessBoard(boardName, cfg);
	boards[i].position(historyArr[i][0]);
}

document.getElementById("turnNum").innerHTML = "Current Turn: " + (count);

var whiteBoxes = document.getElementsByClassName('white-1e1d7');
var blackBoxes = document.getElementsByClassName('black-3c85d');

for(var i = 0; i < whiteBoxes.length; i++){
	blackBoxes[i].style.backgroundColor = boxBColor;
	whiteBoxes[i].style.backgroundColor = boxAColor;
	if(gridOn == 0){
		whiteBoxes[i].style.border = '0px';
		blackBoxes[i].style.border = '0px';
	}
}


$('#gridToggle').on('click', function(){


	if(gridOn == 1){		
		for(var i = 0; i < whiteBoxes.length; i++){
			whiteBoxes[i].style.border = '0px';
			blackBoxes[i].style.border = '0px';
		}

		gridOn = 0;
	} else {

		for(var i = 0; i < whiteBoxes.length; i++){
			whiteBoxes[i].style.border = '1px dotted #404040';
			blackBoxes[i].style.border = '1px dotted #404040';
		}

		gridOn = 1;
	}

});

$('#nextStep').on('click', function(){
	if(count >= historyArr[0].length){
		
	} else {
		count++;

		for(var k = 0; k < boards.length; k++){
			boards[k].position(historyArr[k][count]);
		}
		document.getElementById("turnNum").innerHTML = "Current Turn: " + (count);
	}
});

$('#prevStep').on('click', function() {

	if(count != 0){
		count--;

		for(var k = 0; k < boards.length; k++){
			boards[k].position(historyArr[k][count]);
		}

		document.getElementById("turnNum").innerHTML = "Current Turn: " + (count);
	}

});

$('#restartSession').on('click', function() {
	count = 0;

	for(var k = 0; k < boards.length; k++){
		boards[k].position(historyArr[k][count]);
	}

	document.getElementById("turnNum").innerHTML = "Current Turn: " + (count);

});

}; // end init()

$(document).ready(init);
</script>

<div class="sidebar">
	<h3>Audio and Transcription Data</h3>
    <textarea name="trans" form="tranform" class="transbox"><?php echo $transData;?></textarea>
	<form method="get" action="saveTranscription.php" id="tranform">
	<input type="hidden" name="sess" value=<?php 
	echo "'";
	echo "$sessID";
	echo "'";?>></input>
	<input type="submit" value="Save" class="revSub"></input></form>
<form method="get" action="downloadFile.php">
	<input type="submit" value="Download to text file" class="revSub">
	<input type="hidden" name="sess" value=<?php
   echo "'";
   echo "$sessID";
   echo "'";?>></input></form><br/>
<?php
	//Load audio
   while($audRow = mysqli_fetch_array($audQ)){
     $audURL = "audioDir/" .$audRow[2]."/". $audRow[1];

     $info = pathinfo($audRow[1]);
     $downLink = $info['filename'] . '.' . "ogg";
     echo("<h3>Player ".$audRow[0]."</h3>");    
     echo("<audio id='audSrc".$audRow[0]."' controls = 'controls'><source src='".$audURL."' type='audio/ogg'>");
     echo("<embed height='50' width='100' src='".$audURL."'></audio><br/>");
     echo("<a href='".$audURL."' download='".$downLink."'>Click to download!</a>");
   }
   //Load the session overall audio
   $audURL = "audioDir/".$sessID."/".$sessID.".ogg";
   echo("<h3>Whole session</h3>");
   echo ("<audio id='audSrc".$sessID."' controls = 'controls'><source src='".$audURL."' type = 'audio/ogg'>");
   echo("embed height ='50' width = '100' src='".$audURL."'></audio><br/>");
   echo("<a href='".$audURL."' download='".$sessID.".ogg'>Click to download!</a>");
?>
</div>
<script src="js/downloadAud.js"></script>
</body>
</html>
