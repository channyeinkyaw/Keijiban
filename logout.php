<?php
	session_start();
	if (isset($_SESSION['user'])){
        setcookie('errordata',$_COOKIE['errordata'],time()-3600);
		session_destroy();
		header("location: login.html");
	}
	else{
		header("location: login.html");
	}
?>