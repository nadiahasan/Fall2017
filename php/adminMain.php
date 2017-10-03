<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/24/17
 * Time: 8:51 AM
 *
 **/

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
        .adminList{
            margin-bottom: 2%;
            margin-top: 3%;
            font-size: larger;
            background-color: lightcoral;


        }
    </style>



</head>

<body>
<?php
include "topMenu.php";

?>


<ul id="functionsList">


    <li>
        <form action="inventory.php">
            <input type="submit" value="Inventory Management" class="adminList" style="margin-top: 10%;">
        </form>
    </li><br/>
    <li><form action="users.php">
            <input type="submit" value="Users Management" class="adminList">
        </form></li><br/>

</ul>


</body>
</html>


