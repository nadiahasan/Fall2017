<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/30/17
 * Time: 10:05 AM
 * Description:
 *
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


    <h2>Recent Pull Sheets</h2>

    </body>
    </html>
    <table>
        <tr>
            <th>Items</th>
<!--            <th>Case Quantity</th>-->
<!--            <th>Number of Cases to Pull</th>-->
<!--            <th>Initials</th>-->
            <th>Amount Per Pack</th>

        </tr>
        <tr>
            <td>Chef Boyardee(Sams)</td>
            <td>2</td>
        </tr>
        <tr>
            <td>Trail Mix(Sams)</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Berry Pop Tarts</td><td>1</td>
        </tr>
        <tr>
            <td>Cinnamon Pop Tarts</td>
            <td>1</td>
        </tr>

        <tr>
            <td>Peanut Butter Crackers(Sams)</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Cheddar Cheese Crackers(Sams)</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Breakfast Bars</td>
            <td>1</td>
        </tr>

        <tr>
            <td>Fruit</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Apple Sauce</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Apple Juice</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Spoons</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Plates</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Plastic Wrap</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Extra Items</td>
            <td>1</td>
        </tr>
        <tr>
            <td>Kids Pack Boxes</td>
            <td></td>
        </tr>
        <tr>
            <td>Pre-Packed Meal Packs</td>
            <td></td>
        </tr>
        <tr>
            <td>Backpacks</td>
            <td></td>
        </tr>
        <tr>
            <td>Care Packages</td>
            <td></td>
        </tr>
        <tr>
            <td>Tape gun /tape</td>
            <td></td>
        </tr>
        <tr>
            <td>Razor Knives</td>
            <td></td>
        </tr>
        <tr>
            <td>Table Legs</td>
            <td></td>
        </tr>
        <tr>
            <td>Wrapping Stations</td>
            <td></td>
        </tr>
        <tr>
            <td>Food Drive Collection Bin</td>
            <td></td>
        </tr>

    </table>
    </body>
    </html>

    <?php

}
?>







