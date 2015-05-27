<?PHP
session_start();
session_destroy();
header("refresh:1;url=index.php");
require('include/top.php');

?>
    <div class="loginbox">
        <div class="login">
            <img src="image/Inholland_logo.png" id="logologin"></img>
            <hr/>
            <h3>You are logged out</h3>
            <hr/>
            Sending you <a href="index.php">home... </a>

        </div>
    </div>




<?php
require('include/bot.php');

