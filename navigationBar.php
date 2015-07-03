<?php
$pg = basename($_SERVER['PHP_SELF']);
if($_SESSION['adr'] == 1){
	if($pg == "admin_home.php"){
		echo "
			<nav><ul id='tabNav'>
			<li class='current'><a href='admin_home.php'>Admin Home</a></li>
			<li><a href='sess_log.php'>Session Log</a></li>
			<li><a href = 'theme.php'>Theme Manager</a></li>
			<li><a href = 'logout.php'>Logout</a></li>
			</ul></nav> ";
	}
		if($pg == "sess_log.php"){
			echo "
				<nav><ul id='tabNav'>
				<li><a href='admin_home.php'>Admin Home</a></li>
				<li class='current'><a href='sess_log.php'>Session Log</a></li>
				<li><a href = 'theme.php'>Theme Manager</a></li>
				<li><a href = 'logout.php'>Logout</a></li>
				</ul></nav> ";
	}

	    if($pg == "theme.php"){
         echo "
            <nav><ul id='tabNav'> 
            <li><a href='admin_home.php'>Admin Home</a></li>
            <li><a href='sess_log.php'>Session Log</a></li>
            <li class='current'><a href = 'theme.php'>Theme Manager</a></li>
            <li><a href = 'logout.php'>Logout</a></li>
            </ul></nav> ";
   }
}

else{
echo "
	<nav><ul id='tabNav'>
	<li><a href='sess_log.php'>Session Log</a></li>
	<li><a href = 'logout.php'>Logout</a></li>
	</ul></nav> ";

}
?>
