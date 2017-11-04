<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 11:18 AM
 * Description: This file prepares a list of the previous donations sessions so that
 *              an employee can continue inserting new items for a particular donation
 */

session_start(); // start session



if (!isset($_SESSION['username'])) {// checking if user is allowed to access this page
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
    $row=$result->fetch_assoc();

    if($row['TYPE']==1){

        include "adminMenu.php";
    }



// If there is at least one user with the same username or email, display an error message

    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
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
            .option{
                margin-bottom: 2%;
                margin-top: 2%;
                font-size: larger;
                background-color: lightcoral;
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

    <h2>Recent Donations List</h2>

    </body>
    </html>

    <?php


    $sql_command = "SELECT * FROM DONATION WHERE (SELECT MONTH(DONATION_DATE))= (SELECT MONTH(NOW())) AND 
    (SELECT YEAR(DONATION_DATE))= (SELECT YEAR(NOW()))";
    $result = $conn->query($sql_command); // submitting query to database


//    echo $sql_command;
//
//    echo "<br>";
//    $row = $result->fetch_assoc();
//    print_r($row);

    //echo "<br>";
    //echo "num rows: ".$result->num_rows;
    //echo "<br>";
    echo "<table>";
    echo "<tr>";

    echo "<th>"."Donation ID"."</th>";

    echo "<th>"."Account Number"."</th>";
    echo "<th>"."Donor Name"."</th>";
    echo "<th>"."Address"."</th>";
    echo "<th>"."Donation Date"."</th>";
    echo "<th>"."Employee ID"."</th>";
    echo "<th>"."Total Price"."</th>";
    echo "<th>"."Notes"."</th>";

    echo "<th>"."       "."</th>";

    echo "</tr>";

//    $totalPrice =0; // total price for all donations in the requested month
    while ($row = mysqli_fetch_assoc($result)) {

        $sql_command2 = "SELECT * FROM ADDRESS WHERE ADDRESS_ID='".$row['DONOR_ADDRESS_ID']."'";
        $result2 = $conn->query($sql_command2); // submitting query to database
        $row2 = $result2->fetch_assoc();

        //print_r($row2);
        //echo $result2->num_rows;
        echo "<br>";
//        echo "<br>";
//        echo "<br>";

        echo "<tr>";
        echo "<td>". $row['DONATION_ID']."</td>"."<td>".$row['ACCOUNT_NUM']."</td>"."<td>".$row['DONOR_NAME']. "</td>". "<td>".$row2['ADDRESS_LINE1']
            ." ".$row2['ADDRESS_LINE2']." ".$row2['STATE']." ".$row2['ZIPCODE']."</td>"."<td>". $row['DONATION_DATE']."</td>". "<td>".$row['EMPLOYEE_ID'].
            "</td>". "<td>$".$row['TOTAL_PRICE']."</td>". "<td>".$row['NOTES']."</td>";


        // How to set the onGoingDonation and donationID based on user clicking

        $_SESSION['onGoingDonation']=1;
        $_SESSION['donationID']=$row['DONATION_ID'];


        echo "<td>" ."<form method='post' action='barcode.php' class='option'>
        <input type='submit' value='continue'>
        </form>";


        //echo "<br>";

        echo "</tr>";
    }


    echo "</table>";
    echo "<br>";



    $conn->close();
}
?>