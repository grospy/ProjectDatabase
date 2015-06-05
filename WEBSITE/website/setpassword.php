<?php
session_start();
if ($_SESSION['login'] != md5("3")) {
    header("Location:index.php");
    exit();
}
$errorMessage = "";
$num_rows = 0;
$number = $_SESSION["number"];
$code = "";
$password = "";
$password2 = "";
if (isset($_POST['submit'])) {
    $number = $_POST["number"];
    $code = $_POST["code"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
}
require('include/top.php');
require('include/functions.php');

?>
    <section class="loginbox">
        <div class="login">
            <img src="image/Inholland_logo.png" id="logologin"></img>
            <hr/>
			<h1>Set New Password</h1>
			<hr/>
            <form method="post">
                <p><input type="text" name="number" value='<?php echo htmlspecialchars($number); ?>'
                          placeholder="Student Number"></p>

                <p class="error">Check your student mail for the registration code.</p>

                <p><input type="text" name="code" value='<?php echo htmlspecialchars($code); ?>'
                          placeholder="Registration code"></p>

                <p><input type="password" name="password" value='<?php echo htmlspecialchars($password); ?>'
                          placeholder="Password"></p>

                <p><input type="password" name="password2" value='<?php echo htmlspecialchars($password2); ?>'
                          placeholder="Repeat password"></p>

                <p class="submit"><input type="submit" name="submit" value="Set Password"></p>
            </form>
            <p class="error">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $ch = 0;
                    if (!empty($_POST["code"])) {
                        $ch++;
                    }
                    if (!empty($_POST["password"])) {
                        $ch++;
                        $ch++;
                    }
                    switch ($ch) {
                        case 0:
                            $errorMessage = "Please enter registration code and password.";
                            break;
                        case 1:
                            $errorMessage = "Please enter a password.";
                            break;
                        case 2:
                            $errorMessage = "Please enter your registration code.";
                            break;
                        case 3:
                            if (!preg_match('/^[0-9A-Za-z!@#$%]{6,}$/', $password)) {
                                $errorMessage = 'The password does not meet the requirements.<br/>(a-z, A-Z, 0-9, !@#$%, at least 6 characters)';
                            } else if ($password == $password2) {
                                set($errorMessage);
                            } else {
                                $errorMessage = "Passwords do not match.";
                            }
                            break;
                    }
                }
                echo $errorMessage;
                ?>
            </p>
            <br/>

            <p id="br-link"><a href="login_admin.php">admin</a></p>
        </div>
        <div class="help">
            <p>Know your password? <a href="index.php">Back to log in page</a>.</p>
        </div>
    </section>
<?php
require('include/bot.php');