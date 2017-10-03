<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/20/17
 * Time: 9:54 AM
 */

// Connecting php to mysql server
session_start();
//echo $_SESSION['username'];

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
//echo $barcode;


    // Inserting data into "Product" table
$min = 0;
  if($_POST['itemMin']==''){

      $sql_command = "INSERT INTO PRODUCT VALUES('".$barcode."','"
          .$_POST['productName']."','".$_POST['productPrice']. "',DEFAULT,DEFAULT,'"
          .$_POST['prodDescription']."');";
      echo $sql_command."<br>";
      $result = $conn->query($sql_command); // submitting query to database



  }else{

      $sql_command = "INSERT INTO PRODUCT VALUES('".$barcode."','"
          .$_POST['productName']."','".$_POST['productPrice']. "',DEFAULT,'".$_POST['itemMin']."','"
          .$_POST['prodDescription']."');";
      echo $sql_command."<br>";
      $result = $conn->query($sql_command); // submitting query to database



  }



// Creating an sql query based on login information provided by user
$sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
$result = $conn->query($sql_command);

$row=$result->fetch_assoc();


if($row['TYPE']==1){
    include "adminMenu.php";
}


    $_SESSION['barcode'] = $barcode;

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
    <h3>New Product Successfully Added.</h3>

    <ul id="optionsList">


        <form action="inventory.php">
            <input type="submit" class="optionList" value="Inventory Management" style="margin-top: 5%;">
        </form>

        <form action="addNewType.php">
            <input type="submit" class="inventoryList" value="Insert Container/Product Type" style="margin-top: 5%;">
        </form>

        <form action="addDonations.php">
            <input type="submit" class="optionList" value="Insert Donation Information" style="margin-top: 5%;">
        </form>

        <?php
        if($_SESSION['onGoingDonation']==1 && isset($_SESSION['donationID'])){
            ?>

            <form action="barcode.php">
                <input type="submit" class="optionList" value="Insert Items for This Donation" style="margin-top: 5%;">
            </form>

            <?php
        }
        ?>

        <!--               <form action="insertItems.php">-->
            <!--            <input type="submit" class="inventoryList" value="Insert Items" style="margin-top: 5%;">-->
            <!--        </form>-->

    </body>
    </html>




    <?php
}
?>