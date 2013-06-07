<?php
	//require_once('dbsettings.php');
    require_once 'pdoconnection.php';

	$user_name = '';
	$error_message = '';
	$login = False;
	
	if(isset($_COOKIE['user_name'])){
		$user_name = $_COOKIE['user_name'];
		$login = True;
	}
	else{
		$login = False;
	}

	if($login == True){
		
		if(isset($_POST['submit']) && $_POST['submit']=='送信'){

			//$new_bulletin = mysqli_real_escape_string($db,trim($_POST['title']));
			$new_bulletin=$_POST['title'];
			if(empty($new_bulletin)){
				$error_message = 'BulletinName を入力してから CreateNewBulletin ボタンを押してください。';
			}
			else{

					date_default_timezone_set('Asia/Tokyo');
					$now_datetime = date('Y-m-d H:i:s');
//					$query = "INSERT INTO Board (id,title,created_at) VALUES (NULL,'$new_bulletin','$now_datetime');";
//					$result = mysqli_query($db,$query) or die('ERROR!(insert coment):MySQLサーバーへの接続に失敗しました。');
                    try {
                            $dbh->exec("INSERT INTO Board (id,title,created_at) VALUES (NULL,'$new_bulletin','$now_datetime')");
                            //$dbh = null;
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
		elseif(isset($_POST['submit']) && $_POST['submit']=='コメント'){
          setcookie('submit_id',$_POST['board_id']);
          setcookie('submit_title',$_POST['board_title']);
          $url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/comment.php';
					header("HTTP/1.1 301 Moved Permanently");
					header('Location: '.$url);
					exit;
		}
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
    width:600px;
    background-color: white;
    margin:0 auto;
}  

.myTable { background-color:white;border-collapse:collapse; margin-left: 0px; width: 600px;margin-top: 10px;}
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
      <label style="color: blue;font-size: 18px;">掲示板システム</label>「<a href="logout.php">LOG OUT</a>」<br><br>
            <?php echo '<font style="color: red">'.strtoupper($user_name).'</font>'.' としてログインしています。'; ?>
          
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
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
      
      <?php echo $error_message;?>
            
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
                  <td><?php echo $id; ?></td>
                  <td><?php echo $title; ?></td>
                  <td><?php echo $create_date; ?></td>
                  <td>
                      <?php
                      //if($login == True && $post_user_name == $user_name){
                      $comment_button = '<form method="post" action="'.$_SERVER['PHP_SELF'].'" >'.
		                     '<input type="hidden" value="'.$id.'" name="board_id" />'.
                              '<input type="hidden" value="'.$title.'" name="board_title" />'.
		                     '<input type="submit" value="コメント" name="submit" />'.
                             '</form>'; echo $counts.'(nos)'.$comment_button;
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
      <div id="pageNavPosition" style="padding-top: 20px" align="left"></div>

              <script type="text/javascript"><!--
              var pager = new Pager('tablepaging', 3);
              pager.init();
              pager.showPageNav('pager', 'pageNavPosition');
              pager.showPage(1);
              </script>
</div>
</body>
</html>
