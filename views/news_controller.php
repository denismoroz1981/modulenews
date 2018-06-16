<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 11:22
 */

$newsAll = $dbn->query('SELECT id,`name`,text_head,text_main, created_at, 
      photo, isanalytical, category_id FROM `news`ORDER BY created_at DESC');
$newsAll->execute();
$newsAllArr = $newsAll->fetchAll();
$catArr=[];
foreach ($newsAllArr as $row) {
    if (!is_null($row["category_id"])) {$catArr[]=$row["category_id"];}
    }
$catArr=array_unique($catArr);

function countNews($cat) {
    global $dbn;
    $newsCount = $dbn->prepare('SELECT COUNT(*) FROM `news` WHERE category_id = :cat');


    $newsCount->bindParam(':cat', $cat, PDO::PARAM_STR);

    $newsCount->execute();
    $newsCount = $newsCount->fetch();
    $count = intval($newsCount["COUNT(*)"]);

    return $count;

}

function selectNews ($cat,$start=0,$nrow=5)
{
    global $dbn;
    $newsSelect = $dbn->prepare('SELECT id,`name`,text_head,text_main, created_at, 
          photo, isanalytical, category_id FROM `news` WHERE category_id = :cat ORDER BY created_at DESC 
           LIMIT :start,:nrow');

    $newsSelect->bindParam(':start', $start, PDO::PARAM_INT);
    $newsSelect->bindParam(':nrow', $nrow, PDO::PARAM_INT);
    $newsSelect->bindParam(':cat', $cat, PDO::PARAM_STR);

    $newsSelect->execute();
    $newsRows = $newsSelect->fetchAll();
    return $newsRows;
}