<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 16.06.18
 * Time: 12:17
 */

if (empty($_GET["news_id"])) {
    require_once("news_list.php");
} else {
    require_once ("news_id.php");

}