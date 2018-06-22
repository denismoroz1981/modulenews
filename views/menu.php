<?php
/**
 * Created by PhpStorm.
 * User: denismoroz
 * Date: 20.06.18
 * Time: 22:34
 */

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Тег input, атрибут list</title>
    <style>
        #primary_nav_wrap
        {
            margin-top:15px
        }

        #primary_nav_wrap ul
        {
            list-style:none;
            position:relative;
            float:left;
            margin:0;
            padding:0
        }

        #primary_nav_wrap ul a
        {
            display:block;
            color:#333;
            text-decoration:none;
            font-weight:700;
            font-size:12px;
            line-height:32px;
            padding:0 15px;
            font-family:"HelveticaNeue","Helvetica Neue",Helvetica,Arial,sans-serif
        }

        #primary_nav_wrap ul li
        {
            position:relative;
            float:left;
            margin:0;
            padding:0
        }

        #primary_nav_wrap ul li.current-menu-item
        {
            background:#ddd
        }

        #primary_nav_wrap ul li:hover
        {
            background:#f6f6f6
        }

        #primary_nav_wrap ul ul
        {
            display:none;
            position:absolute;
            top:100%;
            left:0;
            background:#fff;
            padding:0
        }

        #primary_nav_wrap ul ul li
        {
            float:none;
            width:200px
        }

        #primary_nav_wrap ul ul a
        {
            line-height:120%;
            padding:10px 15px
        }

        #primary_nav_wrap ul ul ul
        {
            top:0;
            left:100%
        }

        #primary_nav_wrap ul li:hover > ul
        {
            display:block
        }
    </style>
</head>


<body>

<nav id="primary_nav_wrap">
    <ul>
                        <?
                        $menuSelect = $dbn->query('SELECT id,title,link,sort1,sort2,sort3 
                      FROM menu ORDER BY sort1,sort2,sort3')->fetchAll();
                        //echo '<li>';
                        for($i=0;$i<count($menuSelect);$i++) {

                            $j = $i+1;
                            if ($j>=count($menuSelect)) {$j=0;}
                            if(!$menuSelect[$i]["sort2"]) {
                            echo '<li><a href="'.$menuSelect[$i]["link"].'">'.$menuSelect[$i]["title"].'</a>';
                            if (!$j) {echo '</li>'; continue;}
                            if(!$menuSelect[$j]["sort2"]) {
                                echo '</li>'; continue;
                            } else {
                                echo '<ul>'; continue;
                            }

                            }
                            if(!$menuSelect[$i]["sort3"]) {
                                echo '<li><a href="'.$menuSelect[$i]["link"].'">'.$menuSelect[$i]["title"].'</a>';
                                if (!$j) {echo '</li></ul>'; continue;}
                                if(!$menuSelect[$j]["sort3"]) {
                                    echo '</li>';
                                    if (!$menuSelect[$j]["sort2"]) {
                                        echo '</ul>'; continue;
                                    } else {continue;}
                                } else {
                                    echo '<ul>'; continue;
                                }

                            }
                            echo '<li><a href="'.$menuSelect[$i]["link"].'">'.$menuSelect[$i]["title"].'</a></li>';
                            if (!$j) {echo '</li></ul></ul>'; continue;}
                            if(!$menuSelect[$j]["sort3"]) {
                                echo '</ul>';
                                    if (!$menuSelect[$j]["sort2"]) {
                                        echo '</ul>'; continue;
                                    }
                                } else { continue;}




                        }






                        ?>

    </ul>
</nav>
</html>
