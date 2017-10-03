<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/20/17
 * Time: 9:49 AM
 *
 * Description: This file contains a form for adding actual "items" to the database.
 */

// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];


if(!isset($_SESSION['donationID'])) {
    header('Location: main2.php');
}

if(!isset($_SESSION['barcode'])){
    header('Location: main2.php');
}


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

// Checking the session variables
    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";

    $result1 = $conn->query($sql_command); // submitting query to database

    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }
$bcode = $_SESSION['barcode'];
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


    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Insert Item: </p>
    <div id="outerDiv">



        <form method="post" id="insertItemForm" action="itemInsertionConfirmation.php" style="margin-left: 3%;">

            <label style="">Barcode:  </label>
            <?php
            echo $bcode;
            ?>
            <br>

            <label style="">Expiration Date: </label>
            <input type="date" name="expDate" required style="">
            <br>

            <label style="">Item Count: </label>
            <input name="itemCount" required  placeholder="1" style="">
            <br>
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

