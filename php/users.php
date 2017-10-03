<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/24/17
 * Time: 11:57 AM
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
        .usersList{
            margin-bottom: 2%;
            margin-top: 2%;
            font-size: larger;
            background-color: lightcoral;


        }
    </style>

</head>


<body>

<?php
include "topMenu.php";
?>


<p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Users Management</p>
<ul id="functionsList">

    <li><button class="usersList">View Current Users</button></li><br>
    <li><button class="usersList">View Pending Users</button></li><br>
    <li><button class="usersList" style="margin-bottom: 5%;">Users Backup</button></li><br>

</ul>



</body>
</html>
