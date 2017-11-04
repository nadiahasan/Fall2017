<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/15/17
 * Time: 2:09 PM
 * Description: This file contains the form that collects pull sheet information from the user.
 */


session_start();

if (!isset($_SESSION['username'])) {
    header('Location: main2.php');
} else {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "INVENTORY";

// Create a connection to mysql server
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is not successful
    if ($conn->connect_error) {
        die("Connection to serverfailed: " . $conn->connect_error);
    }

    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";

    $result = $conn->query($sql_command); // submitting query to database


    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

// Creating an sql query based on login information provided by user
    $sql_command = "select TYPE from USERS where USERNAME='" . $_SESSION["username"] . "';";
    $result = $conn->query($sql_command);

    $row = $result->fetch_assoc();


    if ($row['TYPE'] == 1) {
        include "adminMenu.php";
    }

    //$conn->close();


    ?>


    <html>
    <head>


        <style>
            ul {
                list-style-type: none;
                margin: 0;
                padding: 0%;

            }

            li {
                display: inline;
                margin-right: 2%;

            }

            li:hover {
                background-color: coral;
            }

            label {

                font-size: larger;

            }

            input {
                margin-bottom: 1%;
                background-color: white;

            }

            #outerDiv {
                background-color: #E7EBEE;
                width: 90%;
                border-top: solid;
                border-bottom: solid;
                margin-left: 5%;
                margin-right: 5%;
                padding-top: 2%;

            }

            #outerDiv input {
                width: 30%;
                height: 5%;
            }

            body {
                background-color: ghostwhite;

            }
        </style>

    </head>

    <body>


    <h2>KidsPACK Product Pull Sheet</h2>
    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Generate a Pull Sheet</p>
    <div id="outerDiv">

        <form method="post" id="pullSheetForm" action="pullSheetConfirmation.php" style="margin-left: 3%;">

            <label style="">Packing Site: </label>
            <select name="packingSite" required>
                <?php

                $sql_command = "select * from ADDRESS;";
                $result = $conn->query($sql_command); // submitting query to database

                //$numRows = mysqli_num_rows($result);

                $v = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['PACKING_SITE'] == 1) {
                        echo '<option>'.$row['PACKING_SITE_NAME'].'</option>';
                    }
                }

                ?>
            </select>
            <br>
            <br>

            <label style="">Delivery Date: </label>
            <input name="deliveryDate" type="date" required style="">
            <br>
            <br>
            <br>

            <label style="">Number of Weeks:</label>
            <input name="numWeeks" required style="">
            <br>

            <label style="">Number of Cells Per Week:</label>
            <input name="numCells" required style="">
            <br>
            <br>

            <label style="">Notes: </label>
            <textarea rows="3" cols="50" name="notes" style="">
            </textarea>
            <br>
            <br>

            <input type="submit" name="submit" style="width: 10%;">
        </form>

    </div>

    </body>
    </html>

    <?php

}
?>






