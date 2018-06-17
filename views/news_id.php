<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 20:08
 */

$newsById = $dbn->prepare('SELECT id,`name`,text_head,text_main, created_at, 
      photo, isanalytical, category_id, visitors_total FROM `news` WHERE id=:id');



$commentsById = $dbn->prepare('SELECT id,news_id,`user`,text, created_at, 
      isapproved,plus FROM `comments` WHERE id=:id');

$tagsById= $dbn->prepare('SELECT name FROM `tags` WHERE news_id=:id');

$newsById->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);
$commentsById->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);
$tagsById->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);

$newsById->execute();
$commentsById->execute();
$tagsById->execute();

$news = $newsById->fetch();
$comments = $commentsById->fetchAll();
$tags = $tagsById->fetchAll();



$date = explode(" ",$news["created_at"]);
$pathToImg = __DIR__."/../img/".$news["id"].DIRECTORY_SEPARATOR;

echo '<p><b>News:</b></p>';
echo '<p>Category: '.$_GET["cat"].'</p>';
echo '<p><b>Title: '.$news["name"].'</b></p>';
echo '<p><b>Date: '.$date[0].'</b></p>';
if (file_exists($pathToImg)) {
    $images = array_slice(scandir($pathToImg),2);

    foreach ($images as $img) {
        echo var_export($img,1);
        echo '<img style="float:left" src="/../img/'.$news["id"].'/'.$img.'">';
    }
} else {
    echo '<img src="http://goo.gl/ijai22">';
}

echo '<p>'.$news["text_head"].'</p>';
if ($news["isanalytical"] && !empty($_SESSION["username"])) {
    echo '<p>'.$news["text_main"].'</p>';
}


echo '<p><b>Tags:</b></p>';
foreach ($tags as $tag) {
    echo '<a href="/?tag='.$tag["name"].'">'.$tag["name"].'</a>  ';

}
$visitors_now = rand(0,5);
echo '<br><i>'.$visitors_now." people are reading this article now.".'</i>';
$visitors_total = $news["visitors_total"]+$visitors_now;
echo '<br><i>'.$visitors_total." people have read this article in total.".'</i>';

$visitorsUpdate=$dbn->prepare('UPDATE news SET visitors_total = :visitors_total
WHERE id = :id');
$visitorsUpdate->bindParam(':id',$news["id"],PDO::PARAM_INT);
$visitorsUpdate->bindParam(':visitors_total',$visitors_total,PDO::PARAM_INT);
$visitorsUpdate->execute();


