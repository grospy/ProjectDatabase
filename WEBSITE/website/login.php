<?php
ob_start();
require("include/top.php");
require("include/database.php");
require("include/functions.php");
runCheck();
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
session_destroy();
?>



<div class="loginbox">
    <div class="login">
		<img src="image/Inholland_logo.png" id="logologin">
		<hr/>
        <h3>IBIS Students Enrollment</h3>
		<hr/>
        <form method="post">
            <?php if ($reg == md5("y")) {
                echo '<p class="error">Password is set. You can login now.</p>';
            } ?>
            <p><input type="text" name="number" value='<?php echo "$number"; ?>' placeholder="Student Number"></p>

            <p><input type="password" name="password" value="" placeholder="Password"></p>

            <p class="submit"><input type="submit" name="submit" value="Login"></p>
        </form>
        <p class="error">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $ch = 0;
                if (!empty($_POST["number"])) {
                    $ch++;
                }
                if (!empty($_POST["password"])) {
                    $ch++;
                    $ch++;
                }
                switch ($ch) {
                    case 0:
                        $errorMessage = "Please enter student number and password.";
                        break;
                    case 1:
                        $errorMessage = "Please enter your password.";
                        break;
                    case 2:
                        $errorMessage = "Please enter your student number";
                        break;
                    case 3:
                        login($errorMessage);
                        break;
                }
            }
            echo $errorMessage;
            ?>
        </p><br/>

        <p id="switch"><a href="login_admin.php">admin</a></p>
    </div>
    <div>
        <p  class="help">Set/change password <a href="getcode.php">here</a>.</p>
    </div>
</div>


<?php
require("include/bot.php");