<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 21.06.18
 * Time: 22:50
 */
echo '<p><b>Menu management</b></p>';


$menuSelect = $dbn->query('SELECT id,title,link,sort1,sort2,sort3 FROM menu')->fetchAll();

$menuInsert= $dbn->prepare('INSERT INTO menu SET 
      `title`=:title,
      link=:link,
      `sort1`=:sort1,
      `sort2`=:sort2,
      `sort3`=:sort3
              
        ');
$menuUpdate= $dbn->prepare('UPDATE menu SET 
      `title`=:title,
      link=:link,
      `sort1`=:sort1,
      `sort2`=:sort2,
      `sort3`=:sort3   
      WHERE id=:id
        ');

if (!empty($_GET["new_menu"])) {

    $menuInsert->bindParam(':title',$_GET["title"],PDO::PARAM_STR);
    $menuInsert->bindParam(':link',$_GET["link"],PDO::PARAM_STR);
    $menuInsert->bindParam(':sort1',$_GET["sort1"],PDO::PARAM_INT);
    $menuInsert->bindParam(':sort2',$_GET["sort2"],PDO::PARAM_INT);
    $menuInsert->bindParam(':sort3',$_GET["sort3"],PDO::PARAM_INT);
    $menuInsert->execute();

}

if (!empty($_GET["update_menu"])) {

    $menuUpdate->bindParam(':title',$_GET["title"],PDO::PARAM_STR);
    $menuUpdate->bindParam(':link',$_GET["link"],PDO::PARAM_STR);
    $menuUpdate->bindParam(':sort1',$_GET["sort1"],PDO::PARAM_INT);
    $menuUpdate->bindParam(':sort2',$_GET["sort2"],PDO::PARAM_INT);
    $menuUpdate->bindParam(':sort3',$_GET["sort3"],PDO::PARAM_INT);
    $menuUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $menuUpdate->execute();

}

foreach ($menuSelect as $row) {

    echo '<p><form action="" method="get">
            <b>'.$row["id"].'. </b>
        title: <input name="title" id="title'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("title'.$row["id"].'").
            value ="'.$row["title"].' ";</script>
        link: <input name="link" id="link'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("link'.$row["id"].'").
            value ="'.$row["link"].'";</script>
      sort1: <input name="sort1" id="sort1'.$row["id"].'"></b>
        <script type="text/javascript"> document.getElementById("sort1'.$row["id"].'").
        value ="'.$row["sort1"].'";</script> 
      sort2: <input name="sort2" id="sort2'.$row["id"].'"></b>
        <script type="text/javascript"> document.getElementById("sort2'.$row["id"].'").
        value ="'.$row["sort2"].'";</script>
      sort3: <input name="sort3" id="sort3'.$row["id"].'"></b>
        <script type="text/javascript"> document.getElementById("sort3'.$row["id"].'").
        value ="'.$row["sort3"].'";</script>            
         
    
    <input name="id" value='.$row["id"].' type="hidden">
    <!--<input name="cat_start" value="1" type="hidden">-->
    <input name="view" value="menu" type="hidden">
    <input name="update_menu" value="yes" type="hidden">
    <input name="save" value="Save" type="submit"  class="btn-success">
    </p></form>';

}

echo '<form action="" method="get">
        <br>
        <p><b>New menu item:</b></p>
        <label for="new_menu_title">Title:</label> 
        <input type="text" id="new_menu_title" name="title"><br>
        <label for="new_menu_link">Link:</label>
        <input type="text" id="new_menu_link" name="link"><br>
        <label for="new_menu_sort1">Sort1:</label>
        <input type="text" id="new_menu_sort1" name="sort1"><br>
        <label for="new_menu_sort2">Sort2:</label>
        <input type="text" id="new_menu_sort2" name="sort2"><br>
        <label for="new_menu_sort2">Sort3:</label>
        <input type="text" id="new_menu_sort2" name="sort3"><br>

        <input name="new_menu" value="yes" type="hidden">
        <input name="view" value="menu" type="hidden">
        <input type="submit">
    </form>';