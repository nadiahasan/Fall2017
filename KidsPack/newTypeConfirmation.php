<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/2/17
 * Time: 10:01 AM
 * Description: This file checks if the barcode of the new type already exists or not and
 *              directs the user accordingly.
 */

session_start();
ob_start();


//echo $_SESSION['onGoingDonation'];


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

    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }

    $sql_command = "select BARCODE from TYPE where BARCODE='" . $_POST['barcode'] . "';";
    $result = $conn->query($sql_command); // submitting query to database


    if ($result->num_rows == 0) {
        $sql_command = "INSERT INTO TYPE VALUES('" . $_POST['barcode'] . "','" . $_POST['productOrCase'] .
            "')";
        $result = $conn->query($sql_command); // submitting query to database
        $_SESSION['barcode'] = $_POST['barcode'];
        if ($_POST['productOrCase'] == "c") {
            header('Location: newCase.php');
            die();

        } else if ($_POST['productOrCase'] == "p") {
            header('Location: newProduct.php');
            die();

        }

    } else {

        $row=$result->fetch_assoc();
        if($row['TYPE']=='p'){

            $sql_command = "select * from PRODUCT where PRODUCT_BARCODE='" . $_POST['barcode'] . "';";
            $result = $conn->query($sql_command); // submitting query to database
            if($result->num_rows != 0){
                header('Location: error1.php');
                die();
            }
            $_SESSION['barcode'] = $_POST['barcode'];
            if ($_POST['productOrCase'] == "c") {
                header('Location: newCase.php');
                die();

            } else if ($_POST['productOrCase'] == "p") {
                header('Location: newProduct.php');
                die();

            }


        }else{
            $sql_command = "select * from CASE_TABLE where CASE_BARCODE='" . $_POST['barcode'] . "';";
            $result = $conn->query($sql_command); // submitting query to database
            if($result->num_rows != 0){
                header('Location: error1.php');
                die();
            }
            $_SESSION['barcode'] = $_POST['barcode'];
            if ($_POST['productOrCase'] == "c") {
                header('Location: newCase.php');
                die();

            } else if ($_POST['productOrCase'] == "p") {
                header('Location: newProduct.php');
                die();

            }
        }





    }
    $conn->close();

}
?>