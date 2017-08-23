<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 5:01 PM
 */

?>
<html>
<head>
    <style>
        ul{
            list-style-type: none;
            margin: 0;
            padding: 0%;

        }
        li{
            display: inline;
            margin-right: 2%;

        }
        li:hover{
            background-color: coral;
        }

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

<div id="navBar" style="background-color: darksalmon; padding: 1%;">


    <ul>
        <li style="margin-left: 0%; font-weight: bold; font-size: larger;">KidsPack</li>
        <li><a href="main.php">Home</a></li>
        <li style="float: right;">Search:<form method="post" action="main.php" style="display: inline;"><input type="text" name="searchText"/></form></li>

    </ul>
</div>
<p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Welcome to KidsPack</p>


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
    <input type="password" name="password" required style="">
    <br>
    <label style="">Confirm Password: </label>
    <input type="password" name="password" required style="">
    <br>
    <label style="">Email:</label>
    <input type="email" name="email" required style="">
    <br>
    <label style="">Are you an Employee at KidsPack?</label>
    <button name="yesButton">Yes</button>
    <button name="noButton">No</button>
    <br>

    <input type="submit" style="margin-left:24%; margin-top: 5%;">

</form>


</div>

</body>



</html>



