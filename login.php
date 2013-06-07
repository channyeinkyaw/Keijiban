<?php
  $error1 = False;
  $error2 = False;
  $error3 = False;
  
  if(isset($_COOKIE['error1'])){
		$error1 = True;
        require_once 'clearcookie.php';
	}
	else{
		$error1 = False;
	}
   
   if(isset($_COOKIE['error2'])){
		$error2 = True;
        require_once 'clearcookie.php';
	}
	else{
		$error2 = False;
	}
  if(isset($_COOKIE['error3'])){
		$error3 = True;
        require_once 'clearcookie.php';
	}
	else{
		$error3 = False;
    }
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>掲示板システム</title>
</head>
  
<style type="text/css">
.main{
	margin-right:auto;
    margin-left:auto;
    width:470px;
    background-color: white;
    margin:0 auto;
}
  
#login{
	margin: 5px 40px;
	background:white;
	border:1px solid lightskyblue;
	padding-left: 30px;
	padding-bottom: 20px;
	width: 360px;
    font-family:sans-serif;
    color:blue;
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
    border-style:inset;width: 200px;height: 35px;
    margin-left: 10px;
}
.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 350px;margin-top: 10px;}
.myTable th { background-color:lightskyblue;color:black;}
</style> 
  
<body>
<div class="main">
<div id="login">
<h2 style="color: blue;margin-left: 8%;">掲示板システム ログイン</h2>

<?php if($error1==True){echo 'ユーザーID、または、パスワードが間違っています。';}
      if($error2==True){echo 'ユーザーIDとパスワードが入力されていません。';}
      if($error3==True){echo '今は ' .$_COOKIE['user_name'].' さんがログインしています。';}
?>

<form action="logincheck.php" method="post">
  <table class="myTable">
    <tr><td>ユーザー名</td>
        <td><input type="text" name="user_name" /></td>
    </tr>
    <tr><td>パスワード</td>
        <td><input type="password" name="password" /></td>
    </tr>
  </table>
	
   <input type="submit" name="submit" value="ログイン" 
          style="background-color: lightskyblue;margin-top: 20px;margin-left: 30%;height: 40px;font-size: 18px;"</>
     <br><br>
         <labe><a style="color: red"href="newacc.php">新規会員登録</a></label>
</form>
</div>
</div>

</body>


</html>