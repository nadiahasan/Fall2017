<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/29/17
 * Time: 9:34 PM
 * Description: This files adds a new Packing Site to the database.
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

    $conn->close();

// Create a connection to mysql server
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is not successful
    if ($conn->connect_error) {
        die("Connection to serverfailed: " . $conn->connect_error);
    }

    // Inserting address:
    $addressCounter=0; // a counter to save the number of existing identical addresses in database

    // Checking if the submitted address already exists in database
    $sql_command = "SELECT * FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] . "';";
    $result = $conn->query($sql_command); // submitting query to database


    // If address does not exist, add it, and fetch the auto address id
    if ($result->num_rows == 0) {
        //echo "success1";
        //print_r($_POST);

        $sql_command = "INSERT INTO ADDRESS VALUES(DEFAULT,'" . $_POST['addLine1'] . "','"
            . $_POST['addLine2'] . "','". $_POST['county'] ."','" .$_POST['city'] . "','" .  $_POST['state']. "','"
            . $_POST['zipcode'] . "','1','".$_POST['packingSite']."');";

        $result2 = $conn->query($sql_command); // submitting query to database


        echo $sql_command;

        $sql_command = "SELECT * FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] .
            "'AND ADDRESS_LINE2='".$_POST['addLine2']."'AND ZIPCODE='".$_POST['zipcode']."'AND 
            COUNTY='".$_POST['county']."'AND STATE='".$_POST['state']."', AND CITY='".$_POST['city']."', AND 
            PACKING_SITE=1 , AND PACKING_SITE_NAME='".$_POST['packingSite']."';";
        $result2 = $conn->query($sql_command); // submitting query to database
        $addressCounter=1; // update counter value

    }else {// If part or all of address does exist
        echo "I am here";

        // Check if there is an identical address in the database
        while ($row = mysqli_fetch_assoc($result)) {

            if (($row['ADDRESS_LINE1'] === $_POST['addLine1']) && ($row['ADDRESS_LINE2'] === $_POST['addLine2']) &&
                ($row['ZIPCODE'] === $_POST['zipcode']) && ($row['COUNTY'] === $_POST['county']) &&
                ($row['STATE'] === $_POST['state']) && ($row['CITY'] === $_POST['city'])
                && ($row['PACKING_SITE'] == 1) && ($row['PACKING_SITE_NAME'] === $_POST['packingSite']) ) {
                echo "I am here2";
                $addressCounter=$addressCounter+1; // increment identical address counter

            }

        }
    }

    echo "<br>";
    echo"counter is ". $addressCounter;
    echo "<br>";

    if($addressCounter == 0){ // if an identical address doesn't exist, add it to database

        $sql_command = "INSERT INTO ADDRESS VALUES(DEFAULT,'" . $_POST['addLine1'] . "','"
            . $_POST['addLine2'] . "','" .  $_POST['county']. "','" . $_POST['city'] . "','"
            . $_POST['state']."','" .$_POST['zipcode'] . "', 1, '".$_POST['packingSite']."');";

        $result2 = $conn->query($sql_command); // submitting query to database

    }
    ?>
    <head>

    </head>
    <body>

    <h2>Address Added Successfully.</h2>
    <form action="insertPackingSiteAddress.php">
        <input type="submit" value="Add Another Packing Site Address." style="width: 200px; background-color: coral; height: 40px;"/>
    </form>
    </body>

    <?php


}
?>


