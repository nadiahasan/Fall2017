<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 9:50 AM
 * * Description: This file asks prepares the desired food donation summary based on
 *                user input in foodDonationSummary.php
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

    <h2>Food Donation Summary
        <?php

        // Getting the month name based on the entered number
        if($_POST['month']!=''){
            $monthNum=$_POST['month'];
            $dateObject = DateTime::createFromFormat('!m',$monthNum);
            $monthName = $dateObject->format('F');

            echo $monthName." ".$_POST['year'];
        }else{
            echo $_POST['year'];
        }

        ?></h2>

    </body>
    </html>

    <?php

    // If the user decided to prepare a list of donations for a given year
    if($_POST['month']==''){


        $sql_command = "SELECT * FROM DONATION WHERE ACCOUNT_NUM='".$_POST['accountNum']."'AND  (SELECT YEAR(DONATION_DATE))=".$_POST['year'].";";

    }else { // a list for a given month and year
        $sql_command = "SELECT * FROM DONATION WHERE ACCOUNT_NUM='".$_POST['accountNum']."' AND (SELECT MONTH(DONATION_DATE))=".$_POST['month']."
        AND  (SELECT YEAR(DONATION_DATE))=".$_POST['year'].";";


    }



    $result = $conn->query($sql_command); // submitting query to database
    //echo $sql_command;

    echo "<table>";
    echo "<tr>";

    echo "<th>"."Type"."</th>";

    echo "<th>"."Date"."</th>";
    echo "<th>"."Donor Name"."</th>";
    echo "<th>"."Address"."</th>";
    echo "<th>"."Amount"."</th>";

    echo "</tr>";

    $totalPrice =0; // total price for all donations in the requested month
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
       // printing the rows
        echo "<td>". $row['ACCOUNT_NUM']."</td>"."<td>".$row['DONATION_DATE']."</td>"."<td>".$row['DONOR_NAME']. "</td>". "<td>".$row2['ADDRESS_LINE1']
        ." ".$row2['ADDRESS_LINE2']." ".$row2['STATE']." ".$row2['ZIPCODE']."</td>"."<td>$". $row['TOTAL_PRICE']."</td>";


        $totalPrice = $totalPrice+$row['TOTAL_PRICE'];
        //echo "<br>";

        echo "</tr>";
    }


    echo "</table>";
    echo "<br>";
    echo "<strong>"."Total Price for All Donations: $" .$totalPrice."</strong>";

    $conn->close();



}
?>