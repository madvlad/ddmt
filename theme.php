<?php include("sessionGuard.php");
include("config.php"); 
include("redirectTranscriber.php");?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Home</title>
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Expires" content="Tue, 01 Jan 1995 12:12:12 GMT">
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/lingStudy.css"/>
<style>
#div1, .div2
{float:left; width:50px; height:50px; margin:3px;padding:3px;border:1px solid #aaaaaa;}

#div3
{position: absolute; top: 0; float:right; width:32px; height:32px; margin-top:3%; padding-left:90%;}

#list
{position: relative;}

.themeRow a
{
	color: #B6DBF2;
	text-decoration: none;
}

.themeRow:nth-child(even) {
    background-color: #1947D1;
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
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

function gatherThemeNames() {
	var divimg1 = document.getElementById("bB");
	var divimg2 = document.getElementById("bK");
	var divimg3 = document.getElementById("bN");
	var divimg4 = document.getElementById("bP");
	var divimg5 = document.getElementById("bQ");
	var divimg6 = document.getElementById("bR");
	var divimg7 = document.getElementById("wB");
	var divimg8 = document.getElementById("wK");
	var divimg9 = document.getElementById("wN");
	var divimg10 = document.getElementById("wP");
	var divimg11 = document.getElementById("wQ");
	var divimg12 = document.getElementById("wR");
	var themeName = document.getElementById("themeName").value;

	// I'm sorry

	/*
		This is also a very very ugly and scary part of our code. May want to also clean this up
			- David 5/22/2014
	*/

	if(divimg1.childElementCount > 0 &&
		divimg2.childElementCount > 0 &&
		divimg3.childElementCount > 0 &&
		divimg4.childElementCount > 0 &&
		divimg5.childElementCount > 0 &&
		divimg6.childElementCount > 0 &&
		divimg7.childElementCount > 0 &&
		divimg8.childElementCount > 0 &&
		divimg9.childElementCount > 0 &&
		divimg10.childElementCount > 0 &&
		divimg11.childElementCount > 0 &&
		divimg12.childElementCount > 0)
	{
		if(themeName != "")
		{
			var img1url = divimg1.childNodes[0].src;
			var img2url = divimg2.childNodes[0].src;
			var img3url = divimg3.childNodes[0].src;
			var img4url = divimg4.childNodes[0].src;
			var img5url = divimg5.childNodes[0].src;
			var img6url = divimg6.childNodes[0].src;
			var img7url = divimg7.childNodes[0].src;
			var img8url = divimg8.childNodes[0].src;
			var img9url = divimg9.childNodes[0].src;
			var img10url = divimg10.childNodes[0].src;
			var img11url = divimg11.childNodes[0].src;
			var img12url = divimg12.childNodes[0].src;

			// You can hate me. It's okay. It's 3:30AM. But this will work.
			// It's also easy to read.
			var finalurl = "storeTheme.php?themeName="
									+ themeName +
									"&bB=" + img1url +
									"&bK=" + img2url +
									"&bN=" + img3url +
									"&bP=" + img4url +
									"&bQ=" + img5url +
									"&bR=" + img6url +
									"&wB=" + img7url +
									"&wK=" + img8url +
									"&wN=" + img9url +
									"&wP=" + img10url +
									"&wQ=" + img11url +
									"&wR=" + img12url;

			window.location = finalurl;
		}
		else
		{
			window.alert("Define a theme name.");
		}
	}
	else
	{
		window.alert("All the pieces of the theme need to be defined.");
	}
}

var largestImgId;

function prepareLibrary(){
	var i;

	var masterList = document.getElementById("list");
	for (i = 0; i < imageList.length; i++)
	{
		var imagePath = "img/imgStore/" + imageList[i];
		var idName = "img" + i;

		var newDiv = document.createElement("div");
		newDiv.setAttribute("id", "div1");
		newDiv.setAttribute("ondrop", "libdrop(event)");
		newDiv.setAttribute("ondragover", "allowDrop(event)");

		var newImg = document.createElement("img");
		newImg.setAttribute("id", idName); 
		newImg.setAttribute("src", imagePath);
		newImg.setAttribute("draggable", "true");
		newImg.setAttribute("ondragstart", "drag(event)");
		newImg.setAttribute("height", "50");
		newImg.setAttribute("width", "50");	
	
		newDiv.appendChild(newImg);
		masterList.appendChild(newDiv);	
		largestImgId = i;
	}
}

function loadTheme(name)
{
	var nameBox = document.getElementById("themeName");
	nameBox.disabled = true;
	nameBox.value = name;

	$.ajax({
		type: "POST",
		url: "loadThemeImages.php",
		data: {
			"themeName": name
		},
		success: function(data){
			var images = JSON.parse(data);
			
			var safeId = largestImgId + 1;
			images.forEach(function(entry) {
				var index = entry.lastIndexOf("/") + 1;
				var index2 = entry.lastIndexOf(".");
				var imageName = entry.substring(index, index2);

				var imgBox = document.getElementById(imageName);
				if(imgBox.childNodes.length > 0){
					imgBox.removeChild(imgBox.childNodes[0]);
				}
	
				var imageObj = document.createElement('img');
				imageObj.src = entry; 
				imageObj.setAttribute("draggable", "true");
				imageObj.setAttribute("ondragstart", "drag(event)");
				imageObj.setAttribute("height", "50");
				imageObj.setAttribute("width", "50");
				imageObj.setAttribute("id", "img" + safeId);
				safeId = safeId + 1;

				imgBox.appendChild(imageObj);
			});
		}
	});
}

function deleteTheme(name)
{
	if(window.confirm("Are you sure you want to delete this theme?")){
		$.ajax({
			type: "POST",
			url: "deleteTheme.php",
			data: {
				"themeName": name
			},
			success: function(data) {
				window.alert("Theme " + data + " has been removed.");
				$("#"+name).remove();
			}

		});
	}
}

function allowDrop(ev)
{
	ev.preventDefault();
}

function drag(ev)
{
	ev.dataTransfer.setData("Text", ev.target.id);
}

function libdrag(ev)
{
	ev.dataTransfer.setData("Text", ev.target.id);
	ev.dataTransfer.setData("Text", ev.id);
}

function drop(ev)
{
	ev.preventDefault();
	var data = ev.dataTransfer.getData("Text");
	ev.target.appendChild(document.getElementById(data));
}

function libdrop(ev)
{
	if(ev.target.tagName == "DIV"){
		var data = ev.dataTransfer.getData("Text");
		ev.target.appendChild(document.getElementById(data));
		ev.appendChild(document.getElementById(data));
	}
}

function deldrop(ev)
{
	ev.preventDefault();
	var data = ev.dataTransfer.getData("Text");
	var element = document.getElementById(data);

	var fullpath = element.src;

	var n = fullpath.lastIndexOf("/");

	var filename = fullpath.substring(n+1, fullpath.length);

	// TODO :: Add AJAX call here to delete the file and the DOM element
	var url = "deleteFile.php?fileName=" + filename;

	if(window.confirm("Are you sure you want to delete " + filename + "? This is permanent!!") == true)
	{
		window.location = url; 
	}
	else
	{
		ev.dataTransfer.setData("Text", ev.id);
	}
}
</script>
</head>
<body onload="prepareLibrary();">
<?php include("navigationBar.php") ?>
<div class="themeContain">
<form action="storeTheme.php" method="post" enctype="multipart/form-data" class="form-add">
<div class="header"><h2>&nbsp&nbspSelect Images for Theme</h2></div>
<center>
<table>
    <tr>
      <td>bB:</td>
      <td><div class="div2" id="bB" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>bK:</td>
      <td><div class="div2" id="bK" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>

		<td>bN:</td>
      <td><div class="div2" id="bN" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>

		<td>bP:</td>
      <td><div class="div2" id="bP" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>bQ:</td>
      <td><div class="div2" id="bQ" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>bR:</td>
      <td><div class="div2" id="bR" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	</tr>
	<tr>
		<td>wB:</td>
      <td><div class="div2" id="wB" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>wK:</td>
      <td><div class="div2" id="wK" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>wN:</td>
      <td><div class="div2" id="wN" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>wP:</td>
      <td><div class="div2" id="wP" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>wQ:</td>
      <td><div class="div2" id="wQ" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	
		<td>wR:</td>
      <td><div class="div2" id="wR" ondrop="drop(event)" ondragover="allowDrop(event)"></div></td>
	</tr>
	</table>
<br>
	<input type="text" name="themeName" id="themeName" placeholder="Name Of Theme"> 
	<div class="div2" id="blank" ondrop="drop(event)" ondragover="allowDrop(event)" style="float:right; margin-right:10%">Trash</div><br><br>
	<input type="button" value="Save" class="submitButton" onclick="gatherThemeNames();"></center>
<div class="header"><h2>&nbsp&nbspEdit Existing Theme</h2></div>
<table id="existingThemeTable" style="width: 100%">
	<tbody>
		<tr>
			<th>Name</th>
			<th></th>
			<th></th>
		</tr>
		<?php
			$path = "img/chesspieces";
			$dirs = glob($path . '/*', GLOB_ONLYDIR);
			foreach($dirs as $value){
				echo("<tr id=\"".basename($value)."\" class='themeRow'>
							<td>".basename($value)."</td>
							<td><a href=\"#\" onclick=\"javascript:loadTheme('".basename($value)."')\">Edit</td>
							<td><a href=\"#\" onclick=\"javascript:deleteTheme('".basename($value)."')\">Delete</td>
						</tr>");
			}
		?>
	</tbody>
</table>
</form>


<form action="addImage.php" method="post" enctype="multipart/form-data" class="form-add-right">
<center>
<input type="file" name="newImage">
<!-- Have this call a Javascript function to upload the image instead of posting the data. -->
<input type="submit" value="Add Image" class="submitButton">
<br>
</center>
</form>
<div id="list" class="form-add-right">
<div class="header"><h2>&nbsp&nbspAvailable Images</h2></div>
<div id="div3" name="deletion" ondrop="deldrop(event)" ondragover="allowDrop(event)"> <img src="img/trash.png"></div>
</div>
</body>
</html>

<?php

include("CloseSession.php");

?>
