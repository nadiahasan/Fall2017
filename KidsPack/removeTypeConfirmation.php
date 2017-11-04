<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/5/17
 * Time: 8:36 PM
 * Description: This file includes removes a particular barcode from the database.
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


    <?php

    $sql_command="SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='".$_POST['barcodeToRemove']."';";

    $result = $conn->query($sql_command);

    if($result->num_rows==0){ // If the barcode does not exist in product table

        // Check the CASE_Table
        $sql_command="SELECT * FROM CASE_TABLE WHERE CASE_BARCODE='".$_POST['barcodeToRemove']."';";

        $result = $conn->query($sql_command);

        if($result->num_rows==0){ // barcode does not exist in CASE_TABLE


            ?>
            <p>This barcode does NOT exist.</p>
            <br>
            <form action="removeType.php" method="post">
                <input type="submit" value="Try Again">
            </form>




            <?php


        }else if($result->num_rows==1){ // The barcode does exist in CASE_TABLE


            $sql_command = "DELETE FROM CASE_TABLE WHERE CASE_BARCODE='" . $_POST['barcodeToRemove'] . "';";

            $result = $conn->query($sql_command);

            $sql_command = "DELETE FROM TYPE WHERE BARCODE='" . $_POST['barcodeToRemove'] . "';";

            $result = $conn->query($sql_command);



            $sql_command = "SELECT * FROM CASE_TABLE WHERE CASE_BARCODE='" . $_POST['barcodeToRemove'] . "';";

            $result1 = $conn->query($sql_command);

            $sql_command = "SELECT * FROM TYPE WHERE BARCODE='" . $_POST['barcodeToRemove'] . "';";

            $result2 = $conn->query($sql_command);


            if(($result1->num_rows==0) && ($result2->num_rows==0) ){
                ?>

                <p>
                    Barcode Successfully Deleted.
                </p>

                <?php
            }


        }



    }else if($result->num_rows==1) { // If the barcode exists in product table

        $sql_command = "DELETE FROM PRODUCT WHERE PRODUCT_BARCODE='" . $_POST['barcodeToRemove'] . "';";

        $result = $conn->query($sql_command);

        $sql_command = "DELETE FROM TYPE WHERE BARCODE='" . $_POST['barcodeToRemove'] . "';";

        $result = $conn->query($sql_command);


        $sql_command = "SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='" . $_POST['barcodeToRemove'] . "';";

        $result1 = $conn->query($sql_command);

        $sql_command = "SELECT * FROM TYPE WHERE BARCODE='" . $_POST['barcodeToRemove'] . "';";

        $result2 = $conn->query($sql_command);

        if (($result1->num_rows == 0) && ($result2->num_rows == 0) ) {

            ?>


            <p>
                Barcode Successfully Deleted.
            </p>

            <?php

        } else {
            ?>
            <p>
                Barcode Was not Deleted.
            </p>
            <br>
            <form action="removeType.php" method="post">
                <input type="submit" value="Try Again">
            </form>
            <?php


        }
    }else{

        ?>
        <p>This barcode does NOT exist.</p>
        <br>
        <form action="removeType.php" method="post">
            <input type="submit" value="Try Again">
        </form>




        <?php
    }


    ?>

    </body>
    </html>

    <?php
    $conn->close();

}
?>



