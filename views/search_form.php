<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 20.06.18
 * Time: 20:38
 */
$tagsOptionsSelect=$dbn->query('SELECT DISTINCT `name` FROM `tags`');
$categories = $dbn->query('SELECT DISTINCT `category_id` AS `name` from `news`');
echo '<p><b>News search: </b></p>';
echo '<form action="/" method="get">';
echo ' from';
echo '<input id="date_from" name="date_from" type="date">';
echo ' to';
echo '<input id="date_to" name="date_to" type="date"><br>';
//echo var_export($tagsOptionsSelect->fetchAll(),1);
echo 'tags:   ';
foreach ($tagsOptionsSelect->fetchAll() as $row) {
    echo '<input type="checkbox" checked name="'.$row["name"].'" value="tag">
    <label for="'.$row["name"].'">'.$row["name"].'</label>';
}
echo '<br> categories:   ';
foreach ($categories->fetchAll() as $row) {
    if (!is_null($row["name"])) {
        echo '<input type="checkbox" checked name="'.$row["name"].'" value="category">
        <label for="'.$row["name"].'">'.$row["name"].'</label>';
}}
echo '<input type="submit" value="Search">';
echo '<input type="hidden" name="search_form" value="yes">';

echo '</form>';