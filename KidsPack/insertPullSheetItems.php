<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/18/17
 * Time: 8:11 PM
 * Description: This file contains a form that collects the items to be included in KidsPACK
 */



session_start(); // start session


if (!isset($_SESSION['username'])) {// checking if user is allowed to access this page
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
    $result = $conn->query($sql_command); // submitting query to database
    $row = $result->fetch_assoc();
    if ($row['TYPE'] == 1) {

        include "adminMenu.php";
    }


// If there is at least one user with the same username or email, display an error message
    if ($result->num_rows == 0) {
        die("Unauthorized Access");

    }

    if ($result->num_rows !== 0) {
        include "topMenu.php";
    }

    $conn->close();

// Create a connection to mysql server
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection is not successful
    if ($conn->connect_error) {
        die("Connection to serverfailed: " . $conn->connect_error);
    }


    $findDateTime = "SELECT NOW();";
    $result=$conn->query($findDateTime);

    $dateTime="";
    $row = $result->fetch_assoc();
    foreach ($row as $value){
        $dateTime = $value;
    }
    //echo $dateTime;

    $sql_command="INSERT INTO PULL_SHEETS_TEMPLATE VALUES(DEFAULT,'".$_POST['templateName']."','".$dateTime."');";
    $result=$conn->query($sql_command);

    $sql_command="SELECT * FROM PULL_SHEETS_TEMPLATE WHERE TEMPLATE_NAME='".$_POST['templateName']."' 
    AND TEMPLATE_DATE='".$dateTime."' order by TEMPLATE_ID DESC";
    $result=$conn->query($sql_command);

    $row = $result->fetch_assoc();
    $templateId = $row['TEMPLATE_ID'];


    $_SESSION['templateID'] = $templateId;
    echo     $_SESSION['templateID'];

    ?>

    <html>
    <head>
        <title>DEMO</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <style>

            body {
                font-family: Arail, sans-serif;
            }

            /* Formatting search box */
            .searchBox {
                width: 300px;
                position: relative;
                display: inline-block;
                font-size: 14px;
            }

            .searchBox input[type="text"] {
                height: 32px;
                padding: 5px 10px;
                border: 1px solid #CCCCCC;
                font-size: 14px;
            }

            .result {
                position: absolute;
                z-index: 999;
                top: 100%;
                left: 0;
                background-color: ghostwhite;
            }

            .searchBox input[type="text"], .result {
                width: 100%;
                box-sizing: border-box;
                text-align: left;
            }


            .result p {
                margin: 0;
                padding: 7px 10px;
                border: 1px solid #CCCCCC;
                border-top: none;
                cursor: pointer;
            }

            .result p:hover {
                background: #CCCCCC;
            }

            th {
                width: 320px;
                font-size: 14px;
            }

            ::-webkit-input-placeholder {
                text-align: center;
            }

            input {
                text-align: center;
            }
        </style>

    </head>
    <body>


    <h2 style="margin-top: 3%; margin-left: 30%;">KidsPACK Product Pull Sheet</h2>

    <div id="outerDiv">
        <table>
            <tr>
                <td rowspan="2" width="400px">
        <form action="confirmPSTemplate.php" method="post" id="pullForm">


            <table id="pullSheetTable" class="pullTable">

                <tr>
                    <th>Items</th>
                    <th>Case Quantity</th>
                    <th>Case Barcode</th>
                    <th>Amount Per Pack</th>
                    <th></th>

                </tr>

            </table>


            <input type="submit" value="Finish" id="submit0" style="display: none;"/>

        </form>
                </td><td valign="bottom">
                    <button id="addRowButton" style="background-color: coral;padding: 10px 28px;text-align: center; " onclick="addRow()">
                        Add Row
                    </button></td></tr><tr>
                <td style="height: 48px;">&nbsp;</td>

            </tr>
            </tr>
        </table>
    </div>


    <script type="text/javascript">

        var numRows = 0; // This counts the current number of rows in the table
        var actualNumRows=0;

        // This function is used to perform live search
        function g(elem) {

            $(document).ready(function () {
                $('.searchBox input[type="text"]').on("keyup input", function () {
                    var inputVal = $(this).val();
                    var resultDropdown = $(this).siblings(".result");
                    if (inputVal.length) {
                        $.get("processSearch.php", {term: inputVal}).done(function (data) {
                            // Display the returned data in browser
                            resultDropdown.html(data);
                        });
                    } else {

                        resultDropdown.empty();
                    }
                });
                // Set search input value on click of result item
                $(document).on("click", ".result p", function () {
                    $(this).parents(".searchBox").find('input[type="text"]').val($(this).text());
                    var vv1=$(this).parents(".searchBox").find('input[type="text"]')[0].getAttribute('name');
                    $(this).parent(".result").empty();
                    console.log($(this).parents(".searchBox")['context'].getAttribute('pBar'));
                    var vv2=vv1.replace('d0_','caseBarcode');
                    var ve=document.getElementById(vv2);
                    ve.value=$(this).parents(".searchBox")['context'].getAttribute('pBar');
                    vv2=vv1.replace('d0_','caseQuantity');
                    ve=document.getElementById(vv2);
                    ve.value=$(this).parents(".searchBox")['context'].getAttribute('quantity');
                    //console.log(elem.value); // this is for testing purposes
                });


            });

        }


        // This function adds a new row to the table
        function addRow() {
            // Remove the last submit button
            var xSubmit = document.getElementById("submit" + numRows);
            var form = document.getElementById("pullForm");
            form.removeChild(xSubmit);

            // Retrieving the table and creating a new row
            var table = document.getElementById("pullSheetTable");
            var row = document.createElement("tr");
            row.setAttribute("class", "pullRow"); // add class attribute to new row

            // Add data fields to the new row
            for (var i = 0; i < 5; i++) {
                var d = document.createElement("td");
                d.setAttribute("id", ("d" + i + "-" + numRows));
                d.setAttribute("name",("td" + i + "_" + numRows));
                d.setAttribute("class", "pullField");
                row.appendChild(d);
            }


            table.appendChild(row); // append row to table


            var firstField = document.getElementById("d0-" + numRows);// retrieving first data field

            var newDiv = document.createElement("div");
            newDiv.setAttribute("class", "searchBox");

            // create input field
            var inputField = document.createElement("input");
            inputField.setAttribute("type", "text");
            inputField.setAttribute("id", "itemInput" + numRows);
            inputField.setAttribute("name", "d0_" + numRows);
            inputField.setAttribute("autocomplete", "off");
            inputField.setAttribute("placeholder", "search product");
            inputField.required=true;
            inputField.style.width = "300px";
            inputField.style.position = "relative";
            inputField.style.display = "inline-block";
            inputField.style.fontSize = "14px";

            //inputField.addEventListener("click", checkInput); // this is not required

            newDiv.appendChild(inputField);


            var newDiv2 = document.createElement("div");
            newDiv2.setAttribute("class", "result");
            newDiv.appendChild(newDiv2);

            firstField.appendChild(newDiv);


            g(inputField); // calling live search function


            // Creating a new input field to display case quantity

            var inputField2 = document.getElementById("d1-" + numRows);
            var caseQuantity = document.createElement("input");
            caseQuantity.setAttribute("id", "caseQuantity" + numRows);
            caseQuantity.setAttribute("name", "d1_" + numRows);
            caseQuantity.required=true;
            caseQuantity.readOnly = true;
            caseQuantity.style.width = "200px";
            caseQuantity.style.height = "32px";
            caseQuantity.style.marginLeft = "5px";
            caseQuantity.style.marginRight = "5px";
            caseQuantity.padding = "5px 10px";
            inputField2.appendChild(caseQuantity);

            // Creating a  field for case barcode. It will not be displayed to user

            var inputField2 = document.getElementById("d2-" + numRows);
            var caseBarcode = document.createElement("input");
            caseBarcode.setAttribute("id", "caseBarcode" + numRows);
            caseBarcode.setAttribute("name", "d2_" + numRows);
            caseBarcode.readOnly = true;
            caseBarcode.required=true;
            caseBarcode.style.width = "200px";
            caseBarcode.style.height = "32px";
            caseBarcode.style.marginLeft = "5px";
            caseBarcode.style.marginRight = "5px";
            caseBarcode.padding = "5px 10px";
            inputField2.appendChild(caseBarcode);


            // Creating a new input field to input amount of product per pack

            var inputField3 = document.getElementById("d3-" + numRows);
            var amountPerPack = document.createElement("input");
            amountPerPack.setAttribute("placeholder", "1");
            amountPerPack.setAttribute("id", "amountPerPack" + numRows);
            amountPerPack.setAttribute("name", "d3_" + numRows);
            amountPerPack.required=true;
            amountPerPack.style.width = "200px";
            amountPerPack.style.height = "32px";
            amountPerPack.style.marginLeft = "5px";
            amountPerPack.style.marginRight = "5px";
            amountPerPack.padding = "5px 10px";
            inputField3.appendChild(amountPerPack);


            firstField = document.getElementById("d4-" + numRows);
            var newButton2 = document.createElement("button");
            newButton2.setAttribute("type", "button");
            newButton2.style.backgroundColor = "coral";
            newButton2.style.width = "100px";
            newButton2.style.height = "32px";
            newButton2.padding = "5px 10px";
            newButton2.textAlign = "center";
            newButton2.innerHTML = "Delete Row";
            newButton2.setAttribute("onclick","deleteRow("+numRows+")");

            firstField.appendChild(newButton2);

            var newRow = document.createElement("tr");
            newRow.setAttribute("id","row"+numRows);
            table.appendChild(newRow);

            numRows++;
            actualNumRows++;

            // Creating a new submit button
            var submitButton = document.createElement("input");
            submitButton.setAttribute("type", "submit");
            submitButton.setAttribute("value", "Finish");
            submitButton.setAttribute("id", "submit" + numRows);
            submitButton.required=true;
            submitButton.style.backgroundColor = "coral";
            submitButton.style.width = "200px";
            submitButton.style.height = "32px";
            submitButton.style.textAlign = "center";
            form.appendChild(submitButton);


        }


        function deleteRow(num){
            var table= document.getElementById("pullSheetTable");
            var row = document.getElementById("row"+num);
            for (var i = 0; i < 5; i++) {
                var d = document.getElementById("d"+i+"-"+num);
                d.parentNode.removeChild(d);
            }
            row.parentNode.removeChild(row);
            actualNumRows--;
            console.log(actualNumRows);
            if(actualNumRows==0){
                var submitButton = document.getElementById("submit" + numRows);
                submitButton.style.display="none";

            }

        }



        // This function is used to validate initials on client-side
        function checkInitials(currentRow) {
            //console.log(this.value);


            var init = document.getElementById("d1-" + currentRow);
            var val = init.value;
            console.log(val);
            var alphabet = /^[A-Z]+$/;

        }




    </script>

    </body>
    </html>

    <?php
}
?>


