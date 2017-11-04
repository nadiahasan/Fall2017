<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 9/18/17
 * Time: 9:24 AM
 * Description: This file includes the form to collect donation sheet information.
 */

// Connecting php to mysql server
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


if ($result->num_rows !== 0) {
    include "topMenu.php";
}

// Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

    //$conn->close();


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


<p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add Donation</p>
<div id="outerDiv">

    <form method="post" id="newDonationForm" action="newDonationConfirmation.php" style="margin-left: 3%;">

        <label style="">Account Number: </label>
        <input name="accountNum" required style="">
        <br>
        <label style="">Donor Name: </label>
        <input name="donorName" required style="">
        <br>
        <div id="addressDiv">


            <label style=""> Donor Address Line 1:</label>
            <input name="addLine1" required style="">
            <br>

            <label style="">Line 2:</label>
            <input name="addLine2"  style="">
            <br>

            <label style="">County:</label>
            <input name="county"  style="">
            <br>

            <label style="">City:</label>
            <input name="city"  style="">
            <br>


            <label style="">State: </label>
            <select name="state" required>
                    <option value="AL">AL</option>
                    <option value="AK">AK</option>
                    <option value="AR">AR</option>
                    <option value="AZ">AZ</option>
                    <option value="CA">CA</option>
                    <option value="CO">CO</option>
                    <option value="CT">CT</option>
                    <option value="DC">DC</option>
                    <option value="DE">DE</option>
                    <option value="FL">FL</option>
                    <option value="GA">GA</option>
                    <option value="HI">HI</option>
                    <option value="IA">IA</option>
                    <option value="ID">ID</option>
                    <option value="IL">IL</option>
                    <option value="IN">IN</option>
                    <option value="KS">KS</option>
                    <option value="KY">KY</option>
                    <option value="LA">LA</option>
                    <option value="MA">MA</option>
                    <option value="MD">MD</option>
                    <option value="ME">ME</option>
                    <option value="MI">MI</option>
                    <option value="MN">MN</option>
                    <option value="MO">MO</option>
                    <option value="MS">MS</option>
                    <option value="MT">MT</option>
                    <option value="NC">NC</option>
                    <option value="NE">NE</option>
                    <option value="NH">NH</option>
                    <option value="NJ">NJ</option>
                    <option value="NM">NM</option>
                    <option value="NV">NV</option>
                    <option value="NY">NY</option>
                    <option value="ND">ND</option>
                    <option value="OH">OH</option>
                    <option value="OK">OK</option>
                    <option value="OR">OR</option>
                    <option value="PA">PA</option>
                    <option value="RI">RI</option>
                    <option value="SC">SC</option>
                    <option value="SD">SD</option>
                    <option value="TN">TN</option>
                    <option value="TX">TX</option>
                    <option value="UT">UT</option>
                    <option value="VT">VT</option>
                    <option value="VA">VA</option>
                    <option value="WA">WA</option>
                    <option value="WI">WI</option>
                    <option value="WV">WV</option>
                    <option value="WY">WY</option>
            </select>


            <label style="">Zipcode:</label>
            <input name="zipcode" required style="">
            <br>

        </div>
        <br>
        <br>

        <label style="">Donation Date: </label>
        <input type="date" name="donationDate" required style="">
        <br>

        <label style="">Employee ID</label>
        <input name="empID" required style="">
        <br>

        <label style="">Notes: </label>
        <textarea rows="3" cols="50" name="notes" style="">
            </textarea>
        <br>
        <br>

        <input type="submit" name="submit" style="width: 10%;">
    </form>
</body>
</html>

    <?php

}
?>
