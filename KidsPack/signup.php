<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 5:01 PM
 */

// Connecting php to mysql server
session_start();




// Initializing some variables for the connection
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


if(strcmp($_POST['username'], "") !==0){
    // Creating an sql command to search for users with the same username or email
    $sql_command="select * from USERS where USERNAME='".$_POST['username']."' or EMAIL='".$_POST['email']."';";

//echo $sql_command;

    $result = $conn->query($sql_command); // submitting query to database
// If there is at least one user with the same username or email, display an error message
    if($result->num_rows >0){

        echo "<html><body style='background-color: white;'><h1>Sign Up Error</h1></body></html>";
        echo "Username already exists. Please Try a different username and email. <br>";
        echo "<a href='signup.php'>Click here to re-enter your sign-up information</a>";

    }else if($_POST['password1']!=$_POST['password2']){
        die("Passwords Do Not Match");
    } else{

        if($_POST['submit'] == $_SESSION['submit']){
            //Otherwise, add the user to the USERS table, and hash the password
            $sql_command="insert into USERS values('".$_POST['username']."','".$_POST['firstName']."','"
                .$_POST['lastName']."','".password_hash($_POST['password1'],PASSWORD_DEFAULT)."','".$_POST['email']."',0,1,1);";

            $result = $conn->query($sql_command); // submitting query to database
            header('Location: main.php');

        }


    }

}

$conn->close();


?>
<html>
<head>
    <style>

        label{

            font-size: larger;

        }

        input{
            margin-bottom: 1%;
            background-color: antiquewhite;

        }
    </style>

</head>

<body>

<?php
include "topMenu.php";
?>


<div id="outerDiv" style="float: none; overflow: auto;
padding: 2%; width: 50%;
border: solid; border-color: crimson; margin-left: 12%;">

<form method="post" action="signup.php" class="formClass">
    <label style="">Username: </label>
    <input type="text" name="username" required style="">
    <br>
    <label style="">First Name:</label>
    <input type="text" name="firstName" required style="">
    <br>
    <label style="">Last Name:</label>
    <input type="text" name="lastName" required style="">
    <br>
    <label style="">Password: </label>
    <input type="password" name="password1" required style="">
    <br>
    <label style="">Confirm Password: </label>
    <input type="password" name="password2" required style="">
    <br>
    <label style="">Email:</label>
    <input type="email" name="email" required style="">
    <br>
    <label style="">Are you an Employee at KidsPack?</label>
    <br/>
        <input type="radio" name="employeeTest" value="yes">Yes<br/>
        <input type="radio" name="employeeTest" value="no">No<br/>


    <br>

    <input type="submit" style="margin-left:24%; margin-top: 5%;">

</form>


</div>

</body>



</html>



