<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 13:52
 */




$limit = $_GET["limit"];
$j=0;
for ($i=0;$i<=$limit/5-1;$i++) {
    $j=++$j;
    echo '<a href="/?cat='.$_GET["cat"].'&cat_start='.$i.'">'.$j.'</a> ';
}

echo '<a href="/?cat='.$_GET["cat"].'&cat_start=1">>></a> ';
