<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/28/17
 * Time: 9:22 AM
 */


//echo $_SESSION['username'];

if(isset($_SESSION['username'])) {

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "INVENTORY";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if connection is not successful
    if ($conn->connect_error) {
        die("Connection to serverfailed: " . $conn->connect_error);
    }


 //checking if the admin is now using the session by checking the privilege level
    $sql_command = "select * from USERS where USERNAME='" . $_SESSION['username'] . "' and TYPE=1;";

    $result = $conn->query($sql_command); // submitting query to database
    if ($result->num_rows !== 0) {

        ?>
        <html>
        <head>

        </head>
        <body>


        <div id="mainFrame" class="form">

            <div>
                <form method="post" action="inventory.php">
                    <input type="submit" name="submitButton" value="Inventory Management"/>
                </form>



            </div>

        </div>
        </body>
        </html>
        <?php
    }
    //$conn->close();
}

?>

