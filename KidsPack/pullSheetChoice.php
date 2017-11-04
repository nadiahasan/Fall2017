<?php
/**
 * Created by PhpStorm.
 * User: nadiahasan
 * Date: 10/30/17
 * Time: 10:02 AM
 */



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


    <h2>KidsPACK Product Pull Sheet</h2>
    <p style="margin-top: 3%; margin-left: 5%; font-size: 100%; font-weight: bold;">Generate a Pull Sheet</p>
    <div id="outerDiv">

        <form action="pullSheets.php">
            <input type="submit" value="New Pull Sheet" style="background-color: coral;">
        </form>
<!--        <form method="staticPullSheet.php">-->
<!--            <input type="submit" value="Existing Pull Sheet" style="background-color: coral;">-->
<!--        </form>-->


    </div>

    </body>
    </html>






