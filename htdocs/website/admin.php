<?PHP
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login.php");
}
require('include/top.php');
?>
<section class="container">
    <div id="content">
        <h1>Welcome, admin</h1>
        <p><a href="addstudent.php">Add a student to the database</a> </p>
        <p>
            <a href="logout.php">Log out</a>
        </p>
    </div>
</section>
<?php
require('include/bot.php');
