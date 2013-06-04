<?php
	session_start();
	if (isset($_SESSION['user'])){
        
		echo "<font color='blue'>Welcome ".$_SESSION['user']."</font>".
                    "[ <a href=\"logout.php\">Logout</a> ]";
	}else{
		echo "You are not authorized into this page!";
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bulltin Board</title>
</head>

<style type="text/css">
.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 600px;margin-top: 10px;}
.myTable th { background-color:lightskyblue;color:black;}
.myTable td, .myTable th { padding:5px;border:1px solid yellow;width: 300px;}
</style>

<body>
      
  
  <br><label style="color: blue;font-size: 18px;">Bulletin Board</label><br><br>
          <?php $user="root";
                      $password="";
                      $database="PHP";
                      mysql_connect(localhost,$user,$password);
                      @mysql_select_db($database) or die( "Unable to select database");?>

          <form method="get" action="main.php">
              <table class="myTable">  
                  <tr><td>
                      Bulltin Board Title <input type="text" id="title" name="title" style="
                      border-width: 2px;border-style:inset;border-color: lightskyblue;
                      width: 200px;height: 25px;"/>

                      <input type="submit" name="submit" value="Creat New Board" style="font-size: 16px;margin-left: 10px;
                      border-color: lightskyblue;width: 164px;background-color: lightskyblue;"/>
                  </td></tr>
              </table>

          </form>

          <table class="myTable">
              <tr>
                  <th>ID</th>
                  <th>Title</th>
                  <th>Creation Date</th>
                  <th>Comments</th>
              </tr>

              <?php
              $title=$_GET['title'];
              date_default_timezone_set('Asia/Tokyo');
              $created=date('Y-m-d H:i:s');

              if(isset($_GET['submit'])){

                if($title==""){
                    echo 'Enter Bulletin Title.';
                  }
                else{
                  $edit = "INSERT INTO Board VALUES
                      ('','$title','$created')";

                  mysql_query($edit);

                }
              }
                  $query="SELECT * FROM Board ORDER BY id DESC";
                  $result=mysql_query($query);
                  $num2=mysql_numrows($result);

                  if($num2!=0){
                  $i=0;
                  while ($i < $num2) {

                  $f1=mysql_result($result,$i,"id");
                  $f2=mysql_result($result,$i,"title");
                  $f3=mysql_result($result,$i,"created_at");

                  $qcomment="SELECT id FROM Comment WHERE board_id=$f1";
                  $cresult=mysql_query($qcomment);
                  $num3=mysql_numrows($cresult);

              ?>  
                  <tr>
                  <td><?php echo $f1; ?></td>
                  <td><?php echo $f2; ?></td>
                  <td><?php echo $f3; ?></td>
                  <td>
                      (<?php echo $num3?>nos) 
                      <a href="comment.php?id=<?php echo $f1?> & title= <?php echo $f2?>">See Comment</a> </td>            
                  </tr>
              <?php
                  $i++;
                  }
                  }
                  else{
            echo "<font color='red'>No Bulletin Board</font>";
          }
              ?>
          </table>
    
</body>
</html>