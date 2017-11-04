<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/23/17
 * Time: 11:12 AM
 * Description: This file includes a navigation menu placed on top of document.
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

    </style>
</head>


<body>


<div id="navBar" style="background-color: darksalmon; padding: 1%;">


    <ul>
        <li style="margin-left: 0%; font-weight: bold; font-size: larger;">KidsPack</li>
        <li><a href="main.php">Home</a></li>
        <li style="float: right;">Search:<form method="post" action="main.php" style="display: inline;"><input name="searchText"/></form></li>
        <?php

        if(isset($_SESSION['username'])) {

            ?>

            <li>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "root";
                $dbname = "INVENTORY";

                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check if connection is not successful
                if ($conn->connect_error) {
                    die("Connection to serverfailed: " . $conn->connect_error);
                }

                // Creating an sql query based on login information provided by user
                $sql_command="select FIRSTNAME from USERS where USERNAME='".$_SESSION['username']."';";
                $result = $conn->query($sql_command);

                $row=$result->fetch_assoc();


                echo "Welcome ".$row['FIRSTNAME'];
                ?>

            </li>

            <li><form action="logout.php">
                    <input type="submit" value="Log out">
                </form>
            </li>


            <?php
        }

        ?>


    </ul>
</div>

    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Welcome to KidsPack</p>


</body>
</html>
