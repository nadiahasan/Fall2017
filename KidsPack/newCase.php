<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/19/17
 * Time: 11:58 AM
 * Description: This file inserts the information associated with a new container/bulk
 *              item in the database. Each bulk item is identified by its barcode.
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

// Transferring previous session info, case barcode, to this page.
$barcode=$_SESSION['barcode'];
$_SESSION['barcode'] = $barcode;


// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
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



<p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Case Type</p>
<div id="outerDiv">

    <form method="post" id="newCaseForm" action="newCaseConfirmation.php" style="margin-left: 3%;">

        <label style="">Case Name: </label>
        <input name="caseName" required style="">
        <br>
        <label style="">Internal Product Barcode: </label>
        <input name="internalBarcode" required style="">
        <br>
        <label style="">Internal product packaging type: </label>
        <select name="containerType" id="myChoice">
            <!-- Retrieving container types from database -->
            <?php

            $sql_command ="select * from CONTAINER_TYPE;";
            $result = $conn->query($sql_command); // submitting query to database

            $numRows = mysqli_num_rows($result);

            $v =0;

            while($row=mysqli_fetch_assoc($result)){
                echo '<option value="'.$row['CONTAINER_TYPE_ID'].'">'.$row['CONTAINER_TYPE'].'</option>';
                $v=(int)$row['CONTAINER_TYPE_ID'] ;
            }
            //echo '<option value="'.($v+1).'">other</option>';

            ?>
        </select>
        <a href = manageContainerTypes.php>Add new pacakge types</a>
        <br>
        <br>
        <label style="">Count per case: </label>
        <input name="countPerCase" required style="" placeholder="1">
        <br>

        <!-- Initial quantity in stock for a new case is 0-->
        <label style="">Case Price: </label>
        <input name="casePrice" required style="">
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
