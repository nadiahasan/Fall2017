<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/28/17
 * Time: 8:50 AM
 * Description: This file checks if the entered barcode by user in "barcode.php" does
 *              exist or not.
 */


session_start(); // start session

if($_SESSION['onGoingDonation']==1){
    //echo "hello1";
    if(!isset($_SESSION['donationID'])) {
        header('Location: main2.php');
    }
}

if($_SESSION['onGoingPurchase']==1){
     // echo "pid: ".$_SESSION['purchaseID'];
    if(!isset($_SESSION['purchaseID'])) {

        header('Location: main2.php');
    }
}


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


    $sql_command = "SELECT * FROM TYPE WHERE BARCODE='" . $_POST['barcode'] . "';";
    $result2 = $conn->query($sql_command); // submitting query to database

    $_SESSION['barcode'] = $_POST['barcode'];

    if ($result2->num_rows == 0 ) {

        header("Location: addNewType.php");
        die();


    } else if ($result2->num_rows == 1) {

        header("Location: insertItems.php");
        die();
        // echo "exists";

    }

    $conn->close();
}



?>




