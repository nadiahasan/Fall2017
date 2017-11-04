<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/12/17
 * Time: 5:55 PM
 * Description: This file deletes a packaging type from the database.
 */

session_start();
ob_start();


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


    // Search for the type to be deleted

    $sql_command = "select * from CONTAINER_TYPE where CONTAINER_TYPE='" . $_POST['deletePackage'] . "';";

    $result = $conn->query($sql_command); // submitting query to database

    if($result->num_rows==0){ // If type not found

        ?>
        <p>This packaging type does not exist.</p>
        <form method="post" action="manageContainerTypes.php">
            <input type="submit" value="Add New Packaging">
        </form>

        <?php

    }else{ // If found

        $row=$result->fetch_assoc();
        $containerTypeID = $row['CONTAINER_TYPE_ID']; // fetch its id from database

        // Searching if this package type is currently used in tables
        $sql_command = "SELECT * FROM CASE_TABLE WHERE CONTAINER_TYPE_ID='".$containerTypeID."';";
        $result = $conn->query($sql_command); // submitting query to database

        if($result->num_rows==0){
            // Deleting the type safely, when not in use
            $sql_command = "DELETE FROM CONTAINER_TYPE WHERE CONTAINER_TYPE_ID='".$containerTypeID."'";
            $result = $conn->query($sql_command); // submitting query to database
        }else{
            ?>
            <p>This Type is Being Used and Can't Be Deleted.</p>
            <?php
        }
        ?>


        <?php
    }
    $conn->close();

}

?>
