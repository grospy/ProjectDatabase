<?php
require("include/top.php");
ob_start();
$errorMessage = "";
$num_rows = 0;
$username = "";
if (isset($_POST['submit'])) {
    $username = $_POST["username"];
    $username = htmlspecialchars($username);
}
?>
    <section class="container">
        <div class="login">
            <h1>Admin Login</h1>

            <form method="post">
                <p><input type="text" name="username" value="" placeholder="Username"></p>

                <p><input type="password" name="password" value='<?php echo "$username"; ?>' placeholder="Password"></p>

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
    </section>
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
        $password = quote_smart($connection, $password);

        $SQL = "SELECT * FROM employee WHERE username = $username AND password = md5($password)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                session_start();
                $_SESSION['login'] = md5("2");
                header("Location: admin.php");
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