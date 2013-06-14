<?php
	$error_message = "";
    require_once('dbsettings.php');
   	
	if(!isset($_COOKIE['user_name'])){
		if(isset($_POST['submit'])&& $_POST['submit']=='ログイン'){
	
			$user_name = $_POST['user_name'];
			$password = sha1($_POST['password']) ;
			if(!empty($user_name) && !empty($password)){
				$query = "SELECT Username FROM users WHERE Username='$user_name' AND password='$password'";
				$result = mysqli_query($db,$query);
				if(mysqli_num_rows($result) == 1){
					$row = mysqli_fetch_array($result);
					setcookie('user_name',$row['Username']);
					$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
					header('Location: '.$url);
					exit;
				}
				else{
                  $error_message = "error1";
                  setcookie('error1',$error_message);
                  $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
                  header('Location: '.$url);
                  exit;	
				}
			}
			else{
              $error_message = "error2";
              setcookie('error2',$error_message);
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
              header('Location: '.$url);
              exit;
			}
			mysqli_close($db);
		}
        if(isset($_POST['submit'])&& $_POST['submit']=='送信'){
          $new_user=$_POST['username'];
          $new_pass=$_POST['password'];
          $new_confpass=$_POST['conf_password'];
          if(!empty($new_user)&& !empty($new_pass) && !empty($new_confpass) && ($new_pass == $new_confpass)){
            $query = "SELECT * FROM users WHERE Username='$new_user'";
			$result = mysqli_query($db,$query);
            $new_secure=sha1($new_confpass);
            if(mysqli_num_rows($result) == 0){
              $edit = "INSERT INTO Users (ID,Username,Password) VALUES ('','$new_user','$new_secure')";
              mysqli_query($db,$edit);
              mysqli_close($db);
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
                      header('Location: '.$url);
            }else{
              setcookie('errordata2','ERROR');
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/newacc.php';
                      header('Location: '.$url);
              //header("location: newacc.php");					
			}
          }
          else{
            setcookie('errordata','ERROR');
            $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/newacc.php';
                      header('Location: '.$url);
            header("location: newacc.php");
          }
        }
	}else{
      $error_message = "error3";
      setcookie('error3',$error_message);
      $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
      header('Location: '.$url);
      exit;
	}
?>
