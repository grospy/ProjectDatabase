<?PHP
session_start();
if ($_SESSION['login'] != "2") {
	header ("Location: admin.php");
}
include_once "include/top.php";
?>

<div id="content">
</div>
<P>
<A HREF = logout.php>Log out</A>

<?php include_once "include/bot.php";?>
