<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 20.06.18
 * Time: 21:09
 */

echo '<p><b>News found: </b></p>';

//echo var_export($_GET,1);
$date_from="2000-01-01";
$date_to="2100-01-01";

if (!empty($_GET["date_from"])){$date_from = $_GET["date_from"];}
if (!empty($_GET["date_to"])){$date_to = $_GET["date_to"];}

$cat =[];
$tags = [];
foreach ($_GET as $k => $v) {
    if ($v="category") {$cat[] = $k;};
    if ($v="tag") {$tags[] = $k;};

}



$newsFound = $dbn->prepare('SELECT DISTINCT n.id, n.name, n.created_at, 
n.category_id, tags.name as tag FROM `news` as `n` LEFT JOIN `tags` ON n.id = tags.news_id 
WHERE n.created_at BETWEEN :date_from AND :date_to');

$newsFound->bindParam(':date_from',$date_from,PDO::PARAM_STR);
$newsFound->bindParam(':date_to',$date_to,PDO::PARAM_STR);
$newsFound->execute();
$newsFound = $newsFound->fetchAll();
//echo var_export($newsFound,1);
$selectedNews=[];
foreach ($newsFound as $news) {
    if (in_array($news["tag"],$tags) && in_array($news["category_id"],$cat)) {$selectedNews[]=$news;}

}
//echo var_export($selectedNews,1);

foreach ($selectedNews as $news) {
    $date = explode(" ",$news["created_at"]);
    echo '<p><form action="" method="get">
            <i>'.$date[0].'</i>
            <b><a href="/?cat='.$news["category_id"].'&news_id='.$news["id"].'">'.$news["name"].' </a></b>
            <b>category</b>: '.$news["category_id"].' <b>tag</b>: '.$news["tag"].'
    <br>
    <input name="id" value='.$news["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    
    
    </p></form>';
}

