<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/31/17
 * Time: 11:21 AM
 */

//session_start(); // start session
//
//$servername = "localhost";
//$username = "root";
//$password = "root";
//$dbname = "INVENTORY";
//
//// Create a connection to mysql server
//$conn = new mysqli($servername, $username, $password,$dbname);
//
//// Check if connection is not successful
//if ($conn->connect_error) {
//    die("Connection to serverfailed: " . $conn->connect_error);
//}
//
//$sql_command="select * from USERS where USERNAME='".$_SESSION['username']."';";
//$result = $conn->query($sql_command); // submitting query to database
//
//
//// If there is at least one user with the same username or email, display an error message
//
//if($result->num_rows ==0){
//    die("Unauthorized Access");
//
//}

//$sql_command= "select ITEM_QUANTITY_IN_STOCK from ITEMS where ITEM_BARCODE='" . $_POST['barcode'] . "';";
//
//
//$result = $conn->query($sql_command); // submitting query to database
//if(mysqli_num_rows($result) !== 0){
//    $row = $result->fetch_assoc();
//    $quantityInStock = $row['ITEM_QUANTITY_IN_STOCK'];
//    $quantityInStock = $quantityInStock+$_POST['countPerContainer'];
//    $sql_command = "UPDATE ITEMS SET ITEM_QUANTITY_IN_STOCK = ".$quantityInStock.
//        " WHERE ITEM_BARCODE = " .$_POST['barcode'].";";
//    $result=$conn->query($sql_command); // submitting query to database
//    echo $sql_command;
//}else{
//    $quantityInStock = $_POST['countPerContainer'];
//    // Checking if a minimum amount is entered by user
//    if($_POST['itemMin'] == 0){
//        $minStock = 3000;
//    }else{
//        $minStock = $_POST['itemMin'];
//    }

// Inserting data into CONTAINER table, if user chooses to add a new container
//
//    $sql_command= "INSERT INTO CONTAINER VALUES('DEFAULT','".$_POST['newType']."');";
//
//// Submitting the query only if user wants to add a new container type
//    if($_POST['itemPackageType']==4){
//        $result=$conn->query($sql_command); // submitting query to database
//
//    }

//
//
//// Inserting data into ITEMS_CONTAINER table
//    $sql_command= "INSERT INTO ITEMS_CONTAINER VALUES('".$_POST['barcode'].
//        "','".$_POST['itemPackageType']."','".$_POST['countPerContainer']."');";
//    $result=$conn->query($sql_command); // submitting query to database
//
//
//
//    $sql_command="INSERT INTO ITEMS VALUES('".$_POST['barcode']."','".$_POST['itemName'].
//        "','".$_POST['itemPrice']. "','".$quantityInStock."','".$minStock."','".$_POST['purchasedOrDonated'].
//        "','".$_POST['expDate']."','".$_POST['itemDesc']."');";
//    $result = $conn->query($sql_command); // submitting query to database
//
//
//    echo $sql_command;

//}


session_start();
//echo $_SESSION['username'];



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

// Checking the session variables
$sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";

$result1 = $conn->query($sql_command); // submitting query to database

if ($result1->num_rows !== 0) {
include "topMenu.php";
}

$donationID = $_SESSION['donationID'] ;
echo $donationID;




?>






<html>
<head>

</head>

<body>
<br/>
<div>
    <?php

    include "adminMenu.php";
    ?>
    <br/>

    <?php

    include "topMenu.php";
    ?>
</div>


<h3>Item Added successfully.</h3>
<p>Add a new Item <a href="addNewType.php">here</a>.</p>
</body>
</html>

<?php
    $conn->close();
    }
?>



