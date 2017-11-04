<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/23/17
 * Time: 11:05 AM
 * Description: This files performs inserting data into the database.
 */
session_start(); // start session

echo $_SESSION['templateID'];

if(!isset($_SESSION['templateID'])){
    header('Location: main2.php');
}

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
    $row = $result->fetch_assoc();
    if ($row['TYPE'] == 1) {

        include "adminMenu.php";
    }


// If there is at least one user with the same username or email, display an error message
    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

    $conn->close();

// Create a connection to mysql server
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is not successful
    if ($conn->connect_error) {
        die("Connection to serverfailed: " . $conn->connect_error);
    }

    print_r($_POST);
    $length = count($_POST);
    $numberOfItems = $length / 4;
    echo count($_POST);
    echo "<br>";
    $count = 0;

    $barcode = 0;
    $amountPerPack = 0;
    $productName = "";
    $flag = false;
    foreach ($_POST as $value) {
        if (($count % 4) == 0) {
            $productName = $value;
            echo $productName;
            echo "<br>";

        }
        if (($count % 4) == 2) {
            $barcode = $value;
            echo $barcode;
            echo "<br>";


        }

        if (($count % 4) == 3) {
            $amountPerPack = $value;
            echo $amountPerPack;
            echo "<br>";
            $flag = true;
        }
        $count++;
        if ($flag) {
            $sql_command = "INSERT INTO PULL_SHEETS_ITEMS VALUES(DEFAULT,'" . $_SESSION['templateID'] . "',
         '" . $barcode . "','" . $amountPerPack . "');";
            $result = $conn->query($sql_command);
        }

        $flag = false;

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
                background-color: antiquewhite;

            }

            #functionsList {
                border: solid;
                background-color: antiquewhite;
                padding-right: 7%;
                padding-left: 10%;
                float: left;
                margin-left: 25%;

            }

            body {
                background-color: ghostwhite;
            }

            #outerDiv {
                background-color: #E7EBEE;
                width: 90%;
                border-top: solid;
                border-bottom: solid;
                margin-left: 5%;
                margin-right: 5%;
                padding-top: 2%;
                text-align: center;


            }

            #outerDiv input {
                width: 30%;
                height: 5%;
                background-color: coral;
                font-weight: bold;
                font-size: 20px;
            }

        </style>


    </head>
    <body>

    <div id="outerDiv">



        <form action="pullSheets.php">
            <input type="submit" value="Prepare Pull Sheet" style="margin-top: 5%;">
        </form>

        <form action="inventory.php">
            <input type="submit" value="Go To Inventory" style="margin-top: 5%;">

        </form>

    </div>
    </body>

    </html>


<!--    //<label style="">Pull Date: </label>-->
<!--    //            <input name="pullDate" type="date" required style="">-->
<!--    //            <br>-->


<!--    // Create an input field fo collect employee initials-->
<!--    //            var inputField2 = document.getElementById("d1-" + numRows);-->
<!--    //            var initials = document.createElement("input");-->
<!--    //            initials.setAttribute("name", "d1_" + numRows);-->
<!--    //            initials.required=true;-->
<!--    //            initials.style.width = "200px";-->
<!--    //            initials.style.height = "32px";-->
<!--    //            initials.padding = "5px 10px";-->
<!--    //            initials.style.marginLeft = "60px";-->
<!--    //            initials.style.marginRight = "60px";-->
<!--    //            //initials.addEventListener("onclick", checkInitials(numRows));-->
<!--    //            inputField2.appendChild(initials);-->

    <?php
}
?>