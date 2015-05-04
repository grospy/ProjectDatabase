<?PHP
$errorMessage = "";
$num_rows = 0;
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uname = $_POST['username'];
    $pword = $_POST['password'];

    $uname = htmlspecialchars($uname);
    $pword = htmlspecialchars($pword);
    $user_name = "root";
    $pass_word = "admin";
    $database = "login";
    $server = "127.0.0.1";

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {
        $uname = quote_smart($uname, $db_handle);
        $pword = quote_smart($pword, $db_handle);

        $SQL = "SELECT * FROM login WHERE L1 = $uname AND L2 = md5($pword)";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                session_start();
                $_SESSION['login'] = "1";
                $_SESSION['name'] = $_POST["username"];
                header("Location: index.php");
            } else {
                $errorMessage = "Error logging on";
            }
        } else {
            $errorMessage = "Error logging on";
        }

        mysql_close($db_handle);

    } else {
        $errorMessage = "Error logging on";
    }

}
include_once "include/top.php";
?>

    <div class="login-area">
        <form method="POST" name="login">
            <p>Username: <INPUT TYPE='TEXT' Name='username' <?php if (isset($_POST['Submit'])) {
                    echo 'value="' . $_POST['username'] . '"';
                } ?> maxlength="16"></p>

            <p>Password: <INPUT TYPE='password' Name='password' maxlength="16"></p>

            <p><INPUT class="btn" TYPE="Submit" Name="Submit" VALUE="Login"></p>
        </form>
    <span id="error">
        <?php
        print $errorMessage;
        ?>
    </span>

        <p id="admin"><a href="admin.php">admin</a></p>
    </div>

<?php
include_once "include/bot.php";