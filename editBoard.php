<?php include("sessionGuard.php");?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Edit Initial Board</title>
	<link rel="stylesheet" href="css/chessboard-0.3.0.css" />
	<link rel="stylesheet" href="css/lingStudy.css" />
</head>
<body>

Editing Start State for Session <label id='sessID'><?php echo $_GET["sessID"] ?></label><br><br>
<div id="list" style="width: 200px; overflow:hidden">

</div>

<input type="button" id="randomBtn" class="boardButton"  value="Place Anchor" />
<input type="button" id="scrambleBtn" class="boardButton"  value="Scramble Boards" />
<input type="button" id="completeBtn" class="boardButton" value="Finalize"/> 
<input type="button" id="cancelBtn" class="boardButton" value="Cancel"/>

<script src="js/json3.min.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/chessboard-0.3.0.js"></script>
<script src="js/chess.js"></script>

<script>
<?php
	$database="lingStudyDB";
	$server="localhost";
	$db_user="max";
	$db_pass="fish123";
	$table="testGame";
	
	$sessID=$_GET["sessID"];

	$link=mysql_connect($server,$db_user,$db_pass);
	mysql_select_db($database,$link);

	$count = 0;

	$query = "SELECT * FROM `testGame` WHERE `sessID` = '$sessID';";
	$result = mysql_query($query);

	echo "var initBoards = new Array();";

	while($row = mysql_fetch_array($result)){
		$count++;
		$initBoard = $row[3];
		$boardTheme = $row[4];
		$grid = $row[5];
		$whiteBoxColor = $row[6];
		$blackBoxColor = $row[7]; 

		if(!empty($initBoard)){
			echo "initBoards.push(\"".$initBoard."\");";
		} else {
			echo "initBoards.push(\"\");";
		}
	}

	echo "var amountOfBoards = " . $count . ";\n";
   echo "var boardTheme = \"".$boardTheme."\";\n";
	echo "var gridOn = ".$grid.";\n";	
	echo "var boxAColor = \"".$whiteBoxColor."\";\n";
	echo "var boxBColor = \"".$blackBoxColor."\";\n";
	mysql_close();
?>

var boards = new Array();
var games = new Array();
var possibleMoves = new Array();
var random = new Array();

var sessID = document.getElementById("sessID").innerHTML;

var init = function() {
	var cfg = {
		pieceTheme: 'img/chesspieces/' + boardTheme  + '/{piece}.png',
		showNotation: true,
		draggable: true,
		dropOffBoard: 'trash',
		sparePieces: true
	};

	var allBoards = document.getElementById("list");

	for(var i = 0; i < amountOfBoards; i++){
		var boardName = "board" + (i+1);

		var newDiv = document.createElement("div");
		newDiv.setAttribute("id", boardName);
		newDiv.setAttribute("style","size: 100px");

		var playerName = document.createTextNode("Player " + String.fromCharCode(i+65));

		allBoards.appendChild(playerName);
		allBoards.appendChild(newDiv);

		boards[i] = new ChessBoard(boardName, cfg);
		boards[i].position(initBoards[i]);
		games[i] = new Chess();
	}

	var count = 0;
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

// THIS METHOD DOES NOT EXECUTE BUT I'M SCARED TO DELETE IT!!!!
	var makeRandom = function(){

		var yChars = "abcdefgh";

		var randX = Math.ceil(Math.random() * (9 - 1) + 1);
		var randY = yChars[Math.ceil(Math.random() * (8 - 0) + 0)]; 

		var thisSpot = randY + "" + randX;

		var randPos = {
			position: {
				thisSpot : 'wP'
			}
		};

		for( var i = 0 ; i < amountOfBoards; i++){

			var boardName = "board" + (i+1);

			boards[i].position(randPos);
			//possibleMoves[i] = games[i].moves();
			
			//count = 0;

			//while(count < 10 && possibleMoves[i].length != 0){
		//		random[i] = Math.floor(Math.random() * possibleMoves[i].length);
		//		possibleMoves[i] = games[i].moves();
		//		games[i].move(possibleMoves[i][random[i]]);
		//		boards[i].position(games[i].fen());
		//		count++;
		//	}
		}

		count = 0;
		
	};
};

$('#cancelBtn').on('click', function() {
	window.location = "sess_log.php";
});


$('#scrambleBtn').on('click', function (){
	var count;

		for( var i = 0 ; i < amountOfBoards; i++){
			possibleMoves[i] = games[i].moves();
			
			count = 0;

			while(count < 50 && possibleMoves[i].length != 0){
				random[i] = Math.floor(Math.random() * possibleMoves[i].length);
				possibleMoves[i] = games[i].moves();
				games[i].move(possibleMoves[i][random[i]]);
				boards[i].position(games[i].fen());
				count++;
			}

		}

	count = 0;
	
});

$('#randomBtn').on('click', function() {
	var count;

		for( var i = 0 ; i < amountOfBoards; i++){
//			possibleMoves[i] = games[i].moves();
//			
//			count = 0;
//
//			while(count < 50 && possibleMoves[i].length != 0){
//				random[i] = Math.floor(Math.random() * possibleMoves[i].length);
//				possibleMoves[i] = games[i].moves();
//				games[i].move(possibleMoves[i][random[i]]);
//				boards[i].position(games[i].fen());
//				count++;
//			}

		var pieceColorChars = "wb";
		var pieceChars = "PRBKQPN";

		var yChars = "abcdefgh";

		var randX = Math.floor(Math.random() * (9 - 1) + 1);
		var randY = yChars[Math.floor(Math.random() * (8 - 0) + 0)]; 

		var thisSpot = randY + "" + randX;

		var randColor = pieceColorChars[Math.floor(Math.random() * (1 - 0 + 1) + 0)]; 
		var randPiece = pieceChars[Math.floor(Math.random() * (6 - 0) + 0)];

		var thisPiece = randColor + randPiece;
 
		for( var i = 0 ; i < amountOfBoards; i++){

			var boardName = "board" + (i+1);

				boards[i].position({
					e1: thisPiece
				});

				boards[i].move('e1-'+thisSpot);
			}
		}
//
//		count = 0;
		
});

$('#completeBtn').on('click', function () {
	var url = "storeInitialState.php?sessID="+sessID;

	for(var i = 0; i < amountOfBoards; i++){
		url += "&board" + String.fromCharCode(i+65) + "=" + boards[i].fen();
	}

	window.location = url;
});

$(document).ready(init);

</script>
</body>
</html>
