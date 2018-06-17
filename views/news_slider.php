<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 17.06.18
 * Time: 21:37
 */

$newsSlider = $dbn->query('SELECT * FROM `news` ORDER BY created_at DESC LIMIT 3');


for ($i=1;$i<=3;$i++) {
    $news = $newsSlider->fetch();
    $item = 'item' . $i;
    $date = explode(" ", $news["created_at"]);
    $pathToImg = __DIR__ . "/../img/" . $news["id"] . DIRECTORY_SEPARATOR;
    $$item = "Recent news:";
    if (file_exists($pathToImg)) {
        $images = array_slice(scandir($pathToImg), 2);

        $$item .= '<img style="float:left" src="/../img/' . $news["id"] . '/' . $images[0] . '">';

    } else {
        $$item .= '<img src="http://goo.gl/ijai22">';
    }
    $$item .= '<p>Category: ' . $news["category_id"] . '</p>';
    $$item .= '<p><b>Title: ' . $news["name"] . '</b></p>';
    $$item .= '<p><b>Date: ' . $date[0] . '</b></p>';
    $$item .= '<p><b>Text: ' . $news["text_main"] . '</b></p>';

}


