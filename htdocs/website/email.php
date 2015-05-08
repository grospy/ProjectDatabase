<?php
$errorMessage = "&nbsp;";
$num_rows = 0;
$email = "";
if (isset($_POST['submit'])) {
    $email = $_POST["email"];
}
include_once "include/top.php";
?>
    <section class="container">
        <div class="login">
            <h1>Receive Password</h1>

            <form method="post">
                <p><input type="email" name="email" value='<?php echo htmlspecialchars($email); ?>' placeholder="Email">
                </p>

                <p class="submit"><input type="submit" name="submit" value="Send Mail"></p>
            </form>
            <p id="error">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (empty($_POST["email"])) {
                        $errorMessage = "Enter email";
                    } else {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            send($errorMessage);
                        }
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errorMessage = "Invalid email.";
                        }
                    }
                }
                echo $errorMessage;
                ?>
            </p>
            <br/>

            <p id="br-link"><a href="login2.php">admin</a></p>
        </div>
        <div class="login-help">
            <p>Know your password? <a href="index.php">Back to log in page</a>.</p>
        </div>
    </section>
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

function send(&$error)
{
    include_once "include/database.php";
    $email = $_POST['email'];

    $db_handle = mysql_connect($server, $user_name, $pass_word);
    $db_found = mysql_select_db($database, $db_handle);

    if ($db_found) {
        $email = quote_smart($email, $db_handle);

        $SQL = "SELECT * FROM student WHERE email = $email";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);


        if ($result) {
            if ($num_rows > 0) {
                $password = mysql_result($result, 0, "password");
                $sent = mysql_result($result, 0, "sent");
                if ($sent < 500) {
                    $error = $password;
                    $sent++;
                    mysql_query("UPDATE student SET sent = $sent WHERE email =$email");
                } else {
                    $error = "Maximum requests exceeded(5).";
                }


                echo $password;


            } else {
                $error = "Email not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysql_close($db_handle);
    } else {
        $error = "Error connecting to database.";
    }

}