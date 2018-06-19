<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 19.06.18
 * Time: 20:28
 */
echo '<h2>User <b>'.$_GET["user"].'</b> comments</h2>';

$commentsByUser = $dbn->prepare('SELECT id,news_id,`user`,text, created_at, 
      isapproved,plus FROM `comments` WHERE `user`=:user LIMIT :start,:nrow');
$commentsCount = $dbn->prepare('SELECT COUNT(*) FROM `comments` WHERE `user`=:user');



$nrow = 5;
if (!empty($_GET["cat_start"])) {
    $start = $_GET["cat_start"]*$nrow; } else {
    $start = 0;
}
$commentsByUser->bindParam(':start',$start,PDO::PARAM_INT);
$commentsByUser->bindParam(':nrow',$nrow,PDO::PARAM_INT);

$commentsByUser->bindParam(':user',$_GET["user"],PDO::PARAM_INT);
$commentsCount->bindParam(':user',$_GET["user"],PDO::PARAM_INT);

$commentsByUser->execute();
$commentsCount->execute();

$commentsRows = $commentsByUser->fetchAll();

$commentsCount = $commentsCount->fetch();
$commentsCount = intval($commentsCount["COUNT(*)"]);


foreach ($commentsRows as $row) {

    echo '<p><form action="" method="get">
        Comment #<span id="comment_id">'.$row["id"].
        '</span> from user: <i>'.$row["user"].'</i>
            '.
        'posted: <b><i>'.$row["created_at"].'</i><br>
            <b><input name="text'.$row["id"].'"readonly id="text'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("text'.$row["id"].'").
            value ="'.$row["text"].'";</script></p></form>';

}

echo "<br><p>Comments count:".print_r($commentsCount,1)."</p>";
$j=0;
for ($i=0; $i<=round($commentsCount/$nrow)-1; $i++) {
    $j=++$j;
    echo '<a href="/?user='.$_GET["user"].'&cat_start='.$i.'">'.$j.'</a> ';
}