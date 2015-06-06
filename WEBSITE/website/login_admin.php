<?php
ob_start();
require("include/top.php");
require("include/database.php");
require("include/functions.php");
runCheck();
$errorMessage = "";
$num_rows = 0;

isset($_POST['username']) ? $un = htmlspecialchars($_POST['username']) : $un = "";
isset($_POST['password']) ? $pw = htmlspecialchars($_POST['password']) : $pw = "";

?>
    <div class="loginbox">
        <div class="login">
            <img src="image/Inholland_logo.png" id="logologin"></img>
            <hr/>
            <h3>Admin Login</h3>
            <hr/>


            <form method="post">
                <p><input type="text" name="username" value="<?php echo "$un"; ?>" placeholder="Username"></p>

                <p><input type="password" name="password" value='<?php echo "$pw"; ?>' placeholder="Password"></p>

                <p class="submit"><input type="submit" name="submit" value="Login"></p>
            </form>
            <p class="error">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $ch = 0;
                    if (!empty($_POST["username"])) {
                        $ch++;
                    }
                    if (!empty($_POST["password"])) {
                        $ch++;
                        $ch++;
                    }
                    switch ($ch) {
                        case 0:
                            $errorMessage = "Please enter username and password.";
                            break;
                        case 1:
                            $errorMessage = "Please enter your password.";
                            break;
                        case 2:
                            $errorMessage = "Please enter your username";
                            break;
                        case 3:
                            login_admin($errorMessage);
                            break;
                    }
                }
                print $errorMessage;
                ?>
            </p><br/>

            <p id="br-link"><a href="index.php">student</a></p>
        </div>
        <p class="help">&nbsp;</p>
    </div>

<?php
require("include/bot.php");