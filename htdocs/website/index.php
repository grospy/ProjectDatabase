<?PHP
session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: login.php");
}
$name = $_SESSION["name"];
include_once "include/top.php";
?>

<div id="content">
    <?php
    echo "Welcome, " . $name?>
</div>
<P>
<A HREF = logout.php>Log out</A>

<?php include_once "include/bot.php";?>
