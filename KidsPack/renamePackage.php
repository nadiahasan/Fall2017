<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/12/17
 * Description: This file updates the name (and only the name) of an existing
 *                 packaging type from the database.
 */

session_start();
ob_start();


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

    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "';";

    $result1 = $conn->query($sql_command); // submitting query to database

    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }


    // Search for the type to be deleted

    $sql_command = "select * from CONTAINER_TYPE where CONTAINER_TYPE='" . $_POST['deletePackage'] . "';";

    $result = $conn->query($sql_command); // submitting query to database


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


    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Container Type</p>
    <div id="outerDiv">

        <form method="post" action="renamePackageConfirmation.php">

        <ul>
            <?php
            $sql_command = "select * from CONTAINER_TYPE;";
            $result = $conn->query($sql_command); // submitting query to database

            $numRows = mysqli_num_rows($result);


            $v = 0;


            while ($row = mysqli_fetch_assoc($result)) {

                //echo $row['CONTAINER_TYPE'];
                echo '<li>' . $row['CONTAINER_TYPE_ID'];
                echo '<input value="' . $row['CONTAINER_TYPE'] . '" disabled name ="input'.$row['CONTAINER_TYPE_ID'].'" id="input'.$row['CONTAINER_TYPE_ID'].'">
                </li>';
                echo '<button type="button" onclick="f('.$row['CONTAINER_TYPE_ID'].');">Edit</button>';


                $v = (int)$row['CONTAINER_TYPE_ID'];
                echo "<br>";

            }
            ?>
        </ul>
            <input type="submit" value="submit">
        </form>
    </div>

    <script type="text/javascript">

        function f(num){
            var bcode = document.getElementById("input"+num);
            bcode.removeAttribute("disabled");
        }

    </script>

    </body>
    </html>

    <?php
    $conn->close();
}

?>
