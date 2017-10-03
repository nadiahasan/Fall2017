<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/18/17
 * Time: 10:36 AM
 * Description: This file adds a new donation information into the database
 */

session_start(); // start session

//if(!isset($_SESSION['onGoingDonation'])){
//    header('Location: main2.php');
//}

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

    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";
    $result = $conn->query($sql_command); // submitting query to database


// If there is at least one user with the same username or email, display an error message

    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

    $addressCounter=0; // a counter to save the number of existing identical addresses in database

    // Checking if the submitted address already exists in database
    $sql_command = "SELECT * FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] . "';";
    $result = $conn->query($sql_command); // submitting query to database

    // If address does not exist, add it, and fetch the auto address id
    if ($result->num_rows == 0) {
        echo "success1";

        $sql_command = "INSERT INTO ADDRESS VALUES(DEFAULT,'" . $_POST['addLine1'] . "','"
            . $_POST['addLine2'] . "','" . $_POST['zipcode'] . "','" . $_POST['county'] . "','"
            . $_POST['state'] . "');";

        $result2 = $conn->query($sql_command); // submitting query to database

        $sql_command = "SELECT ADDRESS_ID FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] .
            "'AND ADDRESS_LINE2='".$_POST['addLine2']."'AND ZIPCODE='".$_POST['zipcode']."'AND 
            COUNTY='".$_POST['county']."'AND STATE='".$_POST['state']."';";
        $result2 = $conn->query($sql_command); // submitting query to database


    }else {// If part or all of address does exist
        echo "I am here";

        // Check if there is an identical address in the database
        while ($row = mysqli_fetch_assoc($result)) {

            if (($row['ADDRESS_LINE1'] === $_POST['addLine1']) && ($row['ADDRESS_LINE2'] === $_POST['addLine2']) &&
                ($row['ZIPCODE'] === $_POST['zipcode']) && ($row['COUNTY'] === $_POST['county']) &&
                ($row['STATE'] === $_POST['state'])) {
                echo "I am here2";
                $addressCounter=$addressCounter+1; // increment identical address counter

            }

        }
    }

    echo "<br>";
    echo"counter is ". $addressCounter;
    echo "<br>";

    if($addressCounter == 0){ // if an identical address doesn't exist, add it to database

        $sql_command = "INSERT INTO ADDRESS VALUES(DEFAULT,'" . $_POST['addLine1'] . "','"
        . $_POST['addLine2'] . "','" . $_POST['zipcode'] . "','" . $_POST['county'] . "','"
        . $_POST['state'] . "');";

        $result2 = $conn->query($sql_command); // submitting query to database

        $sql_command = "SELECT ADDRESS_ID FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] .
        "' AND ADDRESS_LINE2='" . $_POST['addLine2'] . "' AND ZIPCODE='" . $_POST['zipcode'] .
        "'AND COUNTY='" . $_POST['county'] . "'AND STATE='" . $_POST['state'] . "';";
        $result2 = $conn->query($sql_command); // submitting query to database

    }else if($addressCounter == 1){ // if there is one identical address, retrieve its id
        $sql_command = "SELECT ADDRESS_ID FROM ADDRESS WHERE ADDRESS_LINE1='" . $_POST['addLine1'] .
            "'AND ADDRESS_LINE2='".$_POST['addLine2']."'AND ZIPCODE='".$_POST['zipcode']."'AND 
            COUNTY='".$_POST['county']."'AND STATE='".$_POST['state']."';";
        $result2 = $conn->query($sql_command); // submitting query to database
    }

    echo "<br>";
    echo "<br>";
    $row = $result2->fetch_assoc();
    $addID = $row['ADDRESS_ID'];
    echo "<br>";
    echo $addID;
    echo "<br>";

    // Insert donation info in database
    $sql_command = "INSERT INTO DONATION VALUES(DEFAULT,'" . $_POST['accountNum'] . "','"
        . $_POST['donorName'] . "'," . $addID . ",'" . $_POST['donationDate'] . "','" . $_POST['empID'] . "',0.0,'"
        . $_POST['notes'] . "');";

    $result = $conn->query($sql_command); // submitting query to database

    //echo $sql_command;


    // Retrieve the assigned donation Id from database
    // ASSUMPTION: NO TWO IDENTICAL DONATIONS ARE MADE ON SAME DATE
    $sql_command = "SELECT DONATION_ID FROM DONATION WHERE ACCOUNT_NUM='" . $_POST['accountNum'] .
        "' AND DONOR_NAME='" . $_POST['donorName'] . "' AND DONATION_DATE='" . $_POST['donationDate'] .
        "'AND EMPLOYEE_ID='" . $_POST['empID'] . "' ORDER BY DONATION_ID DESC;";


    $result = $conn->query($sql_command); // submitting query to database

    $row= $result->fetch_assoc();
    $donationID = $row['DONATION_ID'];
    echo $donationID;

    $_SESSION['donationID']= $donationID;

    echo "<br>";

    $onGoingDonation = $_SESSION['onGoingDonation'];


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


    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>


    <ul id="optionsList">

        <li>
            <form action="barcode.php">
                <input type="submit" class="optionList" value="Insert Items for This Donation"
                       style="margin-top: 5%;">
            </form>

        </li>

        <li>
            <form action="addDonations.php">
                <input type="submit" class="optionList" value="Insert Another Donation Sheet Info"
                       style="margin-top: 5%;">
            </form>


        </li>

        <li>
            <form action="addNewType.php">
                <input type="submit" class="optionList" value="Insert a New Container/Product Type"
                       style="margin-top: 5%;">
            </form>



        </li>

    </ul>

    </body>
    </html>

    <?php
}
?>