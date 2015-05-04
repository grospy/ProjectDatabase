<?PHP
    include_once "include/top.php";
	session_start();
    session_destroy();
?>
<div id="content">
    <p>
        You are logged out.
    </p>
    <a href="index.php"> Login page </a>
</div>
<?php
    include_once "include/top.php";