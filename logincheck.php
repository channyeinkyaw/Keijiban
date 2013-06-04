<?php
	$con=mysql_connect("localhost","root","")
       or die("Cannot connect to databases!");
	mysql_select_db("PHP",$con);

	$u=$_POST['uname'];
	$p=$_POST['passwd'];
	$query=mysql_query("
         SELECT * FROM Users WHERE Username='$u' and Password='$p'
        ");
	$row=mysql_num_rows($query);
	if ($row == 1){
		session_start();
		$a=mysql_fetch_array($query);
		$_SESSION['user']=$a['Username'];
		header("location: main.php");
	}else{
		header("location: login.html");
	}
?>