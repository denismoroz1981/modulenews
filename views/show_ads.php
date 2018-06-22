<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 21.06.18
 * Time: 19:54
 */

function generatePassword($length = 8){
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}


$adsToShow = $dbn->query('SELECT id, sort, item, price, vendor,isvisible FROM ads 
WHERE isvisible=1 ORDER BY sort LIMIT 6' )->fetchAll();

//$limit = count($adsToShow);
//$adsBlock1="";
//$adsBlock2="";
//$lim1 = 3;
//$lim2 = 6;




