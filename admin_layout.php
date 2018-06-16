<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 12.06.18
 * Time: 18:32
 */

/*if (!empty($_SESSION['username']))
{
    if ($_SESSION['username']!='admin') {
    header('location:index.php');
    }
} else {
    header('location:index.php');

} */

//require_once ("categories.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
			<ul class="nav">
				<li class="nav-item">
					<a class="nav-link active" href="/logout.php"><-Back to frontend</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/index.php/?view=categories">Categories</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="/index.php/?view=news">News</a>
				</li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/index.php/?view=comments">Comments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/index.php/?view=approval">Comments to approve</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="/index.php/?view=ads">Ads</a>
                </li>
				<li class="nav-item dropdown ml-md-auto">
					 <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown">Dropdown link</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
						 <a class="dropdown-item" href="#">Action</a> <a class="dropdown-item" href="#">Another action</a> <a class="dropdown-item" href="#">Something else here</a>
						<div class="dropdown-divider">
						</div> <a class="dropdown-item" href="#">Separated link</a>
					</div>
				</li>
			</ul>
		</div>
		<div class="col-md-10">

            <?
            if (!empty($_GET["view"])) {
                if ($_GET["view"]=="categories") {
                    require_once("admin/categories.php");
                }
                if ($_GET["view"]=="news") {
                    require_once("admin/news.php");
                }
                if ($_GET["view"]=="comments") {
                    require_once("admin/comments.php");
                }
                if ($_GET["view"]=="approval") {
                    require_once("admin/approval.php");
                }
                if ($_GET["view"]=="ads") {
                    require_once("admin/ads.php");
                }
            }



            ?>


		</div>

	</div>
</div>
</body>