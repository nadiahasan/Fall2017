<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/16/17
 * Time: 9:30 AM
 * Description: This file adds a new pull sheet information into the database, then
 *              displays the result to the user.
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
    $row = $result->fetch_assoc();
    if ($row['TYPE'] == 1) {

        include "adminMenu.php";
    }


// If there is at least one user with the same username or email, display an error message

    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

    echo "<br>";
    //echo "counter is " . $addressCounter;
    echo "<br>";


    $sql_command = "SELECT * FROM ADDRESS WHERE PACKING_SITE=1 AND PACKING_SITE_NAME='".$_POST['packingSite']."';";
    $result2 = $conn->query($sql_command); // submitting query to database


    $row = $result2->fetch_assoc();
    $addID = $row['ADDRESS_ID'];


    $deliveryDay = "SELECT WEEKDAY('" . $_POST['deliveryDate'] . "');";
    $calculateResult = $conn->query($deliveryDay);

    echo "-----------";
    $deliveryDay = $calculateResult->fetch_assoc();

    foreach ($deliveryDay as &$value) {
        echo $value;
    }

    $day = '';
    if ($value == 0) {
        $day = 'Monday';
    } else if ($value == 1) {
        $day = 'Tuesday';
    } else if ($value == 2) {
        $day = 'Wednesday';
    } else if ($value == 3) {
        $day = 'Thursday';
    } else if ($value == 4) {
        $day = 'Friday';
    } else if ($value == 5) {
        $day = 'Saturday';
    } else if ($value == 6) {
        $day = 'Sunday';
    }

    $totalForPacking = $_POST['numWeeks'] * $_POST['numCells'];

    echo "total: " . $totalForPacking . "<br>";
    $sql_command = "INSERT INTO PULL_SHEET VALUES('DEFAULT','" . $_POST['packingSite'] . "','" . $addID . "',null,
        '" . $day . "','" . $_POST['deliveryDate'] . "','" . $_POST['numWeeks'] . "','" .
        $_POST['numCells'] . "'," . $totalForPacking . ",'" . $_POST['notes'] . "');";

    //echo $sql_command;
    $queryResult = $conn->query($sql_command);


    $sql_command = "SELECT * FROM  PULL_SHEET WHERE PACKING_SITE_NAME='" .
        $_POST['packingSite'] . "' AND PACKING_SITE_ADDRESS_ID='" . $addID . "' AND DELIVERY_DAY='" . $day . "' AND DELIVERY_DATE='" . $_POST['deliveryDate'] . "' AND NUM_PACKING_WEEKS=" . $_POST['numWeeks'] . " 
         AND NUM_CELLS_PER_WEEK=" . $_POST['numCells'] . " AND TOTAL_FOR_PACKING=" . $totalForPacking . ";";

    //echo $sql_command;

    $queryResult = $conn->query($sql_command);

    echo "<br>";
    echo "<br>";

    if ($queryResult->num_rows == 0) {
        echo "FAILURE";
    } else {
        $row = $queryResult->fetch_assoc();
        //print_r($row);
        $pullSheetID = $row['PULL_SHEET_ID'];
        $_SESSION['pullSheetID']=$pullSheetID;
        $_SESSION['activePullSheet']=1;

        echo $_SESSION['pullSheetID'];
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
                overflow: auto;

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


    <h2 style="margin-top: 3%; margin-left: 30%;">KidsPACK Product Pull Sheet</h2>

    <div id="outerDiv">

        <div id="addressDiv" style="display: inline-block;">

            <label>Packing Site: </label>

            <?php


            echo "<p style='font-weight: bold;'>" . $_POST['packingSite'] . "</p>";
            ?>

            <?php
            $sql_command="SELECT * FROM ADDRESS WHERE ADDRESS_ID='".$addID."';";
            $qResult = $conn->query($sql_command);
            $row = $qResult->fetch_assoc();
            //echo $sql_command;

            echo $row['ADDRESS_LINE1'];
            echo "<br>";
            echo $row['ADDRESS_LINE2'];
            echo $row['CITY'] . ", ";
            echo $row['STATE'] . " ";
            echo $row['ZIPCODE'];
            ?>

        </div>

        <div id="datesDiv" style="display: inline-block; margin-left: 50%;">

            <label>Delivery Date: </label>
            <?php

            echo $day . "  ";
            echo $_POST['deliveryDate'];
            ?>

    </div>

        <form method="post" action="insertPullSheetItems.php">
            <input type="submit" class="optionList" value="Insert Pull Sheet Items"
                   style="margin-top: 5%; margin-left: 30%; background-color: coral;">
        </form>
    </div>

    </body>
    </html>

    <?php
    //$conn->close();
}
?>


