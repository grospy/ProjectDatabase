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

        <p id="admin"><a href="admin.php">admin</a></p>
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
    $uname = $_POST['username'];
    $pword = $_POST['password'];

    $uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);

    $user_name = "root";
    $pass_word = "admin";
    $database = "inholland";
    $server = "127.0.0.1";

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {
        $uname = quote_smart($uname, $db_handle);
        $pword = quote_smart($pword, $db_handle);

        $SQL = "SELECT * FROM student WHERE student_number = $uname AND password = md5($pword)";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);



        if ($result) {
            if ($num_rows > 0) {
                $SQL2 = "SELECT first_name FROM student WHERE student_number = $uname AND password = md5($pword)";
                $result2 = mysql_query($SQL2);
                $name = mysql_result($result2, 0); // outputs third employee's name
                session_start();
                $_SESSION['login'] = "1";
                $_SESSION['name'] = $name;
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