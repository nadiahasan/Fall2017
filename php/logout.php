<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/23/17
 * Time: 11:02 AM
 */



// start and destroy the session to close any other sessions that might be open
session_start();
session_unset();
session_destroy();

?>


<html>
<head>
    <style>

    </style>



</head>



<body>

<?php
    include "topMenu.php";
?>

<h2>Thank you. See you soon.</h2>


</body>

</html>
