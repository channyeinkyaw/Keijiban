<?php
    require_once 'databaseconnection.php';
    
    $login = False;
    $show='hidden';
    $button='hidden';
	session_start();
	if (isset($_SESSION['user'])){
		echo "<font color='blue'>Welcome ".strtoupper($_SESSION['user'])."</font>".
                " [ <a href=\"main.php\">Home</a> ]".
                    "[ <a href=\"logout.php\">Logout</a> ]";
        $login = True;
        $idno=$_SESSION['board_id'];
        $comment_user=$_SESSION['user'];
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
               $edit = "INSERT INTO Comment (board_id,contents,created_at,user_name) 
                 VALUES ('$idno','$contents','$created','$comment_user')";
               mysqli_query($db,$edit);
               }
        }
        
    }
    elseif (isset ($_POST['submit']) && $_POST['submit']=='削除') {
      $com_deleteid=$_POST['delete_id'];
      $query = "DELETE FROM Comment WHERE id = $com_deleteid";
      $result = mysqli_query($db,$query) or die('ERROR!(削除):MySQLサーバーへの接続に失敗しました。');
    }
    elseif (isset ($_POST['submit']) && $_POST['submit']=='編集') {
      $show='text';
      $button='submit';
      $value=$_POST['edit_data'];
      $eid=$_POST['edit_id'];
    }
    elseif (isset ($_POST['submit']) && $_POST['submit']=='Updated') {
      //$show='text';
      $updatevalue=$_POST['editcomment'];
      $com_editid=$_POST['editid'];
      $updatequrey = "UPDATE Comment SET contents = '$updatevalue' WHERE id = $com_editid";
      $result = mysqli_query($db,$updatequrey) or die('Data base error occur');
      $idno=$_SESSION['board_id'];
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

.pg-normal {
color: #000000;
font-size: 15px;
cursor: pointer;
background: lightskyblue;
padding: 2px 4px 2px 4px;
}

.pg-selected {
color: #fff;
font-size: 15px;
background: #000000;
padding: 2px 4px 2px 4px;
}

</style>
  
<script type="text/javascript">

function Pager(tableName, itemsPerPage) {

this.tableName = tableName;

this.itemsPerPage = itemsPerPage;

this.currentPage = 1;

this.pages = 0;

this.inited = false;

this.showRecords = function(from, to) {

var rows = document.getElementById(tableName).rows;

// i starts from 1 to skip table header row

for (var i = 1; i < rows.length; i++) {

if (i < from || i > to)

rows[i].style.display = 'none';

else

rows[i].style.display = '';

}

};

this.showPage = function(pageNumber) {

if (! this.inited) {

alert("not inited");

return;

}

var oldPageAnchor = document.getElementById('pg'+this.currentPage);

oldPageAnchor.className = 'pg-normal';

this.currentPage = pageNumber;

var newPageAnchor = document.getElementById('pg'+this.currentPage);

newPageAnchor.className = 'pg-selected';

var from = (pageNumber - 1) * itemsPerPage + 1;

var to = from + itemsPerPage - 1;

this.showRecords(from, to);

};

this.prev = function() {

if (this.currentPage > 1)

this.showPage(this.currentPage - 1);

};

this.next = function() {

if (this.currentPage < this.pages) {

this.showPage(this.currentPage + 1);

}

};

this.init = function() {

var rows = document.getElementById(tableName).rows;

var records = (rows.length - 1);

this.pages = Math.ceil(records / itemsPerPage);

this.inited = true;

};

this.showPageNav = function(pagerName, positionId) {

if (! this.inited) {

alert("not inited");

return;

}

var element = document.getElementById(positionId);

var pagerHtml = '<span onclick="' + pagerName + '.prev();" class="pg-normal"> « Prev </span> ';

for (var page = 1; page <= this.pages; page++)

pagerHtml += '<span id="pg' + page + '" class="pg-normal" onclick="' + pagerName + '.showPage(' + page + ');">' + page + '</span> ';

pagerHtml += '<span onclick="'+pagerName+'.next();" class="pg-normal"> Next »</span>';

element.innerHTML = pagerHtml;

};

}

</script>

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
            
      <table id="tablepaging"class="myTable">
        <tr>

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
            //$f2=$data['board_id'];
            $f3=$data['contents'];
            $f4=$data['created_at'];
            $f5=$data['user_name'];
          ?>
          <tr style="height:70px;">
            <td><?php echo $f3 ?></td>
          <td><?php echo $f4; ?></td>
          <td><?php echo $f5; ?></td>
          <td style="width:30%;"><?php if($login == True && $f5 == $comment_user){
              $delete_button = '<form method="post" action="'.$_SERVER['PHP_SELF'].'" >'.
                               '<input type="hidden" value="'.$f1.'" name="delete_id" />'.
                               '<input type="submit" value="削除" name="submit" style="font-size: 16px;margin-top:3%;
                  margin-left: 7%;border-color: lightskyblue;width: 80px;background-color: lightskyblue;"/>'?><?php

              $edit_button =  '<input type="hidden" value="'.$f1.'" name="edit_id" />'.
                              '<input type="hidden" value="'.$f3.'" name="edit_data" />'.
                              '<input type="submit" value="編集" name="submit" style="font-size: 16px;margin-left: 5%;
                                 border-color: lightskyblue;width: 80px;background-color: lightskyblue;"/>'.
                              '</form>';

          }
          else{
              $delete_button = '---';
              $edit_button = '---';
          }
              echo $delete_button.$edit_button;
          ?></td>
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
      <div id="pageNavPosition" style="padding-top: 20px" align="left"></div>
        
      <script type="text/javascript"><!--
      var pager = new Pager('tablepaging', 2);
      pager.init();
      pager.showPageNav('pager', 'pageNavPosition');
      pager.showPage(1);
      </script>
      
      <br>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="<?php echo $show ?>" id="editcomment" name="editlabel" style="
                  border:0px;width: 400px;" value="Data Editing of <?php echo $_SESSION['board_title'] ?>"/>
        
        <input type="hidden" id="editid" name="editid" value="<?php echo $eid?>"/>
        <br>
        <input type="<?php echo $show ?>" id="editcomment" name="editcomment" style="
                  border-width: 2px;border-style:inset;border-color: lightskyblue;
                  width: 400px;height: 50px;" value="<?php echo $value ?>"/>
          
        <input type="<?php echo $button ?>" value="Updated" name="submit" style="font-size: 16px;margin-top: 0px;
                  margin-left: 30px;border-color: lightskyblue;width: 80px;background-color: lightskyblue;"/>
      </form>
</body>
</html>