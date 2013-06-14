<?php
function search($data){
  //require_once 'stylelayout.css';
  $conn='dataaccess.php';
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  
  $dbh = new PDO("mysql:host=$hostname;dbname=PHP", $username, $password);
  $sql = "SELECT * FROM Board WHERE title LIKE '$data%'";
  echo '<table class="myTable">';
  echo '<tr>
          <th>ID</th>
          <th>掲示板名</th>
          <th>修正日</th>
          <th>コメント</th>
        </tr>';
  foreach ($dbh->query($sql) as $row){
    $id=$row['id'];
    $title=$row['title'];
    $comment_button = '<form method="post" action="'.$conn.'" >'.
		                     '<input type="hidden" value="'.$id.'" name="board_id" />'.
                              '<input type="hidden" value="'.$title.'" name="board_title" />'.
		                     '<input type="submit" value="コメント書く" name="submit" />'.
                             '</form>';
    $sQuery = "SELECT id FROM Comment WHERE board_id=$id";
                  $rResult = $dbh->query($sQuery)->fetchAll();
                  $counts=count($rResult);
    
    echo '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['title'].'</td>
            <td>'.$row['created_at'].'</td>
            <td align="center">'.$counts.$comment_button.'</td>
          </tr>';
    
  }echo '</table>';
}
?>