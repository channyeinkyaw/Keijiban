<?php
	
    session_start();
    $control= False;
	if (isset($_COOKIE['errordata'])){
        $control= True;
        setcookie('errordata',$_COOKIE['errordata'],time()-3600);
	}else{
		$control= False;
        setcookie('errordata',$_COOKIE['errordata'],time()-3600);
	}
    //$control= False;
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bulletin Board</title>
<link rel="stylesheet" type="text/css" href="loginstyle.css" />
</head>

<style type="text/css">
#login{
	margin: 5px 40px;
	background:white;
	border:1px solid lightskyblue;
	padding-left: 30px;
	padding-bottom: 20px;
	width: 440px;
    font-family:sans-serif;
}
#login p{
	margin: 5px;
}
label{
	padding-left: 5px;
}
input{
    font-family:sans-serif;
    font-size: 14px;
	border:1px solid lightskyblue;
    background: white;
    border-width: 2px;
    border-style:inset;width: 200px;height: 25px;
    margin-left: 10px;
}
.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 430px;margin-top: 10px;}
.myTable th { background-color:lightskyblue;color:black;}

</style>  

<body>
<div id="login">
  <h2 style="color: blue">Create Account For Bulletin Board</h2>
  <?php
    if($control == True){
      echo 'enter data correctly';
    }
  ?>
<form action="logincheck.php" method="post">
  <table class="myTable">
    <tr><td>Username</td>
        <td><input type="text" name="username" /></td>
    </tr>
    <tr><td>Password</td>
        <td><input type="password" name="password" /></td>
    </tr>
    <tr><td>Confirm Password</td>
        <td><input type="password" name="conf_password" /></td>
    </tr>
  </table>
	
   <input type="submit" name="submit" value="Create Account" 
          style="background-color: lightskyblue;margin-top: 20px;margin-left: 85px;height: 40px;font-size: 18px;"</>
     <br><br>
     <labe><a href="">Create New Account</a></labe>
</form>
</div>
</body>
</html>