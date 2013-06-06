<?php
    require_once 'databaseconnection.php';
    
//    $db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die('ERROR!(connect):MySQLサーバーへの接続に失敗しました。');
//		mysqli_query($db,"SET NAMES latin1");
    
    if($_POST['submit']=='Create Account'){
      $new_user=$_POST['username'];
      $new_pass=$_POST['password'];
      $new_confpass=$_POST['conf_password'];
      if(!empty($new_user)&& !empty($new_pass) && !empty($new_confpass) && ($new_pass == $new_confpass)){
        $new_secure=sha1($new_confpass);
        $edit = "INSERT INTO Users (ID,Username,Password) VALUES ('','$new_user','$new_secure')";
        mysqli_query($db,$edit);
        mysqli_close($db);
        header("location: login.html");
      }
      else{
        setcookie('errordata','ERROR');
        header("location: newacc.php");
      }
      
    }
    else{
    
      $u=$_POST['uname'];
      $p=$_POST['passwd'];
      $login_pass=  sha1("$p");
      
      $query = "SELECT * FROM  Users WHERE Username = '$u' and Password = '$login_pass'";
				$result = mysqli_query($db,$query) or die('ERROR!(query):MySQLサーバーへの接続に失敗しました。');
				$row = mysqli_fetch_array($result);
      if (mysqli_num_rows($result) == 1){
          session_start();
          $_SESSION['user']=$row['Username'];
          header("location: main.php");
      }else{
          header("location: login.html");
      }
    }
?>