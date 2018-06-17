<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 20:01
 */

require_once ("views/news_controller.php");
$cat = $_GET["cat"];

echo '<h2><span id="cat">'.$cat.'</span></h2>';

$nrow = 5;

if (!empty($_GET["cat_start"])) {
    $cat_start=$_GET["cat_start"];
    $start = $cat_start * $nrow;
} else {
    $cat_start=0;
    $start = 0;
}

$newsRows = selectNews($cat,$start,$nrow);

foreach ($newsRows as $row) {
    $date = explode(" ",$row["created_at"]);
    echo '<p><form action="" method="get">
            <i>'.$date[0].'</i>
            <b><a href="/?cat='.$cat.'&news_id='.$row["id"].'">'.$row["name"].'</a></b> 
    <br>
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    
    
    </p></form>';

}

$newsCount = countNews($cat);
echo '<p>News count:<span id="limit">'.print_r($newsCount,1).'</span></p>';
echo '<div id="pagination">';
$j=0;
$limit = round(($newsCount/$nrow)-1);
$limitPage=$limit+1;
echo '<form>';
if (empty($_GET["cat_start"])) {
    echo '<a href="/?cat=' . $cat . '&cat_start=0">1</a>';
    echo '<input type="hidden" name="limit" value=' . $limitPage . '">';
    echo '<input type="submit" id="dots" value="...">';

    echo ' <a href="/?cat=' . $cat . '&cat_start=' . $limit . '">' . $limitPage . '</a>';
} else {
    if ($cat_start>1) {
        $prior=$cat_start-1;
        echo '<a href="/?cat=' . $cat . '&cat_start=' . $prior . '"><<</a> ';
    }

    for ($i=0;$i<=round($newsCount/$nrow)-1;$i++) {
        $j=++$j;
        echo '<a href="/?cat='.$cat.'&cat_start='.$i.'">'.$j.'</a> ';
    }

    if ($cat_start<($newsCount/$nrow)-1) {
        $next=$cat_start+1;
        echo '<a href="/?cat=' . $cat . '&cat_start=' . $next . '">>></a> ';
    }
}
echo '</form>';
echo '</div>';


?>
<script>

    var dots = document.getElementById("dots");
    //var pagination = document.getElementById("pagination");

    function dotsClick(e) {


        $.ajax({
            type: "GET",
            url:'views/pagination.php/',
            data:{
                limit:$('#limit').text(),
                cat:$('#cat').text(),
            },
            success: function(data) {
                $('#pagination').html(data);
            }

        })
        e.preventDefault();






    }



    dots.addEventListener("click",dotsClick,false);

</script>
