<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/4/17
 * Time: 12:01 PM
 * Description: This file inserts purchase information into the database.
 */

session_start(); // start session



if (!isset($_SESSION['username'])) {// checking if user is allowed to access this page
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


// If there is at least one user with the same username or email, display an error message

    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

    $row = $result->fetch_assoc();


    if ($row['TYPE'] == 1) {
        include "adminMenu.php";
    }


    $sql_command = "INSERT INTO PURCHASE VALUES(DEFAULT,'" . $_POST['purchaseDate'] . "','"
        . $_POST['empID'] . "',0.0,'" . $_POST['storeBought'] . "','"
        . $_POST['notes'] . "');";

    $result = $conn->query($sql_command); // submitting query to database

    // Retrieve the assigned donation Id from database
    // ASSUMPTION: NO TWO IDENTICAL PURCHASES ARE MADE ON SAME DATE
    $sql_command = "SELECT PURCHASE_ID FROM PURCHASE WHERE EMPLOYEE_ID='" .  $_POST['empID'].
        "' AND TOTAL_PRICE='0.0' AND PURCHASE_DATE='" . $_POST['purchaseDate'] .
        "'AND STORE_BOUGHT='" . $_POST['storeBought'] . "' ORDER BY PURCHASE_ID DESC;";

    $result = $conn->query($sql_command); // submitting query to database

//    echo "hello";
    $row= $result->fetch_assoc();


    $purchaseID = $row['PURCHASE_ID'];

//    echo "hello2";


    echo "purchase ID: ". $purchaseID;

    $_SESSION['purchaseID']= $purchaseID;

    echo "<br>";

    $onGoingPurchase = 1;
    $_SESSION['onGoingPurchase'] = $onGoingPurchase;

    $onGoingDonation=0;
    $_SESSION['onGoingDonation'] = $onGoingDonation;



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

            #optionsList {
                border: solid;
                background-color: antiquewhite;
                padding-right: 7%;
                padding-left: 10%;
                float: left;
                margin-left: 25%;

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


    <ul id="optionsList">

        <li>
            <form action="barcode.php">
                <input type="submit" class="optionList" value="Insert Items for This Purchase"
                       style="margin-top: 5%;">
            </form>

        </li>


    </ul>

    </body>
    </html>


    <?php
    $conn->close();
}
?>
