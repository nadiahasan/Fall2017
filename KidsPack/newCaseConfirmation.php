<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/20/17
 * Time: 9:22 AM
 */
// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];


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

// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

// Transferring previous session info, case barcode, to this page.
$barcode=$_SESSION['barcode'];
//$_SESSION['barcode'] = $barcode;
//echo $barcode;


// Inserting new CASE information into database
$sql_command = "INSERT INTO CASE_TABLE VALUES('".$barcode."','"
    .$_POST['internalBarcode']."','".$_POST['caseName']."'   ,'".$_POST['containerType']."','".$_POST['countPerCase'].
    "','DEFAULT','".$_POST['casePrice']."');";
$result = $conn->query($sql_command); // submitting query to database
//echo $sql_command;



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
<h3>New Case Successfully Added.</h3>

<ul id="optionsList">



    <?php
    // Asking for internal product information
    $sql_command="select * from PRODUCT where PRODUCT_BARCODE='".$_POST["internalBarcode"]."';";
    $result = $conn->query($sql_command);


    if($result->num_rows == 0){// in case the product is new/(barcode does not exist in database)
        $_SESSION['barcode'] = $_POST['internalBarcode'];
        ?>

    <form action="newProduct.php">
        <input type="submit" class="optionList" value="Insert Internal Product Info" style="margin-top: 5%;">
        </form>


        <?php

    }else{

        // Showing options to insert items
        if($_SESSION['onGoingDonation']==1 && isset($_SESSION['donationID'])){
            ?>
    <ul id="optionsList">

            <form action="barcode.php">
                <input type="submit" class="optionList" value="Insert Items for This Donation" style="margin-top: 5%;">
            </form>
    </ul>

            <?php
        }else if($_SESSION['onGoingPurchase']==1 && isset($_SESSION['purchaseID'])){
                ?>
            <ul id="optionsList">

                <form action="barcode.php">
                    <input type="submit" class="optionList" value="Insert Items for This Purchase" style="margin-top: 5%;">
                </form>
            </ul>

            <?php
        }

    }

    ?>


</body>
</html>
<?php
    $conn->close();
    }
    ?>