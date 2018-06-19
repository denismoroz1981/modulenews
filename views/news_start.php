<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 12:25
 */

require_once ("views/news_controller.php");

echo '<h2>News by category</h2>';

array_push($catArr,"analytics");

foreach ($catArr as $cat) {
    echo '<h2><a href="/?cat='.$cat.'" >'.$cat.'</a></h2>';
    $newsToShow = selectNews($cat);
    foreach ($newsToShow as $news) {
        $date = explode(" ",$news["created_at"]);
        echo '<p>'.$date[0].' <b>'.$news["name"].'</b></p>';
    }
}



echo '<h2>Top commentators</h2>';

foreach ($topCommentators as $user) {
    if(!is_null($user["user"])) {
        echo '<p><a href="/?user='.$user["user"].'">'.$user["user"].'</a></p>';
    }

}

echo '<h2>Most commented news</h2>';

$topNews = $dbn->query('SELECT n.id,n.name,n.text_head,n.text_main, n.created_at, 
      n.isanalytical, n.category_id, n.visitors_total, c.ncomm FROM `news` AS n 
      LEFT JOIN (SELECT news_id, COUNT(*) AS ncomm FROM comments GROUP BY news_id)
       AS c ON n.id = c.news_id 
      ORDER BY c.ncomm DESC LIMIT 3');

$topNews->execute();
$topNews=$topNews->fetchAll();
//echo var_export($topNews,1);
foreach ($topNews as $news) {
    $date = explode(" ",$news["created_at"]);
    echo '<p><b>Title: '.$news["name"].'</b></p>';
    echo '<p>Date: '.$date[0].'</p>';
    echo '<p>Text head: '.$news["text_head"].'</p>';
    echo '<p>Number of comments: '.$news["ncomm"].'</p>';
}
