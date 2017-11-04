<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/12/17
 * Time: 5:47 PM
 * Description: This file adds a new packaging type in the database.
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



    // Search for the package type in the database
    $sql_command = "select * from CONTAINER_TYPE where CONTAINER_TYPE='" . $_POST['newPackage'] . "';";

    $result = $conn->query($sql_command); // submitting query to database


    // If not found, add it to the database
    if($result->num_rows==0){
        $sql_command = "INSERT INTO CONTAINER_TYPE VALUES(DEFAULT , '".$_POST['newPackage']."')";
        $result = $conn->query($sql_command); // submitting query to database

    }else{
        ?>
        <p>This type already exists.</p>
<?php
    }
    $conn->close();
}
?>
