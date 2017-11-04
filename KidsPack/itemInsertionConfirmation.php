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

echo "Hello1";
echo $_SESSION['onGoingDonation'];
echo "<br>";
echo "Hello2";
echo $_SESSION['onGoingPurchase'];
echo "Hello3";


if($_SESSION['onGoingDonation']==1){
    echo "hello1";
    if(!isset($_SESSION['donationID'])) {
        header('Location: main2.php');
    }
}

if($_SESSION['onGoingPurchase']==1){
    echo "hello2";
    if(!isset($_SESSION['purchaseID'])) {
        header('Location: main2.php');
    }
}
if(!isset($_SESSION['barcode'])){
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


// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

    $bcode = $_SESSION['barcode'];


    // If the item being inserted belongs to a donation
    if($_SESSION['onGoingDonation']==1 && isset($_SESSION['donationID'])) {


        echo "<br>" ."successful donation" . "<br>";

        $donationID = $_SESSION['donationID']; // retrieving donationID from session variable
//    echo "donation id ".$donationID;
//    echo "<br>";

//    echo "barcode ".$bcode;

        // Inserting a new item into ITEMS table in database
        $sql_command = "INSERT INTO ITEMS VALUES(DEFAULT, '" . $donationID . "','" . $bcode .
            "','" . $_POST['expDate'] . "','" . $_POST['itemCount'] . "' )";
        $result2 = $conn->query($sql_command); // submitting query to database


        // Searching for this barcode in the database, to check item type
        $sql_command = "SELECT * FROM TYPE WHERE BARCODE='" . $bcode . "';";
        $result2 = $conn->query($sql_command); // submitting query to database
        $row = $result2->fetch_assoc();


        if ($row['TYPE'] == 'p') { // if item inserted is a product


            // get product barcode from PRODUCT table
            $sql_command = "SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='" . $bcode . "'";
            $result2 = $conn->query($sql_command); // submitting query to database
            $row2 = $result2->fetch_assoc();

            // retrieve product's current quantity in stock
            $quantity = $row2['QUANTITY_IN_STOCK'];
            $quantity = $quantity + $_POST['itemCount'];  // increment the quantity
            $price = $row2['PRODUCT_PRICE'];

            // update database with new quantity
            $sql_command = "UPDATE PRODUCT SET QUANTITY_IN_STOCK='" . $quantity . "' WHERE PRODUCT_BARCODE='" . $bcode . "';";
            $result2 = $conn->query($sql_command); // submitting query to database


            //update the current donation total price whenever you insert an item successfully
            $sql_command = "SELECT * FROM DONATION WHERE DONATION_ID='" . $_SESSION['donationID'] . "';";
            $result3 = $conn->query($sql_command); // submitting query to database
            $wholeRow = $result3->fetch_assoc();
            $totalPrice = $wholeRow['TOTAL_PRICE'];
            echo "first: " . $totalPrice . "<br>";
            $totalPrice = $totalPrice + ($_POST['itemCount'] * $price);
            echo "second: " . $totalPrice . "<br>";

            // Updating total price of the donation
            $sql_command = "UPDATE DONATION SET TOTAL_PRICE='" . $totalPrice . "' WHERE DONATION_ID='" . $_SESSION['donationID'] . "';";
            $result3 = $conn->query($sql_command); // submitting query to database


        } else if ($row['TYPE'] == 'c') { // if item inserted is a case


            // get case barcode from case table
            $sql_command = "SELECT * FROM CASE_TABLE WHERE CASE_BARCODE='" . $bcode . "'";
            $result2 = $conn->query($sql_command); // submitting query to database
            $row2 = $result2->fetch_assoc();

            // retrieve case's current quantity in stock

            $quantity = $row2['QUANTITY_IN_STOCK'];
            $quantity = $quantity + $_POST['itemCount']; // update quantity in stock

            // retrieve other information
            $internalBarcode = $row2['PRODUCT_BARCODE'];
            $countPerCase = $row2['COUNT_PER_CASE'];
            $casePrice = $row2['CASE_PRICE'];

            echo "case price = " . $casePrice;

            // update database
            $sql_command = "UPDATE CASE_TABLE SET QUANTITY_IN_STOCK='" . $quantity . "' WHERE CASE_BARCODE='" . $bcode . "';";
            $result2 = $conn->query($sql_command); // submitting query to database


            // retrieve product corresponding to internal barcode from PRODUCT table
            $sql_command = "SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='" . $internalBarcode . "'";
            $result2 = $conn->query($sql_command); // submitting query to database
            $row2 = $result2->fetch_assoc();

            $quantity = $row2['QUANTITY_IN_STOCK'];
            $quantity = $quantity + ($_POST['itemCount'] * $countPerCase); // update quantity in stock

            // update database
            $sql_command = "UPDATE PRODUCT SET QUANTITY_IN_STOCK='" . $quantity . "' WHERE PRODUCT_BARCODE='" . $internalBarcode . "';";
            $result2 = $conn->query($sql_command); // submitting query to database


            //update the current donation total price whenever you insert an item successfully
            $sql_command = "SELECT * FROM DONATION WHERE DONATION_ID='" . $_SESSION['donationID'] . "';";
            $result3 = $conn->query($sql_command); // submitting query to database
            $wholeRow = $result3->fetch_assoc();
            $totalPrice = $wholeRow['TOTAL_PRICE'];
            echo "first: " . $totalPrice . "<br>";
            $totalPrice = $totalPrice + ($_POST['itemCount'] * $casePrice);
            echo "sec: " . $totalPrice . "<br>";

            // Updating total price of the donation
            $sql_command = "UPDATE DONATION SET TOTAL_PRICE='" . $totalPrice . "' WHERE DONATION_ID='" . $_SESSION['donationID'] . "';";
            $result3 = $conn->query($sql_command); // submitting query to database


        }

    }


        if($_SESSION['onGoingPurchase']==1 && isset($_SESSION['purchaseID'])){

            echo "<br>" ."successful purchase" . "<br>";

            $purchaseID = $_SESSION['purchaseID'] ;
//    echo "donation id ".$donationID;
//    echo "<br>";

            // Inserting a new item into PURCHASED_ITEMS table in database
            $sql_command = "INSERT INTO PURCHASED_ITEMS VALUES(DEFAULT, '".$purchaseID."','".$bcode.
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
                $price = $row2['PRODUCT_PRICE'];

                // update database with new quantity
                $sql_command="UPDATE PRODUCT SET QUANTITY_IN_STOCK='".$quantity."' WHERE PRODUCT_BARCODE='".$bcode."';";
                $result2 = $conn->query($sql_command); // submitting query to database



                //update the current purchase total price whenever you insert an item successfully
                $sql_command = "SELECT * FROM PURCHASE WHERE PURCHASE_ID='".$_SESSION['purchaseID']."';";
                $result3 = $conn->query($sql_command); // submitting query to database
                $wholeRow = $result3->fetch_assoc() ;
                $totalPrice = $wholeRow['TOTAL_PRICE'];
                echo "first: ".$totalPrice."<br>";
                $totalPrice = $totalPrice+ ($_POST['itemCount']* $price);
                echo "second: ".$totalPrice."<br>";

                // Updating total price of the purchase
                $sql_command="UPDATE PURCHASE SET TOTAL_PRICE='".$totalPrice."' WHERE PURCHASE_ID='".$_SESSION['purchaseID']."';";
                $result3 = $conn->query($sql_command); // submitting query to database


            }else if($row['TYPE']=='c'){

                // get case barcode from CASE_TABLE
                $sql_command = "SELECT * FROM CASE_TABLE WHERE CASE_BARCODE='" . $bcode . "'";
                $result2 = $conn->query($sql_command); // submitting query to database
                $row2 = $result2->fetch_assoc();

                // retrieve case's current quantity in stock

                $quantity = $row2['QUANTITY_IN_STOCK'];
                $quantity = $quantity + $_POST['itemCount']; // update quantity in stock

                // retrieve other information
                $internalBarcode = $row2['PRODUCT_BARCODE'];
                $countPerCase = $row2['COUNT_PER_CASE'];
                $casePrice = $row2['CASE_PRICE'];

                echo "case price = " . $casePrice;

                // update database
                $sql_command = "UPDATE CASE_TABLE SET QUANTITY_IN_STOCK='" . $quantity . "' WHERE CASE_BARCODE='" . $bcode . "';";
                $result2 = $conn->query($sql_command); // submitting query to database


                // retrieve product corresponding to internal barcode from PRODUCT table
                $sql_command = "SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='" . $internalBarcode . "'";
                $result2 = $conn->query($sql_command); // submitting query to database
                $row2 = $result2->fetch_assoc();

                $quantity = $row2['QUANTITY_IN_STOCK'];
                $quantity = $quantity + ($_POST['itemCount'] * $countPerCase); // update quantity in stock

                // update database
                $sql_command = "UPDATE PRODUCT SET QUANTITY_IN_STOCK='" . $quantity . "' WHERE PRODUCT_BARCODE='" . $internalBarcode . "';";
                $result2 = $conn->query($sql_command); // submitting query to database


                //update the current purchase total price whenever you insert an item successfully
                $sql_command = "SELECT * FROM PURCHASE WHERE PURCHASE_ID='" . $_SESSION['purchaseID'] . "';";
                $result3 = $conn->query($sql_command); // submitting query to database
                $wholeRow = $result3->fetch_assoc();
                $totalPrice = $wholeRow['TOTAL_PRICE'];
                echo "first: " . $totalPrice . "<br>";
                $totalPrice = $totalPrice + ($_POST['itemCount'] * $casePrice);
                echo "sec: " . $totalPrice . "<br>";

                // Updating total price of the purchase
                $sql_command = "UPDATE PURCHASE SET TOTAL_PRICE='" . $totalPrice . "' WHERE PURCHASE_ID='" . $_SESSION['purchaseID'] . "';";
                $result3 = $conn->query($sql_command); // submitting query to database

            }
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

    <?php

    if($_SESSION['onGoingDonation']==1 && isset($_SESSION['donationID'])){

        ?>


        <ul id="optionsList">
            <li>
                <form action="barcode.php">
                    <input type="submit" class="optionList" value="Insert Item for This Donation" style="margin-top: 5%;">
                </form>

        </ul>


        <?php


    }else if($_SESSION['onGoingPurchase']==1 && isset($_SESSION['purchaseID'])){

        ?>


        <ul id="optionsList">
            <li>
                <form action="barcode.php">
                    <input type="submit" class="optionList" value="Insert Item for This Purchase" style="margin-top: 5%;">
                </form>

        </ul>


        <?php
    }
    ?>



    </body>
    </html>

    <?php

    $conn->close();
}
?>


