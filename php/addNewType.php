<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 8/17/17
 * Time: 9:07 PM
 * Description: This file asks the user to enter new product type or new container type
 *              (with multiple items inside) information.
 */


// Connecting php to mysql server
session_start();



echo $_SESSION['onGoingDonation'];


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

    $result1 = $conn->query($sql_command); // submitting query to database



    if ($result1->num_rows !== 0) {
        include "topMenu.php";
    }

    // Creating an sql query based on login information provided by user
    $sql_command="select TYPE from USERS where USERNAME='".$_SESSION["username"]."';";
    $result = $conn->query($sql_command);

    $row=$result->fetch_assoc();


    if($row['TYPE']==1){
        include "adminMenu.php";
    }

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



    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Add a New Item</p>
    <div id="outerDiv">

        <form method="post" id="newItemForm" action="newTypeConfirmation.php" style="margin-left: 3%;">

            <label style="">Barcode: </label>
            <input name="barcode" required style="">
            <br>

            <label style="">Is this new item a container with multiple items inside: </label>

        <br>
            <input type="radio" name="productOrContainer" value="c" required>Yes<br/>
            <input type="radio" name="productOrContainer" value="p" required>No<br/>


            <input type="submit" name="submit" style="width: 10%;">

        </form>

<!--            <label style="">Product Name: </label>-->
<!--            <input name="itemName" required style="">-->
<!--            <br>-->
<!--            <label style="">Barcode: </label>-->
<!--            <input name="barcode" required style="">-->
<!--            <br>-->
<!---->
<!--            <label style="">Item Container Type: </label>-->
<!---->
<!--            <select name="itemPackageType" id="myChoice" >-->
<!---->
<!--                --><?php
//
//                $sql_command ="select * from CONTAINER;";
//                $result = $conn->query($sql_command); // submitting query to database
//
//                $numRows = mysqli_num_rows($result);
//
//                $v =0;
//
//                while($row=mysqli_fetch_assoc($result)){
//                    echo '<option value="'.$row['CONTAINER_TYPE_ID'].'">'.$row['CONTAINER_TYPE'].'</option>';
//                    $v=(int)$row['CONTAINER_TYPE_ID'] ;
//                }
//                echo '<option value="'.($v+1).'">other</option>';
//
//
//                ?>
<!---->
<!---->
<!--            </select>-->
<!---->
<!---->
<!--            <label style="">Count per container: </label>-->
<!--            <input name="countPerContainer" required style="" placeholder="1">-->
<!--            <br>-->
<!---->
<!--            <div id="containerTypeDiv"></div>-->
<!---->
<!--            <br>-->
<!--            <br>-->
<!--            <br>-->
<!--            <label style="">Item Price: </label>-->
<!--            <input name="itemPrice" required style="">-->
<!--            <br>-->
<!--            <label style="">Expiration Date: </label>-->
<!--            <input type="date" name="expDate" required style="">-->
<!--            <br>-->
<!--            <label style="">Item Description: </label>-->
<!--            <textarea rows="3" cols="50" name="itemDesc" style="">-->
<!--            </textarea>-->
<!--            <br>-->
<!--            <br>-->
<!--            <br>-->
<!--            <label style="">Set minimum amount for this item in stock: </label>-->
<!--            <input name="itemMin" style="" placeholder="3000">-->
<!--            <br>-->
<!--            <label>This item is: </label>-->
<!--    <br>-->
<!--            <input type="radio" name="purchasedOrDonated" value=1>Purchased</br>-->
<!--            <input type="radio" name="purchasedOrDonated" value=2>Donated</br>-->
<!---->
<!---->
<!--        <input type="submit" name="submit" style="width: 10%;">-->
<!---->
<!--        </form>-->
<!---->
<!---->
<!--    </div>-->
<!---->
<!---->
<!--    <script type="text/javascript">-->
<!--        var form = document.getElementById("containerTypeDiv");-->
<!---->
<!---->
<!--        // this creates a new form for users to enter a new container type-->
<!--        document.getElementById("myChoice").onchange=function () {-->
<!--            if (this.options[this.selectedIndex].value == '4') {-->
<!---->
<!---->
<!--                form.appendChild(document.createElement("br"));-->
<!---->
<!--                var newLabel1 = document.createElement("label");-->
<!--                var text1 = document.createTextNode("Enter new container type: ");-->
<!--                newLabel1.appendChild(text1);-->
<!---->
<!---->
<!--                form.appendChild(newLabel1);-->
<!---->
<!--                var newInput = document.createElement("input");-->
<!--                newInput.type = "text";-->
<!--                newInput.setAttribute("name","newType");-->
<!--                form.appendChild(newInput);-->
<!---->
<!--                form.appendChild(document.createElement("br"));-->
<!---->
<!---->
<!--                var submitButton=document.createElement("button");-->
<!--                submitButton.innerHTML="confirm new type";-->
<!--                submitButton.setAttribute("id", "confirmNewContainerType");-->
<!---->
<!--                form.appendChild(submitButton);-->
<!---->
<!---->
<!--                var cancelButton=document.createElement("button");-->
<!--                cancelButton.innerHTML="cancel";-->
<!---->
<!--                cancelButton.setAttribute("id", "cancelAddition");-->
<!--                form.appendChild(cancelButton);-->
<!--                cancelButton.onclick=function(){-->
<!---->
<!--                    // removing the form in case "cancel" button is clicked-->
<!--                    while(form.hasChildNodes())-->
<!--                    {-->
<!--                        form.removeChild(form.lastChild);-->
<!--                    }-->
<!--                }-->
<!---->
<!---->
<!--//                var c = form.children;-->
<!--//                var txt = " ";-->
<!--//                var i;-->
<!--//                for (i = 0; i < c.length; i++) {-->
<!--//                    txt = txt + c[i].tagName + "<br>";-->
<!--//-->
<!--//                }-->
<!--//                document.getElementById("demo").innerHTML = txt;-->
<!---->
<!---->
<!--            } else {-->
<!---->
<!--                // removing the new container form in case another type is chosen-->
<!--                while(form.hasChildNodes())-->
<!--                {-->
<!--                    form.removeChild(form.lastChild);-->
<!--                }-->
<!---->
<!---->
<!--            }-->
<!---->
<!--        }-->
<!--    </script>-->
    </body>
    </html>

    <?php

}
    ?>

