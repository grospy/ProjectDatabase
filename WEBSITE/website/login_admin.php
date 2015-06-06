<?php
ob_start();
require("include/top.php");
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
                            login($errorMessage);
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

function login(&$error)
{

    $password = $_POST['password'];
    $username = $_POST['username'];
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    require("include/database.php");

    if ($connection) {
        $username = quote_smart($connection, $username);
        $saltypassword = $password . "AMADEUS";
        $saltypassword = quote_smart($connection, $saltypassword);

        $SQL = "SELECT * FROM admin WHERE adminID = $username AND password = md5($saltypassword)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                session_start();
                $_SESSION['login'] = md5("2");
                header("Location: admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($connection);
    } else {
        $error = "Error connecting to database.";
    }

}

function quote_smart($handle, $value)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($handle, $value) . "'";
    }
    return $value;
}