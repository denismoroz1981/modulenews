<body onunload="bye()">




<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 12.06.18
 * Time: 6:06
 */



session_start();
echo "hello";


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



if (!empty($_GET["plus"])) {require_once("views/rating_change.php");}

if(!empty($_SESSION["username"]))
{if($_SESSION["username"]=="admin")
{

    include_once("admin_layout.php");

} else {
    include_once ("layout.php");
}} else {
    include_once ("layout.php");
}

?>

</body>

<script>
    //function bye() { confirm('Do you wish to leave the site?') ;
    //return false;
    //}
    //window.onunload=bye();
    $(window).bind('beforeunload', function () {
        return "Are you sure you want to exit?";
    });
</script>