<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 17.06.18
 * Time: 20:57
 */

$tagsOptionsSelect=$dbn->query('SELECT DISTINCT `name` FROM `tags`');

?>


<form action="/" method="get">
<input list="tag" name="tag">
        <datalist id="tag">
         <? foreach ($tagsOptionsSelect->fetchAll() as $row) {
    echo '<option>'.$row["name"].'</option>';
} ?>
        </datalist>
<input type="submit" value="Search news by tag">
</form>