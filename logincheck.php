<?php
	$con=mysql_connect("localhost","root","")
       or die("Cannot connect to databases!");
	mysql_select_db("PHP",$con);
    
    if($_POST['submit']=='Create Account'){
      $new_user=$_POST['username'];
      $new_pass=$_POST['password'];
      $new_confpass=$_POST['conf_password'];
      if(!empty($new_user)&& !empty($new_pass) && !empty($new_confpass) && ($new_pass == $new_confpass)){
        $new_secure=sha1($new_confpass);
        $edit = "INSERT INTO Users (ID,Username,Password) VALUES ('','$new_user','$new_secure')";
        mysql_query($edit);
        mysql_close();
        header("location: login.html");
      }
      else{
//        $error='error';
//        $_SESSION['data']=$error;
    setcookie('errordata','ERROR');
        header("location: newacc.php");
        
        //echo 'Enter';
      }
      
    }
    else{
    
      $u=$_POST['uname'];
      $p=$_POST['passwd'];
      $login_pass=  sha1("$p");
      $query=mysql_query("
           SELECT * FROM Users WHERE Username='$u' and Password='$login_pass'
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
    }
?>