<?php include("addSess.php"); 
$adr = $_SESSION['adr'];?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Home</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css"/>
<script type="text/javascript" src="js/jscolor/jscolor.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="js/confed.js"></script>
<script src="js/delete.js"></script>
<script src="js/templatize.js"></script>
</head>
<body onload="loadPreview()">
<?php include("navigationBar.php")?>
<div class="contain">
<?php if($adr == 1){?>
<form action="<?php $_SERVER['PHP_SELF']?>" method="post" class="form-add" id="sessform">
<div class="header"><h2>Add New Session</h2></div>
<table>
    <tr>
      <td>Session ID: 
      <input type="text" name="sessid" size="20" placeholder="#####"><span class="required">*</span></td>
	<td>Participants: <select id = "numberOf" name="numberOf">
		<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option></select><br/>
   <span class="con">Confederates:</span> <select name="confeds" id="confeds">
   <option value="0">0</option>
   <option value="1">1</option></select>
   </td>
	</tr>
	<tr>
	<td>Theme: <select name="themeOf" id="themeSelectionBox"><?php include("themeSelection.php");?></select></td>
	<td>Grid <input name="grid" value="unchecked" type="checkbox">
   Color <input id="transparency" name="transparency" value="unchecked" type="checkbox"></td>
	<td><table class="colorTable" id="ctable">
<tr><td class="cell1"><pre>     </pre></td><td class="cell2"><pre>     </pre></td></tr>
<tr><td class="cell2"><pre>     </pre></td><td class="cell1"><pre>     </pre></td></tr>
</table></td>

</tr>
	<tr>
	<td id="boxlist1" style="display: hidden;">Box A Color: <input type="text" class="color" value="#738BBF" onchange="document.getElementById('box1').value = '#' + this.color.toString(); document.getElementById('box1').onchange();"> <input type="hidden" name="whiteBoxColor" id="box1" /></td>
	<td id="boxlist2" style="display: hidden;">Box B Color: <input type="text" class="color" value="#738BBF" onchange="document.getElementById('box2').value = '#' + this.color.toString(); document.getElementById('box2').onchange();"> <input type="hidden" name="blackBoxColor" id="box2" /></td>
	</tr>
	</table>
<strong>URL To End of Test Survey:</strong>
<input type="text" name="surveyUrl" placeholder="http://www.google.com/" />

<div id="sessionTemplateBox">
<strong>Use template</strong> <input type="checkbox" name="useTemplate" value="unchecked">
<select name="templateOf" id="templateSelectionBox"><?php include("templateSelection.php");?></select>
<form action='' method='get'> 
   <button type='button' class='removalButton' onclick="deleteTemplate(document.getElementById('templateSelectionBox').value)";>Delete template
   </button></form>

<h4>Confederate Script</h4>
	 
    <textarea placeholder="Script A" name="confedtextA" form="sessform" class="context" id="ctA"></textarea>
    <textarea placeholder="Script B" name="confedtextB" form="sessform" class="context" id="ctB"></textarea>
    <textarea placeholder="Script C" name="confedtextC" form="sessform" class="context" id="ctC"></textarea>
    <textarea placeholder="Script D" name="confedtextD" form="sessform" class="context" id="ctD"></textarea>
    <textarea placeholder="Script E" name="confedtextE" form="sessform" class="context" id="ctE"></textarea>
<br/>

<div id="themePreview">
<center>
<h4>Preview of Currently Selected Theme</h4><hr>
<img id="preview1" src="" height="50" width="50"/>
<img id="preview2" src="" height="50" width="50"/>
<img id="preview3" src="" height="50" width="50"/>
<img id="preview4" src="" height="50" width="50"/>
<img id="preview5" src="" height="50" width="50"/>
<img id="preview6" src="" height="50" width="50"/>
</center>
</div>
 <input type="submit" value="Create Session" class="submitButton" id="sesscb">
<br/>
</form>
</div>
</div>
<div class="dataTableDiv">
<?php }include("sessTable.php"); ?>
</div>
<div class="legendDiv">
<table class="legendTable">
<tr><td><h5>Participants</h5></td><td><h5>Confederates</h5></td></tr>
<tr><td class='base'>A</td><td class='baseCon'>A</td><td>Not started</td></tr>
<tr><td class='prog'>A</td><td class='progCon'>A</td><td>Logged in</td></tr>
<tr><td class='done'>A</td><td class='doneCon'>A</td><td>Submitted test</td></tr>
<tr><td><h5>Tests</h5></td></tr>
<tr><td>111</td><td></td><td>Board pending</td></tr>
<tr><td class='setupTest'>111</td><td></td><td>Board set</td></tr>
</table>
</div>
<script type="text/javascript">


// Todo : Consider making the preview theme show more than 6 images... if need be
function loadPreview(){
	var tbox = document.getElementById('themeSelectionBox');
	var themeName = tbox.options[tbox.selectedIndex].text;

	var prev1 = document.getElementById('preview1');
	var prev2 = document.getElementById('preview2');
	var prev3 = document.getElementById('preview3');
	var prev4 = document.getElementById('preview4');
	var prev5 = document.getElementById('preview5');
	var prev6 = document.getElementById('preview6');

	prev1.src = "img/chesspieces/" + themeName + "/bB.png";
	prev2.src = "img/chesspieces/" + themeName + "/bK.png";
	prev3.src = "img/chesspieces/" + themeName + "/bN.png";
	prev4.src = "img/chesspieces/" + themeName + "/wB.png";
	prev5.src = "img/chesspieces/" + themeName + "/wK.png";
	prev6.src = "img/chesspieces/" + themeName + "/wN.png";
};

$(document).ready(function() {

	var cbox1 = document.getElementById("box1");
	var cbox2 = document.getElementById("box2");
	var boxlist1 = document.getElementById("boxlist1");
	var boxlist2 = document.getElementById("boxlist2");
   //Set up color preview variables
   var colorTable = document.getElementById("ctable");
   var blocks1 = document.getElementsByClassName("cell1");
   var blocks2 = document.getElementsByClassName("cell2");

	boxlist1.style.display="none";
	boxlist2.style.display="none";
   colorTable.style.display = "none";


   //Change board preview

   cbox1.onchange = (function(){
     blocks1[0].style.backgroundColor = cbox1.value;
     blocks1[1].style.backgroundColor = cbox1.value;
   });
  cbox2.onchange = (function(){
     blocks2[0].style.backgroundColor = cbox2.value;
     blocks2[1].style.backgroundColor = cbox2.value;
   });
	
	$('#themeSelectionBox').change(function() {
		loadPreview();
	});

	$('#transparency').change(function ()
	{
		if($(this).is(":checked"))
		{
			boxlist1.style.display="list-item";
			boxlist2.style.display="list-item";
         colorTable.style.display = "inline";
         if(cbox1.value == ""){
           blocks1[0].style.backgroundColor = "#738BBF";
           blocks1[1].style.backgroundColor = "#738BBF";
           blocks2[0].style.backgroundColor = "#738BBF";
           blocks2[1].style.backgroundColor = "#738BBF";
         }
         else{
           blocks1[0].style.backgroundColor = cbox1.value;
           blocks1[1].style.backgroundColor = cbox1.value;
           blocks2[0].style.backgroundColor = cbox2.value;
           blocks2[1].style.backgroundColor = cbox2.value;
         }
		}
		else
		{
			boxlist1.style.display="none";
			boxlist2.style.display="none";
         colorTable.style.display = "none";

			cbox1.value="#738BBF";
			cbox2.value="#738BBF";
		}
	});
});


//Color box stuff
</script>
</body>
</html>
<?php include("CloseSession.php");?>
