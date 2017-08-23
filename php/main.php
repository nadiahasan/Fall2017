<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/15/17
 * Time: 8:48 PM
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

<div id="navBar" style="background-color: darksalmon; padding: 1%;">


<ul>
    <li style="margin-left: 0%; font-weight: bold; font-size: larger;">KidsPack</li>
    <li><a href="main.php">Home</a></li>
    <li style="float: right;">Search:<form method="post" action="main.php" style="display: inline;"><input type="text" name="searchText"/></form></li>

</ul>
</div>
<p style="margin-top: 3%; margin-left: 30%; font-size: 200%; font-weight: bold;">Welcome to KidsPack</p>


<div id="outerDiv" style="float: none; overflow: auto; width: 100%;">



<div id="signupDiv">
    <p style="margin-left: 25%; margin-top: 10%;">Create a New Account</p>
    <br/>
    <button type="button" style="margin-left: 15%; width: 75%;">Sign Up Here</button>

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
        <input type="text" name="username">
        <br>
        <br>
        <label style="margin-left:6%;">Password: </label>
        <input type="text" name="password">
        <br>
        <br>

        <input type="submit" name="submitButton" style="width: 40%; margin-left:30%; margin-right: 30%;"/>


    </form>



</div>

</div>

</body>



</html>




<?php

?>



