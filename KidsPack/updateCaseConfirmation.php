<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/11/17
 * Time: 10:41 AM
 * Description: This file updates case information in the database.
 */

session_start(); // start session
ob_start();

//check if the original case barcode exists
if (!isset($_SESSION['conBarcodeUpdate'])) {
    header('Location: updateCaseInfo.php');
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

    if ($_SESSION['conBarcodeUpdate'] != $_POST['caseBarcode']) {

        // Checking if the new barcode exists in the database
        $sql_command = "SELECT * FROM  CASE_TABLE WHERE CASE_BARCODE='" . $_POST['caseBarcode'] . "';";
        $result = $conn->query($sql_command); // submitting query to database

        if ($result->num_rows == 1) { // if the barcode exists, user has to enter another value
            ?>

            <p>This barcode already exists.</p>
            <br>
            <form action="updateCaseInfo.php" method="post">
                <input type="submit" value="Try Again">
            </form>

            <?php
        } else {
            //echo "hello2";
            // Updating case information
            $sql_command = "UPDATE CASE_TABLE SET CASE_BARCODE='" . $_POST['caseBarcode'] . "',
        CONTAINER_TYPE_ID='" . $_POST['caseType'] . "',COUNT_PER_CASE='" . $_POST['count'] . "',
        CASE_PRICE='" . $_POST['casePrice'] . "' WHERE CASE_BARCODE='" . $_SESSION['conBarcodeUpdate'] . "';";
            $result = $conn->query($sql_command); // submitting query to database

            $sql_command = "UPDATE TYPE SET BARCODE='" . $_POST['caseBarcode'] . "'WHERE BARCODE=
        '" . $_SESSION['conBarcodeUpdate'] . "';";
            $result = $conn->query($sql_command); // submitting query to database


        }

    }


    if ($_SESSION['conBarcodeUpdate'] == $_POST['caseBarcode']) {

        // echo "hello1";
        $sql_command = "UPDATE CASE_TABLE SET CONTAINER_TYPE_ID='" . $_POST['containerType'] . "',COUNT_PER_CASE='" . $_POST['count'] . "',
        CASE_PRICE='" . $_POST['casePrice'] . "' WHERE CASE_BARCODE='" . $_SESSION['conBarcodeUpdate'] . "';";
        $result = $conn->query($sql_command); // submitting query to database


    }

    // unsetting the session variable that carries the original barcode
    unset($_SESSION['conBarcodeUpdate']);

    if ($_POST['modifyInternal'] == 'y') {

        //echo "modify";
        header('Location: updateProductInfo.php');


    } else {
        ?>

        <p>Update was successful.</p>
        <br>

        <?php
    }
    $conn->close();

}


?>

