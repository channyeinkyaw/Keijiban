<?php
  session_start();
  require_once 'pdoconnection.php';
  require_once 'controller.php';
  $login = False;
  
  if(isset($_COOKIE['user_name'])){
      $user_name = $_COOKIE['user_name'];
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

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>掲示板システム</title>
</head>
  
<style type="text/css">
.main{
margin-right:auto;
margin-left:auto;
width:700px;
background-color: white;
margin:0 auto;
}

.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 100%;margin-top: 10px;}
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

/*navigation css*/
#demo4 nav {
width: 100%;
height: 60px;
padding: 0px;
background: #606060;
background: -moz-linear-gradient(-90deg, rgba(0,0,0,0), rgba(0,0,0,0.5)), #606060;
background: white;
overflow: auto;
-moz-border-radius: 0px;
-webkit-border-radius: 20px;
border-radius: 10px;
margin: 0 auto;
margin-top: 7px;
/*      background:url(images/head-online.jpg)*/
}

#demo4 nav li {
float: left;
margin: 0px 25px;
padding: 0 0;
width: 80px;

-moz-border-radius: 20px;
-webkit-border-radius: 20px;
border-radius: 20px;

-moz-transition-duration: 0.8s;
-webkit-transition-duration: 0.8s;
-o-transition-duration: 0.8s;
}
#demo4 nav li:hover {
-moz-box-shadow: 0px 1px 4px black;
-webkit-box-shadow: 0px 1px 4px black;
box-shadow: 0px 1px 4px black;
background: #fff;
background: -moz-linear-gradient(-90deg, rgba(0,0,0,0.2), rgba(0,0,0,0)), #fff;
background: -webkit-gradient(linear, left top, left bottom, from(rgba(0,0,0,0.2)), to(rgba(0,0,0,0))), white;
}
#demo4 nav li a {
-moz-transition-duration: 0.8s;
-webkit-transition-duration: 0.8s;
-o-transition-duration: 0.8s;

display: block;
text-align: center;
line-height: 1.1em;
font-size: 1.2em;
font-family: Delicious;
font-weight: bold;
text-shadow: 0px 0px 3px rgba(0,0,0,1);
text-decoration: none;
color: blue;
}

#demo4 nav li:hover a {
color: green;
text-shadow: 0px 0px 3px rgba(255,255,255,1);
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

function newdata() {
document.newform.hidden=false;
document.searchform.hidden=true;

}

function searchdata() {
document.searchform.hidden=false;
document.newform.hidden=true;
}
</script>
 
<body>
  
<div class="main">
  <img style="width: 100%;height: 10%;"src="images/title.jpg"/>
<!--      <label style="color: blue;font-size: 30px;" align="center">掲示板システム</label>-->
      
<!--      「<a href="logout.php">LOG OUT</a>」-->
      
            <?php// echo '<font style="color: red">'.strtoupper($user_name).'</font>'.' としてログインしています。'; ?>
          
      <section id="demo4">
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#" onclick="newdata();">Create</a></li>
          <li><a href="#" onclick="searchdata();">Search</a></li>
          <li><a href="logout.php">LogOut「<?php echo '<font style="color: red">'.strtoupper($user_name).'</font>'; ?>」</a></li> 
        </ul>
      </nav>
      </section>
          
   
            
      <table id="tablepaging"class="myTable">
        <tr>
          <th>ID</th>
          <th>掲示板名</th>
          <th>修正日</th>
          <th>コメント</th>
        </tr>

        <?php
            $sql = "SELECT * FROM Board ORDER BY id DESC";
            try {        
              foreach ($dbh->query($sql) as $row){
                  $id = $row['id'];
                  $title = $row['title'];
                  $create_date = $row['created_at'];
                  
                  $sQuery = "SELECT id FROM Comment WHERE board_id=$id";
                  $rResult = $dbh->query($sQuery)->fetchAll();
                  $counts=count($rResult);
        ?>  
                  <tr>
                  <td align="right"><?php echo $id; ?></td>
                  <td><?php echo $title; ?></td>
                  <td><?php echo $create_date; ?></td>
                  <td align="center">
                      <?php
                      $conn='dataaccess.php';
                      //if($login == True && $post_user_name == $user_name){
                      $comment_button = '<form method="post" action="'.$conn.'" >'.
		                     '<input type="hidden" value="'.$id.'" name="board_id" />'.
                              '<input type="hidden" value="'.$title.'" name="board_title" />'.
		                     '<input type="submit" value="コメント書く" name="submit" />'.
                             '</form>'; echo $counts.' 個ある'.$comment_button;
                      //}?> 
                  </td>            
                  </tr>
        <?php
                }
                $dbh = null;
              }catch(PDOException $e)
              {
                echo $e->getMessage();
              }
        ?>
      </table>
      <div id="pageNavPosition" style="padding-top: 20px" align="left"></div><br>

              <script type="text/javascript"><!--
              var pager = new Pager('tablepaging', 4);
              pager.init();
              pager.showPageNav('pager', 'pageNavPosition');
              pager.showPage(1);
              </script>
        
        <?php 
          if(isset($_SESSION['new_board'])){
            echo "<SCRIPT LANGUAGE='javascript'>newdata()</SCRIPT>";
            echo $_SESSION['new_board'];
          }
          
        ?>
<!--      <div style="border:1px solid yellow;" ><br>-->
          <form method="post" action="dataaccess.php" name="newform" hidden>
            <table class="myTable">  
              <tr><td>
                掲示板名 <input type="text" id="title" name="title" style="
                border-width: 2px;border-style:inset;border-color: lightskyblue; 
                width: 300px;height: 25px;" tabindex=1;/>

                <input type="submit" name="submit" value="送信" style="font-size: 16px;margin-left: 10px;
                border-color: lightskyblue;width: 164px;background-color: lightskyblue;"/>
              </td></tr>
            </table>
            
          </form>

          <form method="post" action="dataaccess.php" name="searchform" hidden>
            <table class="myTable">  
            <tr><td>
              <label style="margin-left: 0%">掲示板名検索 </label><input type="text" id="search" name="search" style="
              border-width: 2px;border-style:inset;border-color: lightskyblue; 
              width: 300px;height: 25px;" tabindex=1;/>

              <input type="submit" name="submit" value="検索" style="font-size: 16px;margin-left: 10px;
              border-color: lightskyblue;width: 164px;background-color: lightskyblue;"/>
              </td></tr>
            </table>
            <br>
          </form>   
          
          <?php
            if(empty($_SESSION['search_error'])){
                if(!empty($_SESSION['search_get']) && empty($_SESSION['nodata'])){
                  //$getdata='';
                  $conn='dataaccess.php';
                  echo '検索リザルト';
                  echo '<table id="tablepaging"class="myTable">
                  <tr>
                    <th>ID</th>
                    <th>掲示板名</th>
                    <th>修正日</th>
                    <th>コメント</th>
                  </tr>';
                  for($i = 0 ; $i < count($_SESSION['data1']) ; $i++){
                  echo '<tr>
                        <td align="right">'.$_SESSION['data1'][$i].'</td>
                        <td>'.$_SESSION['data2'][$i].'</td>
                        <td>'.$_SESSION['data3'][$i].'</td>
                        <td align="center">'.$_SESSION['count'][$i].' 個ある';
                          $comment_button = '<form method="post" action="'.$conn.'" >'.
                                            '<input type="hidden" value="'.$_SESSION['data1'][$i].'" name="board_id" />'.
                                             '<input type="hidden" value="'.$_SESSION['data2'][$i].'" name="board_title" />'.
                                            '<input type="submit" value="コメント書く" name="submit" />'.
                                            '</form>';echo '<br>'.$comment_button;
                  echo '</td></tr>';
                  }
                }
                else{
                  echo '<label style="margin-left: 1%">'.$_SESSION['nodata'].'</label>';
                }
              }
              else{
                echo '<label style="margin-left: 1%">'.$_SESSION['search_error'].'</label>';
              }
              session_destroy();
            ?>
<!--      </div>-->
</div>
</body>
</html>