<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 1:41 PM
 * Description: This file prepares a list of the products out of stock
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

    <h2>Current Items In Stock</h2>

    </body>
    </html>

    <?php


    $sql_command = "SELECT * FROM PRODUCT WHERE QUANTITY_IN_STOCK=0";
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

    echo "<th>"."Product Barcode"."</th>";

    echo "<th>"."Product Name"."</th>";
    echo "<th>"."Product Price"."</th>";
    echo "<th>"."Quantity In Stock"."</th>";
    echo "<th>"."Product Description"."</th>";

    echo "</tr>";

    while ($row = mysqli_fetch_assoc($result)) {


        echo "<tr>";
        echo "<td>". $row['PRODUCT_BARCODE']."</td>"."<td>".$row['PRODUCT_NAME']."</td>"."<td>$".$row['PRODUCT_PRICE']. "</td>"."<td>".$row['QUANTITY_IN_STOCK'].
            "</td>". "<td>".$row['PROD_DESCRIPTION']."</td>";



        echo "</tr>";
    }


    echo "</table>";
    echo "<br>";


    $conn->close();

}
?>