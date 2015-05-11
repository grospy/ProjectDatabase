<?PHP
session_start();
session_destroy();
header("refresh:1;url=index.php");
require('include/top.php');

?>
    <section class="container">
        <div id="content">
            <p>
                You are logged out.
            </p>
            Sending you <a href="index.php">home... </a>
        </div>
    </section>
<?php
require('include/bot.php');

