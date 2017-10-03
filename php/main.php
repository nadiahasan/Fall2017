<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/15/17
 * Time: 8:48 PM
 */

// Connecting php to mysql server
session_start();

// destroying any previous opened session
session_unset();
session_destroy();



// Initializing some variables for connection to database server
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "INVENTORY";

// Create a connection to mysql server
$conn = new mysqli($servername, $username, $password,$dbname);

// Check if connection is not successful
if ($conn->connect_error) {
    die("Connection to serverfailed: " . $conn->connect_error);
}


// Creating an sql query based on login information provided by user
$sql_command="select PASSWORD from USERS where USERNAME='".$_POST["username"]."';";
$result = $conn->query($sql_command);


$row=$result->fetch_assoc();


// adding a security level to the password by using password hashing
if (password_verify($_POST['password'],$row['PASSWORD'])){

    session_start();
    $_SESSION['username']=$_POST['username'];


}else{

        echo
        "invalid";
}
?>

<html>
<head>
    <style>


        #signupDiv{
            border: solid;
            border-color: black;
            margin: 5%;
            padding: 1%;
            width: 25%;
            float:left;
            height: 40%;

        }
        #loginDiv{
            border: solid;
            border-color: black;
            margin-top: 5%;
            padding: 1%;
            width: 25%;
            height: 40%;
            overflow: auto;
        }


    </style>

</head>

<body>


<?php


include "topMenu.php";
// Creating an sql query based on login information provided by user
$sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
$result = $conn->query($sql_command);

$row=$result->fetch_assoc();


if($row['TYPE']==1){
    include "adminMenu.php";
}
?>

<div id="outerDiv" style="float: none; overflow: auto; width: 100%;">

<div id="signupDiv">
    <p style="margin-left: 25%; margin-top: 10%;">Create a New Account</p>
    <br/>
    <form action="signup.php">
        <input type="submit" value="Sign up Here" style="margin-left: 15%; width: 75%;">
    </form>

</div>
<div id="loginDiv">

    <p style="text-align: center;">An Existing User?
        <br/>
        <br/>
        Log in to Your Account
    </p>



    <br/>
    <br>


    <form method="post" action="main.php">
        <label style="margin-left:5%;">Username: </label>
        <input name="username" required>
        <br>
        <br>
        <label style="margin-left:6%;">Password: </label>
        <input type="password" name="password" required>
        <br>
        <br>
        <input type="submit" name="submitButton" style="width: 40%; margin-left:30%; margin-right: 30%;"/>
    </form>


</div>

</div>

</body>



</html>



