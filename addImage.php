
<?php
	$allowedExts = array("gif", "png", "jpeg", "jpg");

   $store = "./img/imgStore/";

	if(!file_exists($path)){
		echo "Image added successfully!";
		if(filesize($_FILES["newImage"]["tmp_name"]) > 5242880)
		{
			 echo "Image too large (>5MB)";
		} else {

	      move_uploaded_file($_FILES["newImage"]["tmp_name"], $store . "/" . $_FILES["newImage"]["name"]);
			header("Location: ".$_SERVER["HTTP_REFERER"]);

			// If a browser doesn't support this for some reason...

			echo "Your browser should take you back automatically.<br>If not... <a href=\"javascript:history.go(-1)\">click here</a>.";

		}
	} else {
		echo "Image already in database!";
	}	
?>

