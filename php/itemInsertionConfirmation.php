<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/27/17
 * Time: 10:31 AM
 * Description: This file inserts a new item into the database and updates corresponding
 *              quantity of stock for this item.
 */


// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];

if(!isset($_SESSION['donationID'])) {
    header('Location: main2.php');
}else if(!isset($_SESSION['barcode'])){
    header('Location: main2.php');
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

// Checking the session variables
    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";

    $result1 = $conn->query($sql_command); // submitting query to database

    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }

    $donationID = $_SESSION['donationID'] ;
//    echo "donation id ".$donationID;
//    echo "<br>";
    $bcode = $_SESSION['barcode'];
//    echo "barcode ".$bcode;


// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }


    // Inserting a new item into ITEMS table in database
    $sql_command = "INSERT INTO ITEMS VALUES(DEFAULT, '".$donationID."','".$bcode.
            "','".$_POST['expDate']."','".$_POST['itemCount']."' )";
    $result2 = $conn->query($sql_command); // submitting query to database



    // Searching for this barcode in the database, to check item type
    $sql_command="SELECT * FROM TYPE WHERE BARCODE='".$bcode."';";
    $result2 = $conn->query($sql_command); // submitting query to database
    $row=$result2->fetch_assoc();


    if($row['TYPE']=='p'){ // if item inserted is a product


        // get product barcode from PRODUCT table
        $sql_command="SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='".$bcode."'";
        $result2 = $conn->query($sql_command); // submitting query to database
        $row2 = $result2->fetch_assoc();

        // retrieve product's current quantity in stock
        $quantity = $row2['QUANTITY_IN_STOCK'];
        $quantity = $quantity+ $_POST['itemCount'];  // increment the quantity

        // update database with new quantity
        $sql_command="UPDATE PRODUCT SET QUANTITY_IN_STOCK='".$quantity."' WHERE PRODUCT_BARCODE='".$bcode."';";
        $result2 = $conn->query($sql_command); // submitting query to database



    }else if($row['TYPE']=='c'){ // if item inserted is a container


        // get container barcode from CONTAINER table
        $sql_command="SELECT * FROM CONTAINER WHERE CONTAINER_BARCODE='".$bcode."'";
        $result2 = $conn->query($sql_command); // submitting query to database
        $row2 = $result2->fetch_assoc();

        // retrieve containers's current quantity in stock

        $quantity = $row2['QUANTITY_IN_STOCK'];
        $quantity = $quantity+ $_POST['itemCount']; // update quantity in stock

        // retrieve other information
        $internalBarcode= $row2['PRODUCT_BARCODE'];
        $countPerContainer = $row2['COUNT_PER_CONTAINER'];

        // update database
        $sql_command="UPDATE CONTAINER SET QUANTITY_IN_STOCK='".$quantity."' WHERE CONTAINER_BARCODE='".$bcode."';";
        $result2 = $conn->query($sql_command); // submitting query to database


        // retrieve product corresponding to internal barcode from PRODUCT table
        $sql_command="SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='".$internalBarcode."'";
        $result2 = $conn->query($sql_command); // submitting query to database
        $row2 = $result2->fetch_assoc();

        $quantity = $row2['QUANTITY_IN_STOCK'];
        $quantity = $quantity+ ($_POST['itemCount']*$countPerContainer); // update quantity in stock

        // update database
        $sql_command="UPDATE PRODUCT SET QUANTITY_IN_STOCK='".$quantity."' WHERE PRODUCT_BARCODE='".$internalBarcode."';";
        $result2 = $conn->query($sql_command); // submitting query to database


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


    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Insert Item: </p>


        <p>Item insertion was successful</p>
        <ul id="optionsList">
            <li>
                <form action="barcode.php">
                    <input type="submit" class="optionList" value="Insert Item for This Donation" style="margin-top: 5%;">
                </form>

            </li>
            <li>
                <form action="addDonations.php">
                    <input type="submit" class="optionList" value="Insert Item for Another Donation" style="margin-top: 5%;">
                </form>


            </li>

            <li>
                <form action="addNewType.php">
                    <input type="submit" class="optionList" value="Insert Another Type for this Donation" style="margin-top: 5%;">
                </form>
            </li>

            <li>
                <form action="addNewType.php">
                    <input type="submit" class="optionList" value="Insert Another Type" style="margin-top: 5%;">
                </form>
            </li>
        </ul>



    </body>
    </html>


    <?php
}
?>


