<?php
    require_once('dbsettings.php');
    require_once 'pdoconnection.php';
    
    $login = False;
    $show='hidden';
    $button='hidden';
    
	session_start();
	if(isset($_COOKIE['user_name'])){
		$user_name = $_COOKIE['user_name'];
        $get_title = $_COOKIE['submit_title'];
        $get_id = $_COOKIE['submit_id'];
        $c_error=$_COOKIE['c_error'];
        setcookie('c_error',$_COOKIE['c_error'],time()-3600);
        if(isset($_COOKIE['show'])){
          $show=$_COOKIE['show'];
          $button=$_COOKIE['button'];
          $value=$_COOKIE['value'];
          $eid=$_COOKIE['eid'];
          setcookie('show',$_COOKIE['show'],time()-3600);
          setcookie('button',$_COOKIE['button'],time()-3600);
          setcookie('value',$_COOKIE['value'],time()-3600);
          setcookie('eid',$_COOKIE['eid'],time()-3600);
        }
		$login = True;
	}
	else{
		$login = False;
	} 
    if($login==False){
      $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/login.php';
					header("HTTP/1.1 301 Moved Permanently");
					header('Location: '.$url);
					exit;
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Bulletin Board</title>
</head>

<style type="text/css"> 
.main{
	margin-right:auto;
    margin-left:auto;
    width:700px;
    background-color: white;
    margin:0 auto;
}  

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
<div class="main">
  <img style="width: 100%;"src="images/title.jpg"/>
<!--  <label style="color: blue;font-size: 18px;">掲示板システム</label>-->
  「<a href="index.php">HOME</a>」「<a href="logout.php">LOG OUT</a>」<br><br>
  <label style="color: blue;font-size: 18px;">掲示板
      <font style="color: red"><?php
        echo $get_title;
        ?></font> のコメント</label><br><br>
            
          <form method="post" action="dataaccess.php"> 
<!--                value="<?php echo $_REQUEST['id'] ?>"-->
              <input type="hidden" name="id" >

              コメント書く<br><input type="text" id="comment" name="comment" style="
              border-width: 2px;border-style:inset;border-color: lightskyblue;
              width: 400px;height: 50px;"/><br>

              <input type="submit" name="submit" value="コメント送信" style="font-size: 16px;margin-top: 10px;
              border-color: lightskyblue;width: 180px;background-color: lightskyblue;"/>
          </form>
            
      <?php echo $c_error;?>
            
      <table id="tablepaging"class="myTable">
        <tr>
        <th><font face="Arial, Helvetica, sans-serif">コメント</font></th>
        <th><font face="Arial, Helvetica, sans-serif">修正日</font></th>
        <th><font face="Arial, Helvetica, sans-serif">ユーザー名</font></th>
        <th><font face="Arial, Helvetica, sans-serif">機能</font></th>
        </tr>

        <?php
          $sql = "SELECT * FROM Comment WHERE board_id=$get_id";
          
          $rResult=$dbh->query($sql)->fetchAll();

          if (Count($rResult) > 0) {
              try {        
                foreach ($dbh->query($sql) as $row){
                $f1=$row['id'];
                $f3=$row['contents'];
                $f4=$row['created_at'];
                $f5=$row['user_name'];
              ?>
                <tr style="height:70px;">
                <td><?php echo $f3 ?></td>
                <td><?php echo $f4; ?></td>
                <td><?php echo $f5; ?></td>
                <td style="width:25%;" align="center"><?php $conn='dataaccess.php';
                if($login == True && $f5 == $user_name){
                  $delete_button = '<form method="post" action="'.$conn.'" >'.
                                   '<input type="hidden" value="'.$f1.'" name="delete_id" />'.
                                   '<input type="submit" value="削除" name="submit" style="font-size: 16px;margin-top:3%;
                                    border-color: lightskyblue;width: 60px;background-color: lightskyblue;"/>';

                  $edit_button =  '<input type="hidden" value="'.$f1.'" name="edit_id" />'.
                                  '<input type="hidden" value="'.$f3.'" name="edit_data" />'.
                                  '<input type="submit" value="編集" name="submit" style="font-size: 16px;margin-left: 5%;
                                     border-color: lightskyblue;width: 60px;background-color: lightskyblue;"/>'.
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
                echo '</table>';
              ?>
              <div id="pageNavPosition" style="padding-top: 20px" align="left"></div>

              <script type="text/javascript"><!--
              var pager = new Pager('tablepaging', 2);
              pager.init();
              pager.showPageNav('pager', 'pageNavPosition');
              pager.showPage(1);
              </script>

              <br>
              <form method="post" action="dataaccess.php">
                <input type="<?php echo $show ?>" id="editlabel" name="editlabel" style="
                          border:0px;width: 400px;" value="コメント編集 "/>

                <input type="hidden" id="editid" name="editid" value="<?php echo $eid?>"/>
                <br>
                <input type="<?php echo $show ?>" id="editcomment" name="editcomment" style="
                          border-width: 2px;border-style:inset;border-color: lightskyblue;
                          width: 400px;height: 50px;" value="<?php echo $value ?>"/>

                <input type="<?php echo $button ?>" value="コメント編集" name="submit" style="font-size: 16px;margin-top: 0px;
                          margin-left: 30px;border-color: lightskyblue;width: 120px;background-color: lightskyblue;"/>
              </form>
              <?php
                $dbh = null;
              }catch(PDOException $e)
              {
                echo $e->getMessage();
              }
          }   else {
                echo '<br>'.'コメントはありません。';
              }
              ?>
</div>
</body>
</html>