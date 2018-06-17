<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 21:50
 */

$tag = $_GET["tag"];
echo '<h4><b>News by tag: '.$tag.' </b></h4>';

$newsByTag = $dbn->prepare('SELECT n.name, n.text_head, n.text_main, n.created_at, 
n.isanalytical
FROM news AS n LEFT JOIN tags AS t ON n.id = t.news_id WHERE t.name = :tag 
ORDER BY created_at DESC LIMIT :start,:nrow');
$newsCount = $dbn->prepare('SELECT COUNT(*) FROM news AS n LEFT JOIN tags AS t ON n.id = t.news_id WHERE t.name = :tag');
$newsByTag ->bindParam(':tag',$tag,PDO::PARAM_STR);
$newsCount->bindParam(':tag',$tag,PDO::PARAM_STR);

$nrow = 5;
if (!empty($_GET["cat_start"])) {
    $start = $_GET["cat_start"]*$nrow; } else {
    $start = 0;
}

$newsByTag->bindParam(':start',$start,PDO::PARAM_INT);
$newsByTag->bindParam(':nrow',$nrow,PDO::PARAM_INT);

$newsByTag->execute();
$newsCount->execute();

$newsRows = $newsByTag->fetchAll();
$newsCount = $newsCount->fetch();
$newsCount = intval($newsCount["COUNT(*)"]);

foreach ($newsRows as $row) {

    echo '<p>'.$row["created_at"].' <b>'.$row["name"].'</b></p>'.
        $row["text_head"].'</p>';

}
echo "<p>News count:".print_r($newsCount,1)."</p>";
$j=0;
for ($i=0;$i<=round($newsCount/$nrow);$i++) {
    $j=++$j;
    echo '<a href="/?tag='.$tag.'&cat_start='.$i.'">'.$j.'</a> ';
}

