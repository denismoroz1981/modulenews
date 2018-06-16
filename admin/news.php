<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 13.06.18
 * Time: 18:38
 */

echo '<p><b>News</b></p>';

    $newsSelect = $dbn->prepare('SELECT id,`name`,text_head,text_main, created_at, 
      photo, isanalytical, category_id FROM `news` LIMIT :start,:nrow');
    $newsCount = $dbn->query('SELECT COUNT(*) FROM `news`');
    $newsInsert= $dbn->prepare('INSERT INTO `news` SET
      `name`=:name,
      text_head=:text_head,
      text_main=:text_main, 
       isanalytical=:isanalytical,
        category_id=:category_id ');




    $newsDelete= $dbn->prepare('DELETE FROM `news` WHERE `id`=?');
    $nrow = 5;
    if (!empty($_GET["cat_start"])) {
        $start = $_GET["cat_start"]*$nrow+1; } else {
        $start = 0;
    }
    $newsSelect->bindParam(':start',$start,PDO::PARAM_INT);
    $newsSelect->bindParam(':nrow',$nrow,PDO::PARAM_INT);


    $newsSelect->execute();
    $newsRows = $newsSelect->fetchAll();

    foreach ($newsRows as $row) {

        echo '<p><form action="" method="get">
            <b>'.$row["id"].'. </b><i>'.$row["created_at"].'</i>
            <b>'.$row["name"].'</b> '.$row["category_id"].
            ' <p>'.
            $row["text_head"].'</p>
    <br>
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    <input name="view" value="news" type="hidden">
    <input name="add_tags" value="Add tags" type="submit">
    <input name="add_image" value="Add image" type="submit"">
    <input name="delete" value="Delete" type="submit"  class="btn-danger">
    </p></form>';

    }
    $newsCount = $newsCount->fetch();
    $newsCount = intval($newsCount["COUNT(*)"]);
    echo "<p>News count:".print_r($newsCount,1)."</p>";
    $j=0;
    for ($i=0;$i<=round($newsCount/$nrow)-1;$i++) {
        $j=++$j;
        echo '<a href="index.php/?view=news&cat_start='.$i.'">'.$j.'</a> ';
    }
    //for ($i=0;$i<=)

    if (!empty($_GET)) {if (isset($_GET["add_image"])) {
            require_once ("img_downloader.php");

    }}

    if (!empty($_GET)) {if (isset($_GET["add_tags"])) {

      echo '<br><br><p><b>Enter tags for news '.$_GET["id"].' serarating by comma </b></p>';

        echo '<form action="" method="get"><input type="text" name="tags_list">
                <input name="view" value="news" type="hidden">
                <input name="id" value="'.$_GET["id"].'" type="hidden">
            <input type="submit" name="Add tagse">


            </form>';
        //foreach ($dbn->query('SELECT name FROM `tags`')->fetchAll();
        //$newsDelete->execute(array($_GET["id"]));
        //$path = __DIR__.DIRECTORY_SEPARATOR.'/../img/'.$_GET["id"];
        //if (file_exists($path)) {
          //  unlink($path);

        //}

    }}

if (!empty($_GET)) {if (isset($_GET["tags_list"])) {
    $tagslist = explode(",",$_GET["tags_list"]);
    $tagsInsert= $dbn->prepare('INSERT INTO `tags` SET `news_id`=?,name=?');
    foreach ($tagslist as $tag) {
        $tagsInsert->execute(array($_GET["id"],$tag));
        echo '<p> Tag '.$tag.' added.</p>';

    }




}}

    $catsOptionsSelect = $dbn->query('SELECT * FROM `category`');
    ?>
    <form action="" method="get">
        <br>
        <p><b>New news:</b></p>
        <label for="new_news_name">Title:</label> <input type="text" id="new_news_name" name="new_news_name"><br>
        <label for="new_news_head_text">Head text:</label>
        <textarea id="new_news_head_text" name="new_news_head_text"></textarea><br>
        <label for="new_news_main_text">Main text:</label>
        <textarea id="new_news_main_text" name="new_news_main_text"></textarea><br>
        <!--<label for="new_news_photo">Photo:</label>
        <input type="text" id="new_news_photo" name="new_news_photo"><br>-->
        <label for="new_news_isanalytical">Analytical:</label>
        <input type="checkbox" id="new_news_isanalytical" name="new_news_isanalytical" value="1"><br>
        <label for="new_news_category_id">Category:</label>
        <input list="new_news_category_id">
        <datalist id="new_news_category_id">
         <? foreach ($catsOptionsSelect->fetchAll() as $row) {
            echo '<option>'.$row["name"].'</option>';
         }
         ?>
        </datalist><br>
        <input name="new_news" value='yes' type="hidden">
        <input name="view" value="news" type="hidden">
        <input name="cat_start" value="<?=round(($newsCount)/$nrow-1)?>" type="hidden">
         <input type="submit">
    </form>

<? if (!empty($_GET)) {if (isset($_GET["delete"])) {

    $newsDelete->execute(array($_GET["id"]));
    $path = __DIR__.DIRECTORY_SEPARATOR.'/../img/'.$_GET["id"];
    if (file_exists($path)) {
        unlink($path);

    }

}}


if (!empty($_GET["new_news"])) {

    if(empty($_GET["new_news_isanalytical"])) {$_GET["new_news_isanalytical"]=0;}
    $newsInsert->bindParam(':name',$_GET["new_news_name"],PDO::PARAM_STR);
    $newsInsert->bindParam(':text_head',$_GET["new_news_head_text"],PDO::PARAM_STR);
    $newsInsert->bindParam(':text_main',$_GET["new_news_main_text"],PDO::PARAM_STR);
    $newsInsert->bindParam(':isanalytical',$_GET["new_news_isanalytical"],PDO::PARAM_INT);
    $newsInsert->bindParam(':category_id',$_GET["new_news_category_id"],PDO::PARAM_STR);


    $newsInsert->execute();

    /*array(
       ':name'=>$_GET["new_news_name"],
        ':text_head'=>$_GET["new_news_head_text"],
        ':text_main'=>$_GET["new_news_main_text"],
        ':isanalytical'=>$_GET["new_news_isanalytical"],
        ':category_id'=>$_GET["new_news_category_id"]
    ));
    header("Location:index.php");*/
}
?>







