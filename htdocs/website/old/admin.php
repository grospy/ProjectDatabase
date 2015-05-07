<?php
$errorMessage = "";
$num_rows = 0;
$uname = "";
if (isset($_POST['submit'])) {
    $uname = $_POST["username"];
}
include_once "include/top.php";
?>
    <div class="login-area">
        <form method="POST" name="login">
            <span id="login-title">Admin Login</span>
            <p>Username: <INPUT TYPE='TEXT' Name='username' placeholder="Enter username" value='<?php echo "$uname"; ?>'
                                maxlength="16"></p>

            <p>Password: <INPUT TYPE='password' Name='password' placeholder="Enter password" maxlength="16"></p>

            <p><INPUT class="btn" TYPE="submit" Name="submit" VALUE="Login"></p>
        </form>
        <span id="error">
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
        </span>

        <p id="br-link"><a href="old/index.php">student</a></p>
    </div>
<?php
include_once "include/bot.php";


//==================================================================

function quote_smart($value, $handle)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value, $handle) . "'";
    }
    return $value;
}

function login(&$error)
{
    include_once "include/database.php";
    $uname = $_POST['username'];
    $pword = $_POST['password'];

    $uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {
        $uname = quote_smart($uname, $db_handle);
        $pword = quote_smart($pword, $db_handle);

        $SQL = "SELECT * FROM employee WHERE username = $uname AND password = md5($pword)";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);



        if ($result) {
            if ($num_rows > 0) {
                session_start();
                $_SESSION['login'] = "2";
                header("Location: index.php");
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Query error.";
        }
        mysql_close($db_handle);
    } else {
        $error = "Error connectiong to database.";
    }

}