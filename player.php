<?php
   session_start();
   include("config.php");
   echo "<p class = 'SP' class='hiddenContent'>" .$_GET['sessID'] . "</p>";
   echo "<p class = 'UP' class='hiddenContent'>" .$_GET['testID'] . "</p>"; 
   echo "<ul class='hiddenContent' id=\"tabNav\"><li>Session ID: <label id = 'sessID'>" . $_GET["sessID"] . "</label></li>"
      . "<li>Player ID: <label id = 'testID'>" . $_GET["testID"] . "</label></li></ul>";

   $query = "UPDATE `test_takers` SET `sessStat` = 1 WHERE `testID` = '". $_GET["testID"] . "' AND `sessID` = "
	. $_GET["sessID"] . ";";

   $query2 = "UPDATE `testers` SET `inSession` = 1 WHERE `sessID` = " . $_GET["sessID"] . ";";
   
   $query3 = "SELECT `isConfed` FROM `test_takers` WHERE `sessID` = ". $_GET["sessID"] . " AND `testID` ='" . $_GET["testID"] . "';";
   
   $query4 = "SELECT `conftext` FROM `test_takers` WHERE `sessID` = " . $_GET["sessID"] . " AND `testID` = '".$_GET["testID"]."';";
  
   mysqli_query($con,$query);
   mysqli_query($con,$query2);
   
   $conr = mysqli_query($con,$query3);
   $conrow = mysqli_fetch_row($conr);
   $conStat = $conrow[0];

   $textq = mysqli_query($con,$query4);
   $textq2 = mysqli_fetch_row($textq);
   $context = $textq2[0];
?>
<!doctype html>

<html>
<head>
	<meta charset="utf-8" />
	<title>Test In Session</title>
	<link rel="stylesheet" href="css/chessboard-0.3.0.css" />
	<link rel="stylesheet" href="css/lingStudy.css" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
   <script src="js/peer.js"></script>
   <script src="https://www.WebRTC-Experiment.com/RecordRTC.js"></script>
   <script src="js/xhrJS.js"></script>
</head>
<body>

<div class="midbar">

<center>

<div id="board" style="width: 500px"></div>
<!--<input type="button" id="clearBtn" value="Clear Board" />-->
<input type="image" src="img/check.png" id="submitBtn" alt="Submit Test"/>
<br>
<label for="turn" id="turnNum"></label>
</center>
</div>
<script src="js/json3.min.js"></script>
<script src="js/jquery-1.10.1.min.js"></script>
<script src="js/chessboard-0.3.0.js"></script>

<script>
//Necessary for auto recording
var records;

var history = function(hist){
	for (x in hist){
		console.log(x);
	}
};
var init = function(){
		<?php
			$table=$games;
			$id= $_GET["testID"];
			$sessID = $_GET["sessID"];

			$link = mysql_connect($server, $db_user, $db_pass);
			mysql_select_db($database,$link);

			$query="SELECT * FROM `testGame` WHERE `sessID` = '$sessID' and `playerID` = '$id';";

			$result = mysql_query($query);

			$newRow = mysql_fetch_array($result);

			$hist = $newRow[3];
			$boardTheme = $newRow[4];
			$grid = $newRow[5];
			$whiteBoxColor = $newRow[6];
			$blackBoxColor = $newRow[7];
			$surveyUrl = $newRow[8];

			echo "var initPos = \"".$hist."\";\n";
			echo "var boardTheme = \"".$boardTheme."\";\n";
		   echo "var gridOn = ".$grid.";\n";	
			echo "var boxAColor = \"".$whiteBoxColor."\";\n";
			echo "var boxBColor = \"".$blackBoxColor."\";\n";
			echo "var surveyUrl = \"".$surveyUrl."\";\n";
		?>
var historyArr = [];
var count = 0;

var onChange = function(oldPos, newPos){
	historyArr.push(ChessBoard.objToFen(newPos));
};

var cfg = {
	pieceTheme: 'img/chesspieces/' + boardTheme  + '/{piece}.png',
	showNotation: false,
	draggable: true,
	dropOffBoard: 'trash',
	sparePieces: true,
	position: initPos,
	onChange: onChange
};

var board = new ChessBoard('board', cfg);

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

$('#clearBtn').on('click', function(){
	board.clear(false);
});

$('#submitBtn').on('click', function(){
	var board = JSON.stringify(historyArr);
	var method = "POST";
	var session = document.getElementById("sessID").innerHTML;
	var player = document.getElementById("testID").innerHTML;
   
	var url = "storeBoard.php?sessID="+session+"&testID="+player;

	var async = true;
   
  $('#end-call').click();

	var request = new XMLHttpRequest();

	request.onload = function () {
		var status = request.status;
		var data = request.responseText;
	}

	request.open(method, url, async);

	request.setRequestHeader("Content-Type", "application.json;charset=UTF-8");

	request.send(board);

	setTimeout(function() {
	   window.location.replace("//" + surveyUrl);
	}, 3000);
});

}; // end init()

$(document).ready(init);
</script>

<script>
//Talking code
// Compatibility shim
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;

    // PeerJS object
    var sid =  document.getElementsByClassName('SP')[0].innerHTML;
	 var uid = document.getElementsByClassName('UP')[0].innerHTML;
    var ID = sid + "" + uid;
    var oID;//In the future, this will be the session host call
    if(uid == 'A'){
      oID = sid + "B";
    }
    else{
      oID = sid + "A";
    }
    var keyPHP = <?php echo json_encode($peerJSKey); ?>;
    var peer = new Peer(ID, { key: keyPHP});
    peer.on('open', function(){
      $('#my-id').text(peer.id);
    });

    // Receiving a call
    peer.on('call', function(call){
      // Answer the call automatically (instead of prompting user)
      call.answer(window.localStream);
      
      step3(call);
    });
    peer.on('error', function(err){
      alert(err.message);
      // Return to step 2 if error occurs
      step2();
    });

    // Click handlers setup
    $(function(){
      $('#make-call').click(function(){
        // Initiate a call!
        var call = peer.call(oID, window.localStream);
        step3(call);
        });

      $('#end-call').click(function(){
       //Currently, closing on one end does not close all chats in firefox :(
        window.existingCall.close();
        $('#make-call').css("display","block");
        $('#end-call').css("visibility","hidden");
        
        //End record

         records.stopRecording(function(audioURL){
        //Save recording
         var blob = records.getBlob();
         var fileType = "audio";
         var fileName = ID + ".ogg";
         var sessName = document.getElementById("sessID").innerHTML;
         var formData = new FormData();
         formData.append(fileType + '-filename', fileName);
         formData.append(fileType + '-blob', blob);
         formData.append(fileType + '-sessID',sessName);
         formData.append('uid',uid);
         formData.append('sid',sid);
         xhr('saveAudio.php', formData, function (fName) {
         });
        });
         
        step2();
      });

      // Retry if getUserMedia fails
      $('#step1-retry').click(function(){
  $('#step1-error').hide();
        step1();
      });

      // Get things started
      step1();
    });

    function step1 () {
      // Get audio/video stream
      navigator.getUserMedia({audio: true, video: false}, function(stream){
        // Set your video displays
        $('#my-video').prop('src', URL.createObjectURL(stream));

        window.localStream = stream;
        step2();
      }, function(){ $('#step1-error').show(); });
    }

    function step2 () {
      $('#step1, #step3').hide();
      $('#step2').show();
    }
 function step3 (call) {
      // Hang up on an existing call if present
      if (window.existingCall) {
        window.existingCall.close();
      }

      // Wait for stream on the call, then set peer video display
      call.on('stream', function(stream){
        $('#their-video').prop('src', URL.createObjectURL(stream));
		//Set phone buttons
        $('#make-call').css("display","none");
        $('#end-call').css("visibility","visible");
       //Audio Record
       records = RecordRTC(stream);
       records.startRecording();
      });

      // UI stuff
      window.existingCall = call;
      $('#their-id').text(call.peer);
      call.on('close', step2);
      $('#step1, #step2').hide();
      $('#step3').show();
    }

                                               
</script>
<div class="sidebar">
<?php
if($conStat == 1){
?>
<h3>Confederate Script</h3>
    <textarea name="ctext" class="transbox"><?php echo $context; ?></textarea>
<?php } ?>
<video class="audplay" id="their-video" autoplay> </video>
<video class ="audplay" id="my-video" muted="true" autplay> </video>

<a href="#" id="make-call"><img src="img/phoneImgs/phone-callready.png" width = "100" height = "80"/></a>

<a href="#" id="end-call"><img src="img/phoneImgs/phone-callinprog.png" width="100" height="80"/></a>
</div>
</body>
<?php include("CloseSession.php");?>
</html>
