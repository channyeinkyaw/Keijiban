<?php
    $control = False;
    $control2 = False;
	if (isset($_COOKIE['errordata'])){
        $control= True;
        setcookie('errordata',$_COOKIE['errordata'],time()-3600);
	}else{
		$control= False;
        setcookie('errordata',$_COOKIE['errordata'],time()-3600);
	}
    
    if (isset($_COOKIE['errordata2'])){
        $control2= True;
        setcookie('errordata2',$_COOKIE['errordata2'],time()-3600);
	}else{
		$control2= False;
        setcookie('errordata2',$_COOKIE['errordata2'],time()-3600);
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bulletin Board</title>
<link rel="stylesheet" type="text/css" href="loginstyle.css" />
</head>

<style type="text/css">
.main{
	margin-right:auto;
    margin-left:auto;
    width:550px;
    background-color: white;
    margin:0 auto;
}  

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
<div class="main">
<div id="login">
  <h2 style="color: blue;margin-left: 7%;">掲示板システム　新規会員登録</h2>
  <?php
    if($control == True){ echo '入力内容が正しくありません。';}
    if($control2 == True){ echo 'このユーザー名は使用されています。<br>他のユーザー名を指定してください。';}
  ?>
  <form action="logincheck.php" method="post">
    <table class="myTable">
      <tr><td>ユーザー名</td>
          <td><input type="text" name="username" /></td>
      </tr>
      <tr><td>パスワード</td>
          <td><input type="password" name="password" /></td>
      </tr>
      <tr><td>パスワード(確認)</td>
          <td><input type="password" name="conf_password" /></td>
      </tr>
    </table>

     <input type="submit" name="submit" value="送信" 
            style="background-color: lightskyblue;margin-top: 20px;margin-left: 38.5%;height: 40px;font-size: 18px;"</>
       <br><br>
       <labe><a style="color: red"href="login.php">LOG IN</a></labe>
  </form>
  
</div>
</div>
</body>
</html>