<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/19/17
 * Time: 11:58 AM
 */

// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];



echo $_SESSION['onGoingDonation'];

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

// Transferring previous session info, container barcode, to this page.
$barcode=$_SESSION['barcode'];
$_SESSION['barcode'] = $barcode;


// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

    $onGoingDonation=$_SESSION['onGoingDonation'];
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



<p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Container Type</p>
<div id="outerDiv">

    <form method="post" id="newContainerForm" action="newContainerConfirmation.php" style="margin-left: 3%;">

        <label style="">Internal Product Barcode: </label>
        <input name="internalBarcode" required style="">
        <br>
        <label style="">Container Type: </label>
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
        <label style="">Count per container: </label>
        <input name="countPerContainer" required style="" placeholder="1">
        <br>

        <!-- Initial quantity in stock for a new container is 0-->
        <label style="">Container Price: </label>
        <input name="containerPrice" required style="">
        <br>




        <br>
        <br>
        <input type="submit" name="submit" style="width: 10%;">

    </form>

</div>

</body>
</html>

    <?php
    }
?>
