<?php include("sessionGuard.php");
include("config.php"); 
include("redirectTranscriber.php");?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Home</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css"/>
<style>
#div1, #div2
{float:left; width:100px; height:35px; margin:10px;padding:10px;border:1px solid #aaaaaa;}
</style>
<script type="text/javascript">
var imageList=[<?php
        $dir='img/imgStore';
        $files = scandir($dir);
        foreach((array)$files as $file){
           if($file=='.'||$file=='..') continue;
           $fileList[]=$file;
        }
        echo "'".implode("','", $fileList)."'";
    ?>];
console.log(imageList);

function allowDrop(ev)
{
	ev.preventDefault();
}

function drag(ev)
{
	ev.dataTransfer.setData("Text", ev.target.id);
}

function drop(ev)
{
	ev.preventDefault();
	var data = ev.dataTransfer.getData("Text");
	ev.target.appendChild(document.getElementById(data));
}
</script>
</head>
<body>
<?php include("navigationBar.php") ?>
<div class="contain">
<form action="storeTheme.php" method="post" enctype="multipart/form-data" class="form-add">
<div class="header"><h2>Select Images for Theme</h2></div>
<table>
    <tr>
      <td>bB:</td>
      <td> <input type="file" name="bB"></td>
	</tr>
		<td>bK:</td>
		<td> <input type="file" name="bK"></td>
	</tr>
	<tr>
		<td>bN:</td>
		<td> <input type="file" name="bN"></td>
	</tr>
	<tr>
		<td>bP:</td>
		<td> <input type="file" name="bP"></td>
	</tr>
	<tr>
		<td>bQ:</td>
		<td> <input type="file" name="bQ"></td>
	</tr>
	<tr>
		<td>bR:</td>
		<td> <input type="file" name="bR"></td>
	</tr>
	<tr>
		<td>wB:</td>
		<td> <input type="file" name="wB"></td>
	</tr>
	<tr>
		<td>wK:</td>
		<td> <input type="file" name="wK"></td>
	</tr>
	<tr>
		<td>wN:</td>
		<td> <input type="file" name="wN"></td>
	</tr>
	<tr>
		<td>wP:</td>
		<td> <input type="file" name="wP"></td>
	</tr>
	<tr>
		<td>wQ:</td>
		<td> <input type="file" name="wQ"></td>
	</tr>
	<tr>
		<td>wR:</td>
		<td> <input type="file" name="wR"></td>
	</tr>
	</table>
<br>
	<input type="text" name="themeName" placeholder="Name Of Theme"><br><br>
	<input type="submit" value="Create Theme" class="submitButton">
</form>

<div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)">
<img id="drag1" src="http://cdn1.akamai.coub.com/user/cw_avatar/82548a2e735/82103f3d3af530a365370/small_1390826164_Aphex_Twin_Logo.png" draggable="true" ondragstart="drag(event)"></div>
<div id="div2" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
</div>
</body>
</html>

<?php

include("CloseSession.php");

?>
