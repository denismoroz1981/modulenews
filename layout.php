<!DOCTYPE html>
< lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    !-- Latest compiled and minified CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
   <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->

    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
</head>
<body>
<? require_once ('user_auth.php');




?>

<div class="container-fluid">
    <div class="row">
    <div class="col-md-4">
        <? require_once ("views/tags_search.php") ?>
    </div>
    <div class="col-md-8">
    </div>
    </div>


</div>
<div class="row">
    <div class="col-md-10">

    <?
    require_once ('views/news_slider.php');
    require_once ("carusel.php") ?>




    </div>
    <div class="col-md-2">
        <h3>Authorization</h3>
        <?= $userInfo; ?>
        <br>
        <? if (!empty($_SESSION['username'])) {if ($_SESSION['username']=='admin') {
            echo '<p><a href="/index.php?admin=admin">go to admin panel</a></p>';}} ?>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
    <h3>Adds:</h3>
    </div>
    <div class="col-md-8">
        <?php
        if(!empty($_GET["tag"])) {
            require_once ("views/tags.php");
        } elseif (!empty($_GET["cat"])) {
            require_once ("views/category_front.php");
        } elseif (!empty($_GET["user"])) {
            require_once("views/user_comments.php");
        } else {
        ;
            require_once("views/news_start.php");
        }






        ?>

    </div>
    <div class="col-md-2">
        <h3>Adds:</h3>
    </div>
</div>
</div>



</body>
<footer>
    Copyright
</footer>
</html>