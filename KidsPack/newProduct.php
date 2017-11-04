<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/19/17
 * Time: 11:58 AM
 * Description: A user is supposed to use this form to add a new product "TYPE", not
 *              a specific individual item. It's supposed to collect general information
 *              regarding this type. Another form is used to insert individual items and
 *              collect specific info like expiration date, which varies from one item to
 *              another.
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
    if(!isset($_SESSION['donationID'])) {
        header('Location: main2.php');
    }
}
if($_SESSION['onGoingPurchase']==1){
    if(!isset($_SESSION['purchaseID'])) {
        header('Location: main2.php');
    }
}

if(!isset($_SESSION['barcode'])) {
    header('Location: main2.php');
}
echo $_SESSION['barcode'];
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


// Transferring previous session info, case barcode, to this page.
    $barcode=$_SESSION['barcode'];


    if($_SESSION['onGoingDonation']==1){
        $onGoingDonation=$_SESSION['onGoingDonation'];
    }else if($_SESSION['onGoingPurchase']==1){
        $onGoingPurchase=$_SESSION['onGoingPurchase'];
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


    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Product Type</p>
    <div id="outerDiv">

        <form method="post" id="newProductForm" action="newProductConfirmation.php" style="margin-left: 3%;">



            <label style="">Product Name: </label>
            <input name="productName" required style="">
            <br>

            <label style="">Product Price: </label>
            <input name="productPrice" required style="">
            <br>

            <!-- Initial quantity in stock for a new case is 0-->

            <?php
            if(($_SESSION['onGoingDonation']==1) ){

                $sql_command = "SELECT * FROM DONATION WHERE DONATION_ID=
                '".$_SESSION['donationID']."';";

                $result2 = $conn->query($sql_command); // submitting query to database
                $row = $result2->fetch_assoc();
                $accountNum = $row['ACCOUNT_NUM'];
                //echo $accountNum;

                if($accountNum == 65016){

                    ?>
                    <label style="">Set minimum amount for this item in stock: </label>
                    <input name="itemMin" style="" placeholder="3000">
                    <br>
            <?php
                }

            }


            ?>

            <label style="">Product Description: </label>
            <textarea name="prodDescription" style="" rows="4" cols="50"></textarea>
            <br>


            <br>
            <br>
            <input type="submit" name="submit" style="width: 10%;">

        </form>

    </div>

    </body>
    </html>

    <?php
    $conn->close();
}
?>

