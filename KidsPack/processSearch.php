<?php
///**
// * Created by PhpStorm.
// * User: nadiahasan
// * Date: 10/19/17
// * Time: 8:51 AM
// */
//
//$servername = "localhost";
//$username = "root";
//$password = "root";
//$dbname = "INVENTORY";
//
//
//// Create a connection to mysql server
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// Check if connection is not successful
//if ($conn->connect_error) {
//    die("Connection to serverfailed: " . $conn->connect_error);
//}
//if(isset($_REQUEST['term'])){
//// Prepare a select statement
//    $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_NAME LIKE ?";
//
//    if($stmt = mysqli_prepare($conn, $sql)){
//// Bind variables to the prepared statement as parameters
//        mysqli_stmt_bind_param($stmt, "s", $param_term);
//
//// Set parameters
//        $param_term = $_REQUEST['term'] . '%';
//
//// Attempt to execute the prepared statement
//        if(mysqli_stmt_execute($stmt)){
//            $result = mysqli_stmt_get_result($stmt);
//
//// Check number of rows in the result set
//            if(mysqli_num_rows($result) > 0){
//// Fetch result rows as an associative array
//                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
//                    echo "<p>" . $row['PRODUCT_NAME'] . "</p>";
//                }
//            } else{
//                echo "<p>No matches found</p>";
//            }
//        } else{
//            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
//        }
//    }
//
//// Close statement
//    mysqli_stmt_close($stmt);
//}
//
//// close connection
//mysqli_close($conn);
//
//?




/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/19/17
 * Time: 8:51 AM
 */

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
if(isset($_REQUEST['term'])){
// Prepare a select statement
    $sql = "SELECT * FROM CASE_TABLE WHERE CASE_NAME LIKE ?";

    if($stmt = mysqli_prepare($conn, $sql)){
// Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

// Set parameters
        $param_term = $_REQUEST['term'] . '%';

// Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $id=0;
// Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
// Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

                    echo "<p quantity='".$row['COUNT_PER_CASE']."' pBar='".$row['CASE_BARCODE']."' id='option".$id."'>" . $row['CASE_NAME']."</p>";
                }

            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
        }
    }

// Close statement
    mysqli_stmt_close($stmt);
}

// close connection
mysqli_close($conn);

?>
