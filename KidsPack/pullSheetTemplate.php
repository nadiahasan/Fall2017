<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 11/2/17
 * Time: 8:57 PM
 */



session_start();
//echo $_SESSION['username'];

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


    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Create a New Pull Sheet Template</p>
    <div id="outerDiv">

        <form method="post" id="pullSheetTemplateForm" action="insertPullSheetItems.php" style="margin-left: 3%;">



            <label style="">Template Name: </label>
            <input name="templateName" required style="">
            <br>


            <input type="submit" name="submit" style="width: 10%;">

        </form>

    </div>

    </body>
    </html>

    <?php
    $conn->close();
}
?>

