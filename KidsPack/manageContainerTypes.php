<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/20/17
 * Time: 9:44 AM
 * Description: This file provides a form to update the package types of items inside
 *              bulk items, by adding a new type, removing an existing type, or updating
 *              the names of current types.
 */


// Connecting php to mysql server
session_start();



if (!isset($_SESSION['username']))
{
    header('Location: main2.php');
}
else {

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

    $result1 = $conn->query($sql_command); // submitting query to database



    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }

    // Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }


    $conn->close();


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



    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Item</p>
    <div id="outerDiv">

        <form method="post" id="newPackagingForm" action="newPackageConfirmation.php" style="margin-left: 3%;">

            <label style="">Add a new packaging type: </label>
            <input name="newPackage" required style="">
            <br>
            <input type="submit" name="submit" style="width: 10%;">
        </form>

        <form method="post" id="deletePackageForm" action="deletePackageConfirmation.php" style="margin-left: 3%;">

            <label style="">Packaging type to remove: </label>
            <input name="deletePackage" required style="">
            <br>

            <input type="submit" name="submit" style="width: 10%;">

        </form>

        <form method="post" id="updatePackageForm" action="renamePackage.php" style="margin-left: 3%;">

            <input type="submit" name="submit" value="Rename Package" style="width: 10%;">

        </form>



    </body>
    </html>

    <?php

}
?>


