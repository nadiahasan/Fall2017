<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 9:06 PM
 * Description: This file updates product information in the database.
 */

session_start(); // start session


//check if the original product barcode exists
if(!isset($_SESSION['prodBarcodeUpdate'])) {
    header('Location: updateProductInfo.php');
}

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


    // Checking if the new barcode exists in the database
    $sql_command = "SELECT * FROM  PRODUCT WHERE PRODUCT_BARCODE='" . $_POST['productBarcode'] . "';";
    $result = $conn->query($sql_command); // submitting query to database


    if ($result->num_rows == 1) { // if the barcode exists, user has to enter another value
        ?>

        <p>This already barcode exists.</p>
        <br>
        <form action="updateProductInfo.php" method="post">
            <input type="submit" value="Try Again">
        </form>

        <?php
    } else {

        if($_SESSION['prodBarcodeUpdate'] == $_POST['productBarcode']){


            echo "hello1";
            // Updating product information
            $sql_command = "UPDATE PRODUCT SET PRODUCT_NAME='" . $_POST['productName'] . "',PRODUCT_PRICE='" . $_POST['productPrice'] . "',
        MIN_QUANTITY_IN_STOCK=" . $_POST['prodMin'] . ",PROD_DESCRIPTION='" . $_POST['prodDesc'] . "'
        WHERE PRODUCT_BARCODE='".$_SESSION['prodBarcodeUpdate']."';";
            $result = $conn->query($sql_command); // submitting query to database




        }else{

            echo "hello2";
            // Updating product information
            $sql_command = "UPDATE PRODUCT SET PRODUCT_BARCODE='" . $_POST['productBarcode'] . "',
        PRODUCT_NAME='" . $_POST['productName'] . "',PRODUCT_PRICE='" . $_POST['productPrice'] . "',
        MIN_QUANTITY_IN_STOCK=" . $_POST['prodMin'] . ",PROD_DESCRIPTION='" . $_POST['prodDesc'] . "'
        WHERE PRODUCT_BARCODE='".$_SESSION['prodBarcodeUpdate']."';";
            $result = $conn->query($sql_command); // submitting query to database

            $sql_command="UPDATE TYPE SET BARCODE='".$_POST['productBarcode']."'WHERE BARCODE=
        '".$_SESSION['prodBarcodeUpdate']."';";
            $result = $conn->query($sql_command); // submitting query to database

            // update CASE_TABLE  if this product barcode belongs in a bulk case
            $sql_command="SELECT * FROM CASE_TABLE WHERE PRODUCT_BARCODE='".$_SESSION['prodBarcodeUpdate']."';";
            $result = $conn->query($sql_command); // submitting query to database

            if($result->num_rows==1){
                echo "hello3";
                $sql_command="UPDATE CASE_TABLE SET PRODUCT_BARCODE='".$_POST['productBarcode']."'WHERE PRODUCT_BARCODE=
        '".$_SESSION['prodBarcodeUpdate']."';";
                $result = $conn->query($sql_command); // submitting query to database

            }

        }

        // unsetting the session variable that carries the original barcode
        unset($_SESSION['prodBarcodeUpdate']);
?>

        <p>Update was successful.</p>
        <br>


<?php

    }

    $conn->close();
}


    ?>

