<?php
ob_start();
session_start();
$errorMessage = "";
$num_rows = 0;
$number = "";
$reg = "n";
if (isset($_SESSION['reg'])) {
    if ($_SESSION['reg'] == md5("y")) {
        $reg = $_SESSION['reg'];
        $number = $_SESSION['number'];
    }
}
if (isset($_POST['submit'])) {
    $number = $_POST["number"];
    $number = htmlspecialchars($number);
}
require("include/top.php");
require("include/functions.php");
session_destroy();
?>



    <div class="loginbox">
        <div class="login">
            <img src="image/Inholland_logo.png" id="logologin"></img>
            <hr/>
            <h3>Registration is NOT open.</h3>
            <hr/>
        </div>
    </div>


<?php
require("include/bot.php");