<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 13.06.18
 * Time: 20:17
 */
$host = '127.0.0.1';
$dbname='moduleoop';
$user='moduleoopadmin';
$password='';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_CASE => PDO::CASE_NATURAL,
    PDO::ATTR_ORACLE_NULLS => \PDO::NULL_EMPTY_STRING,
    PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,];

global $dbn;

try {
    $dbn = new PDO("mysql:host=$host;dbname=$dbname",
        $user, $password, $options); }
catch
(PDOException $e) {
    echo $e->getMessage();
}
$newsCount = $dbn->query('SELECT COUNT(*) FROM `news`')->fetchAll();
$catsUpdate= $dbn->prepare('UPDATE `news` SET `category_id`=? WHERE `id`=?');
$cats = ["finance","sport","politics"];
//$newsCount = intval($newsCount[0]["COUNT(*)"]);
echo var_export($newsCount,1).'<br>';
for ($i=0;$i<100;$i++) {
    //$rand_cat=array_rand($cats,1);
    //echo $cats[$rand_cat].'<br>';
    $catsUpdate->execute(array("sport",$i));
}