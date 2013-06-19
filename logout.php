<?php
	if(isset($_COOKIE['user_name'])){
        setcookie('user_name',$_COOKIE['user_name'],time()-3600);
        setcookie('submit_id',$_COOKIE['submit_id'],time()-3600);
        setcookie('submit_title',$_COOKIE['submit_title'],time()-3600);
	}
	$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
	header('Location: '.$url);
	exit;
?>
