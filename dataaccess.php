<?php
    session_start();
    require_once 'pdoconnection.php';
	$user_name = '';
	$login = False;
	
	if(isset($_COOKIE['user_name'])){
		$user_name = $_COOKIE['user_name'];
        $get_id = $_COOKIE['submit_id'];
		$login = True;
	}
	else{
		$login = False;
	}

	if($login == True){
		
		if(isset($_POST['submit']) && $_POST['submit']=='送信'){
			$new_bulletin=$_POST['title'];
			if(empty($new_bulletin)){
              $_SESSION['new_board'] = '掲示板名 を入力してから 送信 ボタンを押してください。';
              
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: '.$url);
              exit;
			}
			else{
              date_default_timezone_set('Asia/Tokyo');
              $now_datetime = date('Y-m-d H:i:s');
              try {
                      $dbh->exec("INSERT INTO Board (id,title,created_at) VALUES (NULL,'$new_bulletin','$now_datetime')");
                  }
                  catch(PDOException $e)
                  {
                      echo $e->getMessage();
                  }
              $user_name = "";
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
              header("HTTP/1.1 301 Moved Permanently");
              header('Location: '.$url);
              exit;
            }
        }
		elseif(isset($_POST['submit']) && $_POST['submit']=='コメント書く'){
          setcookie('submit_id',$_POST['board_id']);
          setcookie('submit_title',$_POST['board_title']);
          $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
          header("HTTP/1.1 301 Moved Permanently");
          header('Location: '.$url);
          exit;
		}
        elseif(isset($_POST['submit']) && $_POST['submit']=='コメント送信'){
          $contents=$_POST['comment'];
          date_default_timezone_set('Asia/Tokyo');
          $created=date('Y-m-d H:i:s');
          if(isset($_REQUEST['submit'])){
                 if($contents==""){
                    $_SESSION['comment_error'] = 'コメント を入力してから コメント送信 ボタンを押してください。';
                    $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.$url);
                    exit;
                 }
                 else{
                   try {
                    $dbh->exec("INSERT INTO Comment (board_id,contents,created_at,user_name) 
                                VALUES ('$get_id','$contents','$created','$user_name')");
                    $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
					header("HTTP/1.1 301 Moved Permanently");
					header('Location: '.$url);
					exit;
                   }
                   catch(PDOException $e)
                   {
                    echo $e->getMessage();
                   }
                 }
          }
        }
        elseif (isset ($_POST['submit']) && $_POST['submit']=='削除') {
          $com_deleteid=$_POST['delete_id'];
          try {
            $dbh->exec("DELETE FROM Comment WHERE id = $com_deleteid");
            $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: '.$url);
            exit;
          }
          catch(PDOException $e)
          {
            echo $e->getMessage();
          }
        }
        elseif (isset ($_POST['submit']) && $_POST['submit']=='編集') {
            $_SESSION['show'] = 'text';
            $_SESSION['button'] = 'submit';
            $_SESSION['edit_data'] = $_POST['edit_data'];
            $_SESSION['edit_id'] = $_POST['edit_id'];
            $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
            header("HTTP/1.1 301 Moved Permanently");
            header('Location: '.$url);
            exit;
        }
        elseif (isset ($_POST['submit']) && $_POST['submit']=='コメント編集') {
            $updatevalue=$_POST['editcomment'];
            $com_editid=$_POST['editid'];
            try {
              $dbh->exec("UPDATE Comment SET contents = '$updatevalue' WHERE id = $com_editid");
              $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
                      header("HTTP/1.1 301 Moved Permanently");
                      header('Location: '.$url);
                      exit;
            }
            catch(PDOException $e)
            {
              echo $e->getMessage();
            }
        }
        elseif (isset ($_POST['submit']) && $_POST['submit']=='検索') {
            $search=$_POST['search'];
            $qdata1=array();
            $qdata2=array();
            $qdata3=array();
            $qdcount=array();
            $i=0;
          
            if(empty($search)){
                $_SESSION['search_error'] = '検索したい時は　掲示板名 を入力してから 送信 ボタンを押してください。';
                $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: '.$url);
                exit;
            }else{
              try {
                  $sql = "SELECT * FROM Board WHERE title LIKE '$search%' ORDER BY id ASC";
                  $sResult = $dbh->query($sql)->fetchAll();
                  if(count($sResult)>0){
                    foreach ($dbh->query($sql) as $row){
                      $_SESSION['search_get'] = 'found';
                      $qdata1[$i]=$row['id'];
                      $qdata2[$i]=$row['title'];
                      $qdata3[$i]=$row['created_at'];

                      $id=$row['id'];

                      $sQuery = "SELECT id FROM Comment WHERE board_id=$id";
                      $rResult = $dbh->query($sQuery)->fetchAll();
                      $qdcount[$i]=count($rResult);
                      $i++;

                    }
                    $_SESSION['data1']=$qdata1;
                    $_SESSION['data2']=$qdata2;
                    $_SESSION['data3']=$qdata3;
                    $_SESSION['count']=$qdcount;
                    $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.$url);
                    exit;
                  }else{
                    $_SESSION['nodata'] = 'データを見つけません!';
                    $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/index.php';
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.$url);
                    exit;
                  }
                }
                catch(PDOException $e)
                {
                  echo $e->getMessage();
                }
            } 
        }
     }
     
     if($login==False){
      $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
      header("HTTP/1.1 301 Moved Permanently");
      header('Location: '.$url);
      exit;
    }
?>