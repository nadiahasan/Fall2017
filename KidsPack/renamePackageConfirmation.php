<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/12/17
 * Time: 9:36 PM
 * Description: This file renames a packaging type in the database.
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

    // Check if new name already exists in the database, so you don't add it again.

    // Updating the database
    foreach ($_POST as $key => $value){


        $c=explode("input",$key);

        $sql_command="UPDATE CONTAINER_TYPE SET CONTAINER_TYPE='".$value."' WHERE CONTAINER_TYPE_ID='".$c[1]."';";
        $result = $conn->query($sql_command); // submitting query to database

    }
    $conn->close();





}
?>
