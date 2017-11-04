<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 9:47 AM
 * Description: This file asks the user to enter information to generate a dynamic report
 *               including the donation information for a particular period of time.
 */

// Connecting php to mysql server
session_start();
echo $_SESSION['username'];

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

$result = $conn->query($sql_command); // submitting query to database


if ($result->num_rows !== 0) {
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


<p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Food Donation Summary</p>
<div id="outerDiv">

    <!-- This form asks the user to enter the account for which to prepare
         summary of donations.
          It asks also for the month-->
    <form method="post" id="donationSummaryForm" action="prepareDonationSummary.php" style="margin-left: 3%;">


        <label style="">Account Number: </label>
        <input name="accountNum" required style="">
        <br>

        <label style="">Month: </label>
        <input name="month"  style="">
        <br>
        <label style="">Year: </label>
        <input name="year" required style="">
        <br>

        <input type="submit" name="submit" style="width: 10%;">
    </form>
</body>
</html>

    <?php

}
?>
