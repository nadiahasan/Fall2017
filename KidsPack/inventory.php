<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 8:32 PM
 *  Description: This file displays inventory list options.
 */

session_start();
echo $_SESSION['username'];
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

    $result = $conn->query($sql_command); // submitting query to database


    include "topMenu.php";
// Creating an sql query based on login information provided by user
    $sql_command = "select TYPE from USERS where USERNAME='" . $_SESSION["username"] . "';";
    $result = $conn->query($sql_command);

    $row = $result->fetch_assoc();


    if ($row['TYPE'] == 1) {
        include "adminMenu.php";
    }

    unset($_SESSION['onGoingDonation']);
    unset($_SESSION['donationID']);
    unset($_SESSION['onGoingPurchase']);
    unset($_SESSION['purchaseID']);
    unset($_SESSION['onGoingDonation']);
    unset($_SESSION['barcode']);
    unset($_SESSION['templateID']);

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

            .inventoryList {
                margin-bottom: 2%;
                margin-top: 2%;
                font-size: larger;
                background-color: lightcoral;

            }
        </style>


    </head>
    <body>


    <p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Inventory Management</p>
    <ul id="functionsList">


        <form action="addDonations.php">
            <input type="submit" class="inventoryList" value="Insert Donations" style="margin-top: 5%;">
        </form>

        <form action="addPurchases.php">
            <input type="submit" class="inventoryList" value="Insert Purchases" style="margin-top: 5%;">
        </form>

        <form action="addNewType.php">
            <input type="submit" class="inventoryList" value="Add New Type" style="margin-top: 5%;">
        </form>


        <form action="foodDonationSummary.php">
            <input type="submit" class="inventoryList" value="Prepare Food Donation Summary" style="margin-top: 5%;">
        </form>

        <form action="previousDonations.php">
            <input type="submit" class="inventoryList" value="Prepare List of Previous Donations"
                   style="margin-top: 5%;">
        </form>

        <form action="inStock.php">
            <input type="submit" class="inventoryList" value="View Items in Stock" style="margin-top: 5%;">
        </form>

        <form action="outOfStock.php">
            <input type="submit" class="inventoryList" value="View Items Out of Stock" style="margin-top: 5%;">
        </form>

        <form action="removeType.php">
            <input type="submit" class="inventoryList" value="Remove Items" style="margin-top: 5%;">
        </form>


        <form action="updateProductInfo.php">
            <input type="submit" class="inventoryList" value="Update Product Info" style="margin-top: 5%;">
        </form>

        <form action="updateCaseInfo.php">
            <input type="submit" class="inventoryList" value="Update Case Info" style="margin-top: 5%;">
        </form>

        <form action="manageContainerTypes.php">
            <input type="submit" class="inventoryList" value="Manage Container Types" style="margin-top: 5%;">
        </form>

        <br>
        <form action="insertPackingSiteAddress.php">
            <input type="submit" class="inventoryList" value="Insert Packing Site Address" style="margin-top: 5%;">
        </form>
        <br>
        <form action="updateAddress.php.php">
            <input type="submit" class="inventoryList" value="Update Address" style="margin-top: 5%;">
        </form>
        <br>
        <form action="pullSheetChoice.php">
            <input type="submit" class="inventoryList" value="Prepare Pull Sheets" style="margin-top: 5%;">
        </form>
        <br>

        <form action="pullSheetTemplate.php">
            <input type="submit" class="inventoryList" value="Prepare Pull Sheet Template" style="margin-top: 5%;">
        </form>
        <br>
        <li>
            <button class="inventoryList">Prepare List of Previous Pull Sheets</button>
        </li>
        <br>

        <li>
            <button class="inventoryList">View Reports</button>
        </li>
        <br>
        <li>
            <button class="inventoryList" style="margin-bottom: 5%;">Inventory Backup</button>
        </li>
        <br>

    </ul>


    </body>

    </html>

    <?php
    $conn->close();
}
?>
