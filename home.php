<?php
	session_start();
	if (isset($_SESSION['user'])){
		echo "Welcome,".$_SESSION['user']."<br />
                    [ <a href=\"logout.php\">Logout</a> ]";
	}else{
		echo "You are not authorized into this page!";
	}
?>