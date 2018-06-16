<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 12:25
 */

require_once ("views/news_controller.php");

foreach ($catArr as $cat) {
    echo '<h2><a href="/?cat='.$cat.'" >'.$cat.'</a></h2>';
    $newsToShow = selectNews($cat);
    foreach ($newsToShow as $news) {
        $date = explode(" ",$news["created_at"]);
        echo '<p>'.$date[0].' <b>'.$news["name"].'</b></p>';
    }
}