<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/28/17
 * Time: 9:23 AM
 * Description: This file asks the user to enter new product type or new container type
*              (with multiple items inside) information.
 */



// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];

if(!isset($_SESSION['donationID'])) {
    header('Location: main2.php');
}

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


    $sql_command = "select BARCODE from TYPE where BARCODE='" . $_POST['barcode'] . "';";
    $result = $conn->query($sql_command); // submitting query to database

    if ($result->num_rows == 0) {
        $sql_command = "INSERT INTO TYPE VALUES('" . $_POST['barcode'] . "','" . $_POST['productOrContainer'] .
            "')";
        $result = $conn->query($sql_command); // submitting query to database
        $_SESSION['barcode'] = $_POST['barcode'];
        if ($_POST['productOrContainer'] == "c") {
            header('Location: newContainer.php');

        } else if ($_POST['productOrContainer'] == "p") {
            header('Location: newProduct.php');

        }

    }

    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }

    // Creating an sql query based on login information provided by user
    $sql_command = "select TYPE from USERS where USERNAME='" . $_SESSION["username"] . "';";
    $result = $conn->query($sql_command);

    $row = $result->fetch_assoc();


    if ($row['TYPE'] == 1) {
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

        <form method="post" id="newItemForm" action="addNewType2.php" style="margin-left: 3%;">

            <label style="">Barcode: </label>
            <input name="barcode" required style="">
            <br>

            <label style="">Is this new item a container with multiple items inside: </label>

            <br>
            <input type="radio" name="productOrContainer" value="c" required>Yes<br/>
            <input type="radio" name="productOrContainer" value="p" required>No<br/>


            <input type="submit" name="submit" style="width: 10%;">

        </form>


    </div>
    </body>
    </html>




    <?php
}
?>

