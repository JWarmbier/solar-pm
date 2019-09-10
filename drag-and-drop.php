<?php
/*PHP Login and registration script Version 1.0, Created by Gautam, www.w3schools.in*/

use PhpRbac\Rbac;

require('inc/config.php');
require('inc/functions.php');

/*Check for authentication otherwise user will be redirects to main.php page.*/
if (!isset($_SESSION['UserData'])) {
    exit(header("location:main.php"));
}
require_once 'PhpRbac/src/PhpRbac/Rbac.php';
$rbac = new PhpRbac\Rbac();


require('include/header.php');
require('include/menu.php');


?>
<!-- container -->

<div class="container">
    <p>Podaj odpowiedz wyrazenia: </p>
    <div id="firstDigit"></div>
    <div id="operationSign"></div>
    <div id="secondDigit"></div>
    <div id="equalSign">=</div>
    <div id="equationResult"  ondrop="drop(event)" ondragover="allowDrop(event)"></div>
    <br>
    <div id="isCorect"></div>
    <br>
    <div id="clr"></div>

    <div id="container1" ondrop="drop(event)" ondragover="allowDrop(event)"><div id="ans1" draggable="true" ondragstart="drag(event)" ></div></div>
    <div id="container2" ondrop="drop(event)" ondragover="allowDrop(event)"><div id="ans2" draggable="true" ondragstart="drag(event)"></div></div>
    <div id="container3" ondrop="drop(event)" ondragover="allowDrop(event)"><div id="ans3" draggable="true" ondragstart="drag(event)"></div></div>
    <div id="clr"></div>

    <script>
        var firstDigit = document.getElementById("firstDigit");
        var secondDigit = document.getElementById("secondDigit");
        var operationSign = document.getElementById("operationSign");

        var ans1 = document.getElementById("ans1");
        var ans2 = document.getElementById("ans2");
        var ans3 = document.getElementById("ans3");

        var first = Math.round(Math.random()*10);
        var second = Math.round(Math.random()*10);
        while(second == 0)second = Math.round(Math.random()*10)
        while(first == 0)first = Math.round(Math.random()*10)

        var equalSign = Math.round(Math.random()*3);
        var result;

        switch(equalSign){
            case 0:
                operationSign.innerHTML = "+";
                result = first + second;
                break;
            case 1:
                operationSign.innerHTML = "-";
                while(first - second < 0) {
                    first = Math.round(Math.random()*10);
                    second = Math.round(Math.random()*10);
                }
                result = first - second;
                break;
            case 2:
                operationSign.innerHTML = "*";
                result = first * second;
                break;
            case 3:
                operationSign.innerHTML = "/";
                result =  Math.round(first / second);
                break;
        }

        var placeOfResult = Math.round(Math.random()*2);

        var tmp1 = result;
        while(tmp1 == result)tmp1 = Math.round(Math.random()*(result+10));
        var tmp2 = result;
        while(tmp2 == result || tmp1 == tmp2)tmp2 = Math.round(Math.random()*(result+10));

        switch(placeOfResult){
            case 0:
                ans1.innerHTML = result;
                ans2.innerHTML = tmp1;
                ans3.innerHTML = tmp2;
                break;
            case 1:
                ans1.innerHTML = tmp1;
                ans2.innerHTML = result;
                ans3.innerHTML = tmp2;
                break;
            case 2:
                ans1.innerHTML = tmp1;
                ans2.innerHTML = tmp2;
                ans3.innerHTML = result;
                break;
        }

        firstDigit.innerHTML = first;
        secondDigit.innerHTML = second;

        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            equationResult = document.getElementById("equationResult");
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            if(ev.target.innerHTML == "")
                ev.target.appendChild(document.getElementById(data));
            if(equationResult.innerHTML == ""){
                document.getElementById("isCorect").innerHTML = "";
            } else {
                if (equationResult.childNodes[0].innerHTML == result){
                    document.getElementById("isCorect").innerHTML = "Dobrze!";
                } else
                    document.getElementById("isCorect").innerHTML = "Źle!";
            }
        }

    </script>
    <p id="demo"></p>
</div>

<?php require('include/footer.php');?>
