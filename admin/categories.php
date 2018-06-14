<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 12.06.18
 * Time: 19:11
 */

echo '<p><b>Categories</b></p>';
$catsSelect = $dbn->query('SELECT * FROM `category`');
$catsCount = $dbn->query('SELECT COUNT(*) FROM `category`');
$catsInsert= $dbn->prepare('INSERT INTO `category` SET `name`=?');
$catsUpdate= $dbn->prepare('UPDATE `category` SET `name`=? WHERE `id`=?');
$catsDelete= $dbn->prepare('DELETE FROM `category` WHERE `id`=?');

foreach ($catsSelect->fetchAll() as $row) {
    echo '<p> <form action="" method="get">'.$row["name"].' 
                        <button>Delete</button>
                        <input name="delete_category" value='.$row["id"].' type="hidden">
                        <input name="view" value="categories" type="hidden">
                       </form></p>';
}
?>
    <form action="" method="get">
        <label for="new_category">New category:</label>
        <input type="text" id="new_category" name="new_category">
        <input name="view" value="categories" type="hidden">
        <input type="submit">
    </form>

<? if (!empty($_GET["delete_category"])) {
    $catsDelete->execute(array($_GET["delete_category"]));
    header("Location:index.php/?view=categories");
}

if (!empty($_GET["new_category"])) {
    $catsInsert->execute(array($_GET["new_category"]));
    header("Location:index.php/?view=categories");
}
