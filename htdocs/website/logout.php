<?PHP
    session_start();

    session_destroy();
    header( "refresh:2;url=index.php" );
    include_once "include/top.php";
?>
<div id="content">
    <p>
        You are logged out.
    </p>
    Sending you <a href="index.php">home... </a>
</div>
<?php
    include_once "include/top.php";