<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 18.06.18
 * Time: 22:12
 */

$ratingChange = $dbn->prepare('UPDATE comments SET 
      plus=:plus       
         WHERE id=:id
        ');

$ratingChange->bindParam(':plus',$_GET["plus"],PDO::PARAM_INT);
$ratingChange->bindParam(':id',$_GET["id"],PDO::PARAM_INT);

$ratingChange->execute();


