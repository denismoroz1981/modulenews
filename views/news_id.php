<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 20:08
 */

require_once ("rating_change.php");

$newsById = $dbn->prepare('SELECT id,`name`,text_head,text_main, created_at, 
      photo, isanalytical, category_id, visitors_total FROM `news` WHERE id=:id');



$commentsByUser = $dbn->prepare('SELECT id,news_id,`user`,text, created_at, 
      isapproved,plus FROM `comments` WHERE news_id=:id LIMIT :start,:nrow');
$commentsCount = $dbn->prepare('SELECT COUNT(*) FROM `comments` WHERE news_id = :id');
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


$tagsById= $dbn->prepare('SELECT name FROM `tags` WHERE news_id=:id');

$nrow = 5;
if (!empty($_GET["cat_start"])) {
    $start = $_GET["cat_start"]*$nrow; } else {
    $start = 0;
}
$commentsByUser->bindParam(':start',$start,PDO::PARAM_INT);
$commentsByUser->bindParam(':nrow',$nrow,PDO::PARAM_INT);

$newsById->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);
$commentsByUser->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);
$commentsCount->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);

$tagsById->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);

$newsById->execute();
$commentsByUser->execute();
$tagsById->execute();
$commentsCount->execute();

$news = $newsById->fetch();
$commentsRows = $commentsByUser->fetchAll();
$tags = $tagsById->fetchAll();

$commentsCount = $commentsCount->fetch();
$commentsCount = intval($commentsCount["COUNT(*)"]);


$date = explode(" ",$news["created_at"]);
$pathToImg = __DIR__."/../img/".$news["id"].DIRECTORY_SEPARATOR;

echo '<h4>News:</h4>';
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
if ($news["isanalytical"]) {
    if(empty($_SESSION["username"])) {
        echo 'Only authorised users may real analytical articles.';}
        else {
    echo '<p>'.$news["text_main"].'</p>';
}} else {
    echo '<p>'.$news["text_main"].'</p>';

};




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

echo '<h4 style="clear: both;"><b>Comments:</b></h4>';

echo '<form action="/" method="get">';
if (!empty($_SESSION["username"])) {
    echo '<p>New comment:</p>';
    echo '<input type="hidden" name="news_id" value="'.$_GET["news_id"].'">';
    echo '<input type="hidden" name="cat" value="'.$_GET["cat"].'">';
    echo '<input type="hidden" name="parent_id" value="0">';
    echo '<input type="text" name="new_comments_text" id="new_comments_text">';

    echo '<input type="submit" value="Save">';
} else {
    echo 'Only authorised users may comment.';
}

echo '</form>';

if (!empty($_GET["new_comments_text"])) {

    if(empty($_GET["new_comments_isapproved"])) {$_GET["new_comments_isapproved"]=0;}
    $commentsInsert->bindParam(':news_id',$_GET["news_id"],PDO::PARAM_INT);
    $commentsInsert->bindParam(':parent_id',$_GET["new_comments_parent_id"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':text',$_GET["new_comments_text"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':username',$_SESSION["username"],PDO::PARAM_STR);
    $commentsInsert->bindParam(':isapproved',$_GET["new_comments_isapproved"],PDO::PARAM_INT);
    //$commentsInsert->bindParam(':category_id',$_GET["new_news_category_id"],PDO::PARAM_STR);


    $commentsInsert->execute();

}


$bestRated = $dbn->prepare('SELECT id,news_id,`user`,text, created_at, 
      isapproved,plus FROM `comments` WHERE news_id=:id ORDER BY plus DESC');
$bestRated->bindParam(':id',$_GET["news_id"],PDO::PARAM_INT);
$bestRated->execute();
$bestRated = $bestRated->fetch();

//echo var_export($bestRated,1);
$k = array_search($bestRated,$commentsRows);
unset($commentsRows[$k]);
array_unshift($commentsRows,$bestRated);

function displayComment($row) {
    echo '<p><form action="" method="get">
        Comment #<span id="comment_id">'.$row["id"].
        '</span> from user: <i>'.$row["user"].'</i>
            '.
        'posted: <b><i>'.$row["created_at"].'</i><br>
            <b><input name="text'.$row["id"].'"readonly id="text'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("text'.$row["id"].'").
            value ="'.$row["text"].'";</script>
            
    <br>
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    <input name="view" value="comments" type="hidden">';
    $startTime = new DateTime();
    $tz1=timezone_open('Europe/Kiev');
    $startTime->setTimezone($tz1);
    //if (is_null($row["created_at"])) {$row["created_at"]=0;}
    $startTime ->setTimestamp(date(strtotime($row['created_at'])));
    //$timeDiff = $startTime->diff(new DateTime("now"));
    //echo var_export($row["created_at"]);
    $now = new DateTime();
    $timestamp = time();
    $now->setTimezone($tz1);
    $now->setTimestamp($timestamp);
    $now->modify('+1 hour');
    $timeDiff= $now->getTimestamp() - strtotime($row['created_at']);
    echo '<p>Posted sec ago:'.$timeDiff.'</p>';
    //echo '<p>Now:'.date("l dS \o\f F Y h:i:s A",$now->getTimestamp()).'</p>';
    //echo '<p>Start:'.strtotime($row['created_at']).'</p>';
    if (!empty($_SESSION["username"])) {
        if ($_SESSION["username"] == $row["user"] && $timeDiff<60) {
            echo '<script type="text/javascript"> document.getElementById("text'.$row["id"].'").
                removeAttribute("readonly");</script>';
            echo '<input name="save" value="Save" type="submit"  class="btn-outline-secondary">';}
    }
    // echo '<input name="save" value="Save" type="submit"  class="btn-success">';'
    echo '<input type="hidden" name="news_id" value="'.$_GET["news_id"].'">';
    echo '<input type="hidden" name="cat" value="'.$_GET["cat"].'">';
    echo 'rating: <span id="rating'.$row["id"].'">'.$row["plus"].'</span>';
    echo '<input type="submit" name="plus" id="plus'.$row["id"].'" value="+">';
    echo '<script type="text/javascript"> 
          var button =  document.getElementById("plus'.$row["id"].'");
          function operClick(e) {
                //var rating = document.getElementById("dots");
           id = '.$row["id"].';
           plus = parseInt($("#rating"+id).text())+1;
           
        $.ajax({
            type: "GET",
            url:"/",
            data:{
                id:id,
                plus:plus
            },
            success: function($data) {
                rating_id="#rating"+id;
                $(rating_id).html(plus);
                
            }            
            
        })
        
        
           e.preventDefault();
    }
    button.addEventListener("click",operClick,false);               
                
                </script>';

    echo '<input type="submit" name="minus" id="minus'.$row["id"].'" value="-">';
    echo '<script type="text/javascript"> 
          var button =  document.getElementById("minus'.$row["id"].'");
          function operClick(e) {
                //var rating = document.getElementById("dots");
           id = '.$row["id"].';
           plus = parseInt($("#rating"+id).text())-1;
           
        $.ajax({
            type: "GET",
            url:"/",
            data:{
                id:id,
                plus:plus
            },
            success: function($data) {
                rating_id="#rating"+id;
                $(rating_id).html(plus);
                
            }            
            
        })
        
        
           e.preventDefault();
    }
    button.addEventListener("click",operClick,false);               
                
                </script>';

    echo '</p></form>';
}


if ($commentsRows[0]) {
foreach ($commentsRows as $row) {
    if ($_GET["cat"]!=="politics") {
        displayComment($row);
    } elseif ($row["isapproved"]) {
        displayComment($row);
    }




}}

if (!empty($_GET["save"])) {
    $textToSave='text'.$_GET["id"];
    $isapproved=0;
    $commentsUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $commentsUpdate->bindParam(':text',$_GET[$textToSave],PDO::PARAM_STR);
    $commentsUpdate->bindParam(':isapproved',$isapproved,PDO::PARAM_INT);

    $commentsUpdate->execute();
}


echo "<br><p>Comments count:".print_r($commentsCount,1)."</p>";
$j=0;
for ($i=0; $i<=round($commentsCount/$nrow); $i++) {
    $j=++$j;
    echo '<a href="/?cat='.$_GET["cat"].'&news_id='.$_GET["news_id"].'&cat_start='.$i.'">'.$j.'</a> ';
}



$commentsPlus= $dbn->prepare('UPDATE comments SET 
      text=:text, 
       isapproved=:isapproved
         WHERE id=:id
        ');