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
    <style>
    #myPrompt {
    position: fixed;
    padding: 10px 20px;
    /* красивости... */

    border: 1px solid #b3c9ce;
    border-radius: 4px;
    text-align: center;
    font: italic 14px/1.3 arial, sans-serif;
    color: #333;
    background: #fff;
    box-shadow: 3px 3px 3px rgba(0, 0, 0, .3);
    }
    .block-hidden{
        display: none;
    }

    .home-active:hover {
        color: darkblue;
        font-size: 120%;
    }

    .home-active:hover .block-hidden{
        display: block;

    }
    .home-active:hover .block-tohide{
        display: none;

    }

    </style>





</head>
<? require_once ('user_auth.php');
$colors = $dbn->query('SELECT id,`name`, color FROM colors')->fetchAll();




?>

<body style="background-color: <?= $colors[1]["color"]?>">


<div class="container-fluid">
    <div class="row" style="background-color: <?= $colors[0]["color"]?>">
    <div class="col-md-3">
        <? require_once ("views/tags_search.php") ?>
    </div>
    <div class="col-md-5">
        <? require_once ("views/search_form.php") ?>
    </div>
        <div class="col-md-4">
            <? require_once ("views/menu.php") ?>
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
    <h3>Ads:</h3>
        <?
        require_once ('views/show_ads.php');
        for($i=0;$i<=2;$i++) {
            $discounted = round(intval($adsToShow[$i]["price"])*0.9);
            echo '<div class="home-active">Buy '.$adsToShow[$i]["item"].
                ' for UAH<span class="block-tohide">'.$adsToShow[$i]["price"].'</span><span class="block-hidden">'.$discounted.
                '</span> from '.$adsToShow[$i]["vendor"].'<br>';
            echo '<div class="block-hidden" style="margin: 5px;"><b>
            Coupon for discount -'.generatePassword().'- apply and obtain discount!.</b></div>';
            echo '</div>';
        }
        ?>


    </div>
    <div class="col-md-8">
        <?php
        if(!empty($_GET["tag"])) {
            require_once ("views/tags.php");
        } elseif (!empty($_GET["cat"])) {
            require_once ("views/category_front.php");
        } elseif (!empty($_GET["user"])) {
            require_once("views/user_comments.php");
        } elseif (!empty($_GET["search_form"])) {
            require_once("views/news_found.php");

        } else {

            require_once("views/news_start.php");
        }






        ?>

    </div>
    <div class="col-md-2">
        <h3>Adds:</h3>
        <? for($i=3;$i<=5;$i++) {
            echo '<div class="home-active">Buy '.$adsToShow[$i]["item"].
                ' for UAH<span class="block-tohide">'.$adsToShow[$i]["price"].'</span><span class="block-hidden">'.$discounted.
                '</span> from '.$adsToShow[$i]["vendor"].'<br>';
            echo '<div class="block-hidden" style="margin: 5px;"><b>
            Coupon for discount -'.generatePassword().'- apply and obtain discount!.</b></div>';
            echo '</div>';

        }

        ?>

    </div>
</div>
</div>
<? if (empty($_SESSION["subscribe"])) {
echo '<div id="myPrompt" style="position: absolute; z-index: 123; display: none">
<table>
    <tr>
        <td>
    <form>
    <p>Subscribe?</p>
    <input type="text" placeholder="email@site.com"><br>
    <input type="text" placeholder="Enter your name"><br>
    <input type="submit" value="yes">
    <input type="submit" value="no">
    
        <input type="hidden" name="subscribe" value="yes">
</form>
        </td>
    </tr>
</table>

</div>';
$_SESSION["subscribe"] = "yes";

}  ?>


</div>
    <script>
        var DB = document.body;
       setTimeout(function() {with (document.getElementById ('myPrompt')) {
            style.display = 'block',
                style.top  = (DB.scrollTop  + DB.clientHeight / 2 - offsetHeight / 2) + 'px',
                style.left = (DB.scrollLeft + DB.clientWidth  / 2 - offsetWidth  / 2) + 'px'
                //,
                //style.display = 'none';
                }},15000);

















    </script>

</body>
<footer>
    Copyright
</footer>
</html>
