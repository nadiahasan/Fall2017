<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/19/17
 * Time: 11:58 AM
 * Description: A user is supposed to use this form to add a new product "TYPE", not
 *              a specific individual item. It's supposed to collect general information
 *              regarding this type. Another form is used to insert individual items and
 *              collect specific info like expiration date, which varies from one item to
 *              another.
 */

// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];

if(!isset($_SESSION['barcode'])) {
    header('Location: main2.php');
}
echo $_SESSION['barcode'];
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


// Transferring previous session info, container barcode, to this page.
    $barcode=$_SESSION['barcode'];
    $_SESSION['barcode'] = $barcode;

    $onGoingDonation=$_SESSION['onGoingDonation'];



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
    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Product Type</p>
    <div id="outerDiv">

        <form method="post" id="newProductForm" action="newProductConfirmation.php" style="margin-left: 3%;">



            <label style="">Product Name: </label>
            <input name="productName" required style="">
            <br>

            <label style="">Product Price: </label>
            <input name="productPrice" required style="">
            <br>

            <!-- Initial quantity in stock for a new container is 0-->

            <label style="">Set minimum amount for this item in stock: </label>
            <input name="itemMin" style="" placeholder="3000">
            <br>

            <label style="">Product Description: </label>
            <textarea name="prodDescription" style="" rows="4" cols="50"></textarea>
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

