<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/18/17
 * Time: 11:45 AM
 * Description: This file asks a user to enter a barcode.
 */
session_start(); // start session

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


//    $donationID = $_SESSION['donationID'];
//    $_SESSION['donationID']=$donationID;

    $_SESSION['barcode'] = $_POST['barcode'];
    $onGoingDonation = $_SESSION['onGoingDonation'];

    echo $_SESSION['donationID'];
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


    <form method="post" action="checkBarcode.php" id="checkBarcodeForm" style="margin-left: 3%;">
        <label style="">Enter Barcode: </label>
        <input name="barcode" required style="">
        <br>
        <input type="submit" name="submit">
        <br>


    </form>




</div>
</body>
</html>



    <?php
}
?>

