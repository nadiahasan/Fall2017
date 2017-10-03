<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 8:32 PM
 *  Description: This file displays inventory list options.
 */

session_start();
echo $_SESSION['username'];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "INVENTORY";

// Create a connection to mysql server
$conn = new mysqli($servername, $username, $password,$dbname);

// Check if connection is not successful
if ($conn->connect_error) {
    die("Connection to serverfailed: " . $conn->connect_error);
}

$sql_command="select * from USERS where USERNAME='".$_SESSION['username']."';";

$result = $conn->query($sql_command); // submitting query to database


include "topMenu.php";
// Creating an sql query based on login information provided by user
$sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
$result = $conn->query($sql_command);

$row=$result->fetch_assoc();


if($row['TYPE']==1){
    include "adminMenu.php";
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
                background-color: antiquewhite;

            }

            #functionsList {
                border: solid;
                background-color: antiquewhite;
                padding-right: 7%;
                padding-left: 10%;
                float: left;
                margin-left: 25%;

            }

            body {
                background-color: ghostwhite;
            }

            .inventoryList {
                margin-bottom: 2%;
                margin-top: 2%;
                font-size: larger;
                background-color: lightcoral;

            }
        </style>


    </head>


    <body>


    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
    <ul id="functionsList">


        <form action="addDonations.php">
            <input type="submit" class="inventoryList" value="Insert Donations" style="margin-top: 5%;">
        </form>

        <form action="addNewType.php">
            <input type="submit" class="inventoryList" value="Add New Type" style="margin-top: 5%;">
        </form>


        <li>
            <button class="inventoryList">Remove Items</button>
        </li>
        <br>
        <li>
            <button class="inventoryList">Manage Container Types</button>
        </li>
        <br>
        <li>
            <button class="inventoryList">View Items in Stock</button>
        </li>
        <br>
        <li>
            <button class="inventoryList">View Items out of Stock</button>
        </li>
        <br>
        <li>
            <button class="inventoryList">View Invenroty Contents</button>
        </li>
        <br>
        <br>
        <li>
            <button class="inventoryList">Place Orders</button>
        </li>
        <br>
        <li>
            <button class="inventoryList">View Reports</button>
        </li>
        <br>
        <li>
            <button class="inventoryList" style="margin-bottom: 5%;">Inventory Backup</button>
        </li>
        <br>

    </ul>


    </body>

    </html>


