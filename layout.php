<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    !-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

</head>
<body>
<? require_once ('user_auth.php'); ?>

<div class="container-fluid">
<div class="row">
    <div class="col-md-10">
    <h1>Slider here</h1>





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
    </div>
    <div class="col-md-2">
        <h3>Adds:</h3>
    </div>
</div>
</div>



</body>
</html>