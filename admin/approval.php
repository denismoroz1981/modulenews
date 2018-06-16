<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 14.06.18
 * Time: 20:37
 */

echo '<br><p><b>Polical news to be approved:</b></p>';

$commentsSelect = $dbn->prepare('
SELECT c.id,c.news_id,c.user,c.text, c.created_at, c.isapproved, n.category_id
FROM `comments` as `c` LEFT JOIN `news` as `n` ON c.news_id = n.id 
HAVING n.category_id = "politics"
LIMIT :start,:nrow');
$commentsCount = $dbn->query('SELECT COUNT(*) FROM `comments` 
LEFT JOIN news as `n` ON comments.news_id=n.id where n.category_id="politics"');

$commentsUpdate= $dbn->prepare('UPDATE comments SET 
      
       isapproved=:isapproved
         WHERE id=:id
        ');

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
        ' from user: <i>'.$row["user"].'</i>
            <b>'.
        '<i>'.$row["created_at"].'</i><br><div class="well">'.$row["text"].'</div>
            <label for="isapproved'.$row["id"].'">Is approved?</label>
            <input type = "checkbox" value="1" name="isapproved'.$row["id"].'" id="isapproved'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("isapproved'.$row["id"].'").checked
             ="'.(boolean)$row["isapproved"].'";
             
             </script>
            
    <br>
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    <input name="view" value="approval" type="hidden">
    <input name="save" value="Save approval status" type="submit"  class="btn-success">
    
    </p></form>';

}

$commentsCount = $commentsCount->fetch();
$commentsCount = intval($commentsCount["COUNT(*)"]);
echo "<p>News count:".print_r($commentsCount,1)."</p>";
$j=0;
for ($i=0; $i<=round($commentsCount/$nrow)-1; $i++) {
    $j=++$j;
    echo '<a href="index.php/?view=approval&cat_start='.$i.'">'.$j.'</a> ';
}

if (!empty($_GET)) {if (isset($_GET["save"])) {
    $approvalToSave='isapproved'.$_GET["id"];
    if (empty($_GET[$approvalToSave])) {
        $_GET[$approvalToSave]=0;
    }

    $commentsUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $commentsUpdate->bindParam(':isapproved',$_GET[$approvalToSave],PDO::PARAM_BOOL);

    $commentsUpdate->execute();
}}

echo var_export($_GET,1);









?>
