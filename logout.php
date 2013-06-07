<?php

	if(isset($_COOKIE['user_name'])){
        require_once 'clearcookie.php';
	}
	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
	header('Location: '.$url);
	exit;

?>
