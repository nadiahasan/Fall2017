<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 9:07 PM
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
            background-color: white;

        }

        #outerDiv{
            background-color: #E7EBEE;
            width: 90%;
            border-top: solid;
            border-bottom: solid;
            margin-left: 5%;
            margin-right: 5%;
            padding-top: 2%;


        }
        #outerDiv input{
            width: 30%;
            height: 5%;
        }


        body{
            background-color: ghostwhite;


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
<p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Item</p>
<div id="outerDiv">

    <form method="post" action="addItem.php" style="margin-left: 3%;">

        <label style="">Item Name: </label>
        <input type="text" name="itemName" required style="">
        <br>
        <label style="">Barcode: </label>
        <input type="text" name="barcode" required style="">
        <br>
        <label style="">Item Package Type: </label>
        <input type="text" name="itemPackageType" required style="">
        <br>
        <label style="">Item Price: </label>
        <input type="text" name="itemPrice" required style="">
        <br>
        <label style="">Item Description: </label>
        <input type="text" name="itemName" style="">
        <br>
        <input type="submit" name="submit" style="width: 10%;">


    </form>


</div>

</body>


