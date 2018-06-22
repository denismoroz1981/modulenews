<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 13.06.18
 * Time: 18:38
 */

echo '<p><b>Ads</b></p>';

$adsSelect = $dbn->prepare('SELECT id,sort,item,price, vendor, 
      isvisible FROM `ads` LIMIT :start,:nrow');
$adsCount = $dbn->query('SELECT COUNT(*) FROM `ads`');
$adsInsert= $dbn->prepare('INSERT INTO ads SET 
      `sort`=:sort,
      item=:item,
      price=:price,
      vendor=:vendor, 
       isvisible=:isvisible        
        ');
$adsUpdate= $dbn->prepare('UPDATE ads SET 
      `sort`=:sort,
      item=:item,
      price=:price,
      vendor=:vendor, 
       isvisible=:isvisible
         WHERE id=:id
        ');


$adsDelete= $dbn->prepare('DELETE FROM `ads` WHERE `id`=?');
$nrow = 5;
if (!empty($_GET["cat_start"])) {
    $start = intval($_GET["cat_start"])*$nrow+1; } else {
    $start = 0;
}
$adsSelect->bindParam(':start',$start,PDO::PARAM_INT);
$adsSelect->bindParam(':nrow',$nrow,PDO::PARAM_INT);
$adsCount = $adsCount->fetch();
$adsCount = intval($adsCount["COUNT(*)"]);

$adsSelect->execute();
$adsRows = $adsSelect->fetchAll();

foreach ($adsRows as $row) {

    echo '<p><form action="" method="get">
        
        <label for="update_ads_id">Ads id:'.$row["id"].'</label> 
        
        <label for="update_ads_sort">Sort:</label> <input type="text" 
        id="update_ads_sort'.$row["id"].'"
         name="update_ads_sort'.$row["id"].'"><br>
        <script type="text/javascript"> document.getElementById("update_ads_sort'.$row["id"].'").
        value ='.$row["sort"].';</script>

        <label for="update_ads_item">Item:</label>
        <textarea id="update_ads_item'.$row["id"].'" name="update_ads_item'.$row["id"].'"></textarea><br>
         <script type="text/javascript"> document.getElementById("update_ads_item'.$row["id"].'").
        value = "'.$row["item"].'";</script>

        <label for="update_ads_price">Price:</label> <input type="text"
        id="update_ads_price'.$row["id"].'"
         name="update_ads_price'.$row["id"].'"><br>
        <script type="text/javascript"> document.getElementById("update_ads_price'.$row["id"].'").
        value = '.$row["price"].';</script>

        <label for="update_ads_vendor">Vendor:</label> <input type="text"
        id="update_ads_vendor'.$row["id"].'"
         name="update_ads_vendor'.$row["id"].'"><br>
        <script type="text/javascript"> document.getElementById("update_ads_vendor'.$row["id"].'").
        value ="'.$row["vendor"].'";</script>

        <label for="update_ads_visible'.$row["id"].'">Is visible?</label>
            <input type = "checkbox" value="1" name="update_ads_visible'.$row["id"].'" id="update_ads_visible'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("update_ads_visible'.$row["id"].'").checked
        ="'.(boolean)$row["isvisible"].'";</script>


        <input name="update" value="yes" type="hidden">
        <input name="view" value="ads" type="hidden">
        <input name="id" value="'.$row["id"].'" type="hidden">
        <input type="submit">
        <input name="cat_start" value="'.round(($adsCount)/$nrow-1).'" type="hidden"><br>
        </form>';

}

echo "<p>News count:".print_r($adsCount,1)."</p>";
$j=0;
for ($i=0; $i<=round($adsCount/$nrow); $i++) {
    $j=++$j;
    echo '<a href="index.php/?view=ads&cat_start='.$i.'">'.$j.'</a> ';
}

    echo '<p><form action="" method="get">
     <p><b>New ads:</b></p>
    <label for="new_ads_sort">Sort:</label> <input type="text" id="new_ads_sort"
    name="new_ads_sort"><br>
    
    <label for="new_ads_item">Item:</label>
    <textarea id="new_ads_item" name="new_ads_item"></textarea><br>
    
    <label for="new_ads_price">Price:</label> <input type="text" id="new_ads_price"
     name="new_ads_price"><br>
    
    <label for="new_ads_vendor">Vendor:</label> <input type="text" id="new_ads_vendor"
    name="new_ads_vendor"><br>
    
    <label for="new_ads_visible">Is visible?</label>
    <input type = "checkbox" value="1" name="new_ads_visible" id="new_ads_visible"></b>
    

    <input name="save" value="yes" type="hidden">
    <input name="view" value="ads" type="hidden">
    
    <input type="submit"></form>';


 if (!empty($_GET)) {if (isset($_GET["delete"])) {

    $adsDelete->execute(array($_GET["id"]));
}}

if (!empty($_GET)) {if (isset($_GET["update"])) {
    $sortToSave='update_ads_sort'.$_GET["id"];
    $itemToSave='update_ads_item'.$_GET["id"];
    $vendorToSave='update_ads_vendor'.$_GET["id"];
    $priceToSave='update_ads_price'.$_GET["id"];
    $visibleToSave='update_ads_visible'.$_GET["id"];
    if (empty($_GET[$visibleToSave])) {
        $_GET[$visibleToSave]=0;
    }

    $adsUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $adsUpdate->bindParam(':sort',$_GET[$sortToSave],PDO::PARAM_INT);
    $adsUpdate->bindParam(':item',$_GET[$itemToSave],PDO::PARAM_STR);
    $adsUpdate->bindParam(':vendor',$_GET[$vendorToSave],PDO::PARAM_STR);
    $adsUpdate->bindParam(':price',$_GET[$priceToSave],PDO::PARAM_INT);

    $adsUpdate->bindParam(':isvisible',$_GET[$visibleToSave],PDO::PARAM_INT);

    $adsUpdate->execute();
}}



if (!empty($_GET)) {if (isset($_GET["save"])) {
    $sortToSave='new_ads_sort';
    $itemToSave='new_ads_item';
    $vendorToSave='new_ads_vendor';
    $priceToSave='new_ads_price';
    $visibleToSave='new_ads_visible';
    if (empty($_GET[$visibleToSave])) {
        $_GET[$visibleToSave]=0;
    }


    $adsInsert->bindParam(':sort',$_GET[$sortToSave],PDO::PARAM_INT);
    $adsInsert->bindParam(':item',$_GET[$itemToSave],PDO::PARAM_STR);
    $adsInsert->bindParam(':vendor',$_GET[$vendorToSave],PDO::PARAM_STR);
    $adsInsert->bindParam(':price',$_GET[$priceToSave],PDO::PARAM_INT);

    $adsInsert->bindParam(':isvisible',$_GET[$visibleToSave],PDO::PARAM_INT);

    $adsInsert->execute();
}}







?>