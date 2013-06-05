<?php
    require_once 'databaseconnection.php';
    $db = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die('ERROR!(connect):MySQLサーバーへの接続に失敗しました。');
    mysqli_query($db,"SET NAMES latin1");
    $login = False;
	session_start();
	if (isset($_SESSION['user'])){
		echo "<font color='blue'>Welcome ".strtoupper($_SESSION['user'])."</font>".
                " [ <a href=\"main.php\">Home</a> ]".
                    "[ <a href=\"logout.php\">Logout</a> ]";
        $login = True;
        //echo $login;
	}else{
		echo "You are not authorized into this page!";
        $login = False;
	}
    
    if(isset($_POST['submit']) && $_POST['submit']=='Creat New Comment'){
        $idno=$_SESSION['board_id'];
        $comment_user=$_SESSION['user'];
        //$contents=$_POST['comment'];
        $contents=mysqli_real_escape_string($db,trim($_POST['comment']));
        date_default_timezone_set('Asia/Tokyo');
        $created=date('Y-m-d H:i:s');
        if(isset($_REQUEST['submit'])){
               if($contents==""){
                 echo 'Enter Comments';
               }
               else{
               $edit = "INSERT INTO Comment (board_id,contents,created_at,user_name) VALUES ('$idno','$contents','$created','$comment_user')";

               mysqli_query($db,$edit);
               
               }
        }
    }
    elseif (isset ($_POST['submit']) && $_POST['submit']=='削除') {
      $com_deleteid=$_POST['delete_id'];
      $query = "DELETE FROM Comment WHERE id = $com_deleteid";
      $result = mysqli_query($db,$query) or die('ERROR!(削除):MySQLサーバーへの接続に失敗しました。');
      $idno=$_SESSION['board_id'];
      $comment_user=$_SESSION['user'];
    }
    else {
      $idno=$_SESSION['board_id'];
      $comment_user=$_SESSION['user'];
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bulletin Board</title>
</head>

<style type="text/css">
.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 700px;margin-top: 10px;}
.myTable th { background-color:lightskyblue;color:black;}
.myTable td, .myTable th { padding:5px;border:1px solid yellow;width: 300px;}
</style>

<body>
  <br><br><label style="color: blue;font-size: 18px;">Comment of 
      <font style="color: red"><?php
        if(isset($_POST['submit'])){
          echo $_SESSION['board_title'].'<font style="color:blue"> of </font>'.strtoupper($_SESSION['user']);
        }
        else{
            echo $_SESSION['board_title'].'<font style="color:blue"> of </font>'.strtoupper($_SESSION['user']);
        }
        
        ?></font>
        Bulletin Board</label><br><br>
            
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> 
                
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                
                Write New Comment<br><input type="text" id="comment" name="comment" style="
                border-width: 2px;border-style:inset;border-color: lightskyblue;
                width: 400px;height: 50px;"/><br>
            
                <input type="submit" name="submit" value="Creat New Comment" style="font-size: 16px;margin-top: 10px;
                border-color: lightskyblue;width: 180px;background-color: lightskyblue;"/>
                
          </form>
            
      <table class="myTable">
      <tr>
      <th><font face="Arial, Helvetica, sans-serif">ID</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Board ID</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Contents</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Created Date</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Created User</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Option</font></th>
      </tr>

      <?php
      $query="SELECT * FROM Comment WHERE board_id=$idno";
      $result=mysqli_query($db,$query);
      $num=  mysqli_num_rows($result);

      if($num!=0){
        while($data=  mysqli_fetch_array($result)){
          $f1=$data['id'];
          $f2=$data['board_id'];
          $f3=$data['contents'];
          $f4=$data['created_at'];
          $f5=$data['user_name'];
        ?>
        <tr>
        <td><?php echo $f1; ?></td>
        <td><?php echo $f2; ?></td>
        <td><?php echo $f3; ?></td>
        <td><?php echo $f4; ?></td>
        <td><?php echo $f5; ?></td>
        <td><?php if($login == True && $f5 == $comment_user){
			$delete_button = '<form method="post" action="'.$_SERVER['PHP_SELF'].'" >'.
		                     '<input type="hidden" value="'.$f1.'" name="delete_id" />'.
		                     '<input type="submit" value="削除" name="submit" style="font-size: 16px;margin-top: 15px;
                margin-left: 30px;border-color: lightskyblue;width: 80px;background-color: lightskyblue;"/>'.
                             '</form>';
		}
		else{
			$delete_button = '---';
		} echo $delete_button?></td>
        </tr>
        <?php
        }
        
      }
      else {
        echo "<font color='red'>No Comments at this Bulltin Board.</font>";
      }
      mysqli_close($db);
      ?>
        </table>   
</body>
</html>