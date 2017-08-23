<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 8:32 PM
 */

?>


<html>
<head>
    <style>
        ul{
            list-style-type: none;
            margin: 0;
            padding: 0%;

        }
        li{
            display: inline;
            margin-right: 2%;

        }
        li:hover{
            background-color: coral;
        }

        label{

            font-size: larger;

        }

        input{
            margin-bottom: 1%;
            background-color: antiquewhite;

        }

        #functionsList{
            border: solid;
            background-color: antiquewhite;
            padding-right: 7%;
            padding-left: 10%;
            float: left;
            margin-left: 25%;

        }
        body{
            background-color: ghostwhite;
        }
        .list{
            margin-bottom: 2%;
            margin-top: 2%;
            font-size: larger;
            background-color: lightcoral;


        }
    </style>



</head>



<body>

<div id="navBar" style="background-color: darksalmon; padding: 1%;">


    <ul>
        <li style="margin-left: 0%; font-weight: bold; font-size: larger;">KidsPack</li>
        <li><a href="main.php">Home</a></li>
        <li style="float: right;">Search:<form method="post" action="main.php" style="display: inline;"><input type="text" name="searchText"/></form></li>

    </ul>
</div>
<p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
<ul id="functionsList">
    <li><button class="list" style="margin-top: 5%;">Add Items</button></li><br>
    <li><button class="list">Remove Items</button></li><br>
    <li><button class="list">View Items in Stock</button></li><br>
    <li><button class="list">View Items out of Stock</button></li><br>
    <li><button class="list">View Invenroty Contents</button></li><br>
    <li><button class="list">Insert Donated Food Info</button></li><br>
    <li><button class="list">Place Orders</button></li><br>
    <li><button class="list">View Reports</button></li><br>
    <li><button class="list" style="margin-bottom: 5%;">Inventory Backup</button></li><br>

</ul>


</body>

