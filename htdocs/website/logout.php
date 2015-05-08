<?PHP
session_start();
session_destroy();
header("refresh:1;url=index.php");
include_once "include/top.php";
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
include_once "include/top.php";