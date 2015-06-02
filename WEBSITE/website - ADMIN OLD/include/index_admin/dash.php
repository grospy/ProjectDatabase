<div class="dash"><img src="image/Inholland_logo.png" id="logotop">
    <div id="webtitle">
        International Business Innovation Studies
        <br/>Elective Courses Enrolment
    </div>
    <div id="welcome">
        Welcome Admin.
        <br/><span id="logout"><a href="logout.php">Log out</a></span>
    </div>
    <?php if (isset($_SESSION["message"])) {
        echo $_SESSION["message"];
        $_SESSION["message"] = "";
    } ?>
</div>