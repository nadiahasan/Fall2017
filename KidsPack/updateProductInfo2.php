<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/9/17
 * Time: 7:29 PM
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

    $sql_command = "SELECT * FROM PRODUCT WHERE PRODUCT_BARCODE='" . $_POST['barcode'] . "';";
    $result = $conn->query($sql_command); // submitting query to database

    if ($result->num_rows == 0) { // if product barcode to be updated does not exist in
                                    // database
        ?>

        <h2>Barcode does not exist.</h2>
        <br>
        <form action="updateProductInfo.php" method="post">
            <input type="submit" value="Enter Barcode">
        </form>

        <?php
    } else {

        // Save the original barcode for the product to be updated
        $_SESSION['prodBarcodeUpdate']=$_POST['barcode'];

        // Fetch the row from the database
        $row = $result->fetch_assoc();

        ?>

        <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
        <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Update Product Info:</p>

        <div id="outerDiv">

<!--            An edit button-->
            <button type="button" id="editButton" style="float:  none; margin-left: 70%; width: 20%; height: 5%;" onclick="f();">Edit</button>

            <form action="updateProductConfirmation.php" method="post" style="" id="prodUpdateForm">

                <label style="">Product Barcode: </label>
                <input id="barcodeID" name="productBarcode" style="" value="<?php
                echo $row['PRODUCT_BARCODE']; ?>" disabled>
                <br>

                <label style="">Product Name: </label>
                <input id="productNameID" name="productName" style="" value="<?php
                echo $row['PRODUCT_NAME']; ?>" disabled>
                <br>


                <label style="">Product Price: </label>
                <input id="productPriceID" name="productPrice" style="" value="<?php
                echo $row['PRODUCT_PRICE']; ?>" disabled>
                <br>

                <label style="">Minimum Quantity in Stock: </label>
                <input id="minID" name="prodMin" style="" value="<?php
                echo $row['MIN_QUANTITY_IN_STOCK']; ?>" disabled>
                <br>

                <label style="">Product Description: </label>
                <input id="descriptionID" name="prodDesc" style="" value="<?php
                echo $row['PROD_DESCRIPTION']; ?>" disabled>
                <br>



                <script type="text/javascript">
                    var counter=0; // a flag to prevent adding multiple submit buttons

//                    This function retrieves all the input fields in the form and
//                    removes the "disabled" attribute, so that a user can edit
//                    these fields. It also adds a submit button to the form
                    function f(){
                        var bcode = document.getElementById("barcodeID");
                        bcode.removeAttribute("disabled");

                        var prodName = document.getElementById("productNameID");
                        prodName.removeAttribute("disabled");

                        var prodPrice = document.getElementById("productPriceID");
                        prodPrice.removeAttribute("disabled");

                        var min = document.getElementById("minID");
                        min.removeAttribute("disabled");

                        var desc = document.getElementById("descriptionID");
                        desc.removeAttribute("disabled");


                        if(counter==0){

                            // Adding submit button
                            var form = document.getElementById("prodUpdateForm");
                            var element = document.createElement("input");
                            element.setAttribute("type","submit");
                            element.setAttribute("value","submit");
                            form.appendChild(element);
                            counter=1;
                        }


                    }

                </script>

            </form>
        </div>

        <?php
    }
    ?>


    </body>
    </html>


    <?php
    $conn->close();
}
?>

