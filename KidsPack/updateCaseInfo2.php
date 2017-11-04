<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/11/17
 * Time: 9:53 AM
 * Description: This file checks if the user entered a valid barcode. If not, s/he is
 *              sent back to enter another one.
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

            .option {
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


    <?php

    $sql_command = "SELECT * FROM CASE_TABLE WHERE CASE_BARCODE='" . $_POST['cbarcode'] . "';";
    $result = $conn->query($sql_command); // submitting query to database

    if ($result->num_rows == 0) { // if case barcode to be updated does not exist in
        // database
        ?>

        <h2>Barcode does not exist.</h2>
        <br>
        <form action="updateCaseInfo.php" method="post">
            <input type="submit" value="Enter Barcode">
        </form>

        <?php
    } else {

        // Save the original barcode for the case to be updated
        $_SESSION['conBarcodeUpdate'] = $_POST['cbarcode'];

        // Fetch the row from the database
        $row = $result->fetch_assoc();

        ?>

        <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
        <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Update Product Info:</p>

        <div id="outerDiv">

            <!--            An edit button-->
            <button type="button" id="editButton" style="float:  none; margin-left: 70%; width: 20%; height: 5%;"
                    onclick="f();">Edit
            </button>

            <form action="updateCaseConfirmation.php" method="post" style="" id="conUpdateForm">

                <label style="">Case Barcode: </label>
                <input id="barcodeID" name="caseBarcode" style="" value="<?php
                echo $row['CASE_BARCODE']; ?>" disabled>
                <br>


                <label style="">Internal product packaging type: </label>
                <select name="containerType" id="packageTypeID" disabled>
                    <!-- Retrieving container types from database -->
                    <?php

                    $sql_command2 ="select * from CONTAINER_TYPE;";
                    $result2 = $conn->query($sql_command2); // submitting query to database

                    $numRows = mysqli_num_rows($result2);

                    $v =0;

                    while($row2=mysqli_fetch_assoc($result2)){
                        echo '<option value="'.$row2['CONTAINER_TYPE_ID'].'">'.$row2['CONTAINER_TYPE'].'</option>';
                        $v=(int)$row2['CONTAINER_TYPE_ID'] ;
                    }
                    //echo '<option value="'.($v+1).'">other</option>';

                    ?>
                </select>
                <br>
                <br>


                <label style="">Case Price: </label>
                <input id="casePriceID" name="casePrice" style="" value="<?php
                echo $row['CASE_PRICE']; ?>" disabled>
                <br>

                <label style="">Count per case: </label>
                <input id="countID" name="count" style="" value="<?php
                echo $row['COUNT_PER_CASE']; ?>" disabled>
                <br>


                <label style="">Would you like to modify internal product info: </label>
                <ul>
                        <input type="radio" name="modifyInternal" value="y" id="modifyID" required disabled>Yes<br>

                        <input type="radio" name="modifyInternal" value="n" id="notModifyID" required disabled>No<br>


                </ul>


            <br>
            <br>
            </form>

        </div>

        <script type="text/javascript">
            var counter = 0; // a flag to prevent adding multiple submit buttons

            //                    This function retrieves all the input fields in the form and
            //                    removes the "disabled" attribute, so that a user can edit
            //                    these fields. It also adds a submit button to the form
            function f() {
                var bcode = document.getElementById("barcodeID");
                bcode.removeAttribute("disabled");

                var prodName = document.getElementById("packageTypeID");
                prodName.removeAttribute("disabled");

                var prodPrice = document.getElementById("casePriceID");
                prodPrice.removeAttribute("disabled");

                var min = document.getElementById("countID");
                min.removeAttribute("disabled");

                var desc = document.getElementById("modifyID");
                desc.removeAttribute("disabled");

                var desc = document.getElementById("notModifyID");
                desc.removeAttribute("disabled");


                if (counter == 0) {
                    // Adding submit button
                    var form = document.getElementById("conUpdateForm");
                    var element = document.createElement("input");
                    element.setAttribute("type", "submit");
                    element.setAttribute("value", "submit");
                    form.appendChild(element);
                    counter = 1;
                }


            }

        </script>

        <?php
    }
    ?>


    </body>
    </html>


    <?php
    $conn->close();
}
?>

