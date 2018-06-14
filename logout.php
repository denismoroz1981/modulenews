<?php

/**
 * Created by PhpStorm.
 * Company: WD&SS
 * Date: 24.04.2017
 * Time: 19:27
 */
session_start();


if (!empty($_SESSION["user_id"])) {
    unset($_SESSION["user_id"]);
}
if (!empty($_SESSION['username'])) {
    unset($_SESSION['username']);
}



session_destroy();
header('location:index.php');
