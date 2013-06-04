
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bulltin Board</title>
</head>

<style type="text/css">
.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 400px;margin-top: 10px;}
.myTable th { background-color:lightskyblue;color:black;}
.myTable td, .myTable th { padding:5px;border:1px solid red;width: 300px;}
</style>

<body>
    <label style="color: blue;font-size: 18px;">Login Account</label><br><br>
    
        <label>Create New User Account</label>        
        <form method="get" action="index.php">
        <table class="myTable">
          
            <tr><td>Username</td>
                <td> <input type="text" id="usename" name="username" style="
                border-width: 2px;border-style:inset;border-color: lightskyblue;
                width: 200px;height: 25px;"/></td>
            </tr>
          
            <tr><td>Password</td>
              <td> <input type="password" id="password" name="password" style="
                border-width: 2px;border-style:inset;border-color: lightskyblue;
                width: 200px;height: 25px;"/></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="Creat New User" style="font-size: 16px;margin-left: 120px;
                border-color: lightskyblue;width: 164px;background-color: lightskyblue;margin-top: 10px;"/>
    </form><br><br>
    
    <?php
      if(isset($_GET['submit'])){
        $password=$_GET['password'];
          session_start(); 
          
 
        if ($password !== "Chan")
        {
          //$password=NULL;
           header("Location: home.php");
           
        }
        }
          
//       // echo 'Success User Checked.';
//        $user="root";
//        $password="";
//        $database="TRAINING01";
//        mysql_connect(localhost,$user,$password);
//        @mysql_select_db($database) or die( "Unable to select database");
//
//        $username=$_GET[username];
//        $password= base64_encode($_GET[password]);
//        
//        if($username1!="" && $password3!=""){
//          $qdata="SELECT * FROM Login WHERE Password='$password3'";
//            if (mysql_query($qdata))
//            {
//              echo 'OK';
//              //redirect(login.php, 'refresh');
//              header( 'Location: http://www.google.com' ) ;
//
//            }
//            else
//            {
//              echo "Error creating table: ".mysql_error();
//            }
//            
//        }
//        else {
//          echo 'Enter Username and Password Correctly.';
//        }
      
    ?>
    
   
</body>
</html>