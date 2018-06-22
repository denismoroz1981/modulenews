<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 21.06.18
 * Time: 22:50
 */
echo '<p><b>Colors management</b></p>';


$colorSelect = $dbn->query('SELECT id,`name`, color FROM colors')->fetchAll();

$colorInsert= $dbn->prepare('INSERT INTO colors SET 
      `name`=:nametag,
      color=:color
              
        ');
$colorUpdate= $dbn->prepare('UPDATE colors SET 
      `name`=:nametag,
      color=:color,
      WHERE id=:id
        ');

if (!empty($_GET["new_color"])) {

    $colorInsert->bindParam(':nametag',$_GET["name"],PDO::PARAM_STR);
    $colorInsert->bindParam(':color',$_GET["color"],PDO::PARAM_STR);
    $colorInsert->execute();

}

if (!empty($_GET["update_color"])) {

    $colorUpdate->bindParam(':nametag',$_GET["name"],PDO::PARAM_STR);
    $colorUpdate->bindParam(':color',$_GET["color"],PDO::PARAM_STR);
    $colorUpdate->bindParam(':id',$_GET["id"],PDO::PARAM_INT);
    $colorUpdate->execute();

}

foreach ($colorSelect as $row) {

    echo '<p><form action="" method="get">
            <b>'.$row["id"].'. </b>
        Tag name: <input name="name" id="name'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("name'.$row["id"].'").
            value ="'.$row["name"].' ";</script>
        Color: <input name="color" id="color'.$row["id"].'"></b>
            <script type="text/javascript"> document.getElementById("color'.$row["id"].'").
            value ="'.$row["color"].' ";</script>
            
         
    
    <input name="id" value="'.$row["id"].'" type="hidden">
   
    <input name="view" value="colors" type="hidden">
    <input name="update_color" value="yes" type="hidden">
    <input name="save" value="Save" type="submit"  class="btn-success">
    </p></form>';

}

echo '<form action="" method="get">
        <br>
        <p><b>New color item:</b></p>
        <label for="new_color_name">Name:</label> 
        <input type="text" id="new_color_name" name="name"><br>
        <label for="new_color">Color:</label>
        <input type="text" id="new_color" name="color"><br>
        

        <input name="new_color" value="yes" type="hidden">
        <input name="view" value="colors" type="hidden">
        <input type="submit">
    </form>';