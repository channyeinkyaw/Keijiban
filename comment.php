<?php
	session_start();
	if (isset($_SESSION['user'])){
        //echo "[ <a href=\"main.php\">Home</a> ]";
		echo "<font color='blue'>Welcome ".$_SESSION['user']."</font>".
                "[ <a href=\"main.php\">Home</a> ]".
                    "[ <a href=\"logout.php\">Logout</a> ]";
        
	}else{
		echo "You are not authorized into this page!";
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
            $name=$_REQUEST['title'];echo $name;
            
        ?></font>
        Bulletin Board</label><br><br>
            
            <form method="post" action="comment.php"> 
                <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
                
                Write New Comment<br><input type="text" id="comment" name="comment" style="
                border-width: 2px;border-style:inset;border-color: lightskyblue;
                width: 400px;height: 50px;"/><br>
            
                <input type="submit" name="submit" value="Creat New Comment" style="font-size: 16px;margin-top: 10px;
                border-color: lightskyblue;width: 180px;background-color: lightskyblue;"/>
                
          </form>
                   
     <?php
     $username="root";
     $password="";
     $database="PHP";
     
     $idno=$_REQUEST['id'];
     $contents=$_REQUEST['comment'];
     date_default_timezone_set('Asia/Tokyo');
     $created=date('Y-m-d H:i:s');

     mysql_connect(localhost,$username,$password);
     @mysql_select_db($database) or die( "Unable to select database");
     
     if(isset($_REQUEST['submit'])){
            if($contents==""){
              echo 'Enter Comments';
            }
            else{
            $edit = "INSERT INTO Comment (board_id,contents,created_at) VALUES ('$idno','$contents','$created')";

            mysql_query($edit);
            mysql_close();
            }
     }
     ?>
            
     <?php
      mysql_connect(localhost,$username,$password);
      @mysql_select_db($database) or die( "Unable to select database");
//      $query="SELECT * FROM Comment WHERE board_id=$idno";
//      $result=mysql_query($query);
//
//      $num=mysql_numrows($result);
//
//      mysql_close();
      ?>
      <table class="myTable">
      <tr>
      <th><font face="Arial, Helvetica, sans-serif">ID</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Board ID</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Contents</font></th>
      <th><font face="Arial, Helvetica, sans-serif">Created Date</font></th>

      </tr>

      <?php
      $query="SELECT * FROM Comment WHERE board_id=$idno";
      $result=mysql_query($query);

      $num=mysql_numrows($result);

      //mysql_close();
      $j=0;
      while ($j < $num) {

      $f1=mysql_result($result,$j,"id");
      $f2=mysql_result($result,$j,"board_id");
      $f3=mysql_result($result,$j,"contents");
      $f4=mysql_result($result,$j,"created_at");
      
      ?>
      <tr>
      <td><?php echo $f1; ?></td>
      <td><?php echo $f2; ?></td>
      <td><?php echo $f3; ?></td>
      <td><?php echo $f4; ?></td>
      </tr>
      <?php
      $j++;
      }
          if($num==0){
            echo "<font color='red'>No Comments at this Bulltin Board.</font>";
          }
        
      ?>
        </table>   
</body>
</html>