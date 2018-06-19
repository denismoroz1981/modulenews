<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 13.06.18
 * Time: 18:38
 */

echo '<p><b>Comments</b></p>';

$commentsSelect = $dbn->prepare('SELECT id,news_id,`user`,text, created_at, 
      isapproved,plus FROM `comments` LIMIT :start,:nrow');
$commentsCount = $dbn->query('SELECT COUNT(*) FROM `comments`');
$commentsInsert= $dbn->prepare('INSERT INTO comments SET 
      `news_id`=:news_id,
      parent_id=:parent_id,
      `user`=:username,
      text=:text, 
       isapproved=:isapproved        
        ');
$commentsUpdate= $dbn->prepare('UPDATE comments SET 
      text=:text, 
       isapproved=:isapproved
         WHERE id=:id
        ');


$commentsDelete= $dbn->prepare('DELETE FROM `comments` WHERE `id`=?');
$nrow = 5;
if (!empty($_GET["cat_start"])) {
    $start = $_GET["cat_start"]*$nrow+1; } else {
    $start = 0;
}
$commentsSelect->bindParam(':start',$start,PDO::PARAM_INT);
$commentsSelect->bindParam(':nrow',$nrow,PDO::PARAM_INT);


$commentsSelect->execute();
$commentsRows = $commentsSelect->fetchAll();

foreach ($commentsRows as $row) {

    echo '<p><form action="" method="get">
            <b>'.$row["id"].'. </b>for news#: '.$row["news_id"].
        'from user: <i>'.$row["user"].'</i>
            <b>'.
        '<i>'.$row["created_at"].'</i><br>
            <b><input name="text'.$row["id"].'" id="text'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("text'.$row["id"].'").
            value ="'.$row["text"].'";</script>
            
    <br>
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    <input name="view" value="comments" type="hidden">
    <input name="save" value="Save" type="submit"  class="btn-success">
    <input name="delete" value="Delete" type="submit"  class="btn-danger">
    </p></form>';

}
$commentsCount = $commentsCount->fetch();
$commentsCount = intval($commentsCount["COUNT(*)"]);
echo "<p>Comments count:".print_r($commentsCount,1)."</p>";
$j=0;
for ($i=0; $i<=round($commentsCount/$nrow)-1; $i++) {
    $j=++$j;
    echo '<a href="index.php/?view=comments&cat_start='.$i.'">'.$j.'</a> ';
}






?>
    <form action="" method="get">
        <br>
        <p><b>New comment:</b></p>
        <label for="new_comments_news_id">News id:</label> <input type="text" id="new_comments_news_id" name="new_comments_news_id"><br>
        <label for="new_comments_parent_id">Parent comment id:</label> <input type="text" id="new_comments_parent_id" name="new_comments_parent_id"><br>
        <script type="text/javascript"> document.getElementById('new_comments_parent_id').value = '0';</script>
        <label for="new_comments_text">Text:</label>
        <textarea id="new_comments_text" name="new_comments_text"></textarea><br>
        <label for="new_comments_isapproved">Approved:</label>
        <input type="checkbox" id="new_comments_isapproved" name="new_comments_isapproved" value="1"><br>
        <label for="new_comments_user">User:</label>
        <input type="text" id="new_comments_user" name="new_comments_user">

        <input name="new_comments" value='yes' type="hidden">
        <input name="view" value="comments" type="hidden">
        <input name="cat_start" value="<?=round(($commentsCount)/$nrow-1)?>" type="hidden"><br>
        <input type="submit">
    </form>

<? if (!empty($_GET)) {if (isset($_GET["delete"])) {

    $commentsDelete->execute(array($_GET["id"]));
    }}

if (!empty($_GET)) {if (isset($_GET["save"])) {
    $textToSave='text'.$_GET["id"];
    $isapproved=1;
    $commentsUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $commentsUpdate->bindParam(':text',$_GET[$textToSave],PDO::PARAM_STR);
    $commentsUpdate->bindParam(':isapproved',$isapproved,PDO::PARAM_INT);

    $commentsUpdate->execute();
}}



if (!empty($_GET["new_comments"])) {

    if(empty($_GET["new_comments_isapproved"])) {$_GET["new_comments_isapproved"]=0;}
    $commentsInsert->bindParam(':news_id',$_GET["new_comments_news_id"],PDO::PARAM_INT);
    $commentsInsert->bindParam(':parent_id',$_GET["new_comments_parent_id"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':text',$_GET["new_comments_text"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':username',$_GET["new_comments_user"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':isapproved',$_GET["new_comments_isapproved"],PDO::PARAM_INT);
    //$commentsInsert->bindParam(':category_id',$_GET["new_news_category_id"],PDO::PARAM_STR);


    $commentsInsert->execute();

}






?>


