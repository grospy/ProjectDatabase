<?php
session_start();
if($_SESSION['login'] != md5("3")){
    header("Location:index.php");
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
include_once "include/top.php";
?>
    <section class="container">
        <div class="login">
            <h1>Set New Password</h1>

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

            <p id="br-link"><a href="login2.php">admin</a></p>
        </div>
        <div class="login-help">
            <p>Know your password? <a href="index.php">Back to log in page</a>.</p>
        </div>
    </section>
<?php
include_once "include/bot.php";


//==================================================================
function set(&$error)
{
    require_once "include/database.php";
    $number = $_POST["number"];
    $code = $_POST["code"];
    $password = $_POST["password"];

    $db = new mysqli($server, $user_name, $pass_word, $database);

    if ($db) {
        $number = quote_smart($number, $db);
        $code = quote_smart($code, $db);
        $password = quote_smart($password, $db);


        $SQL = "SELECT * FROM student WHERE student_number = $number";
        $result = $db->query($SQL);
        $num_rows = mysqli_num_rows($result);


        if ($result) {
            if ($num_rows > 0) {
                $result->data_seek(0);
                $data = $result->fetch_array();
                $db_code = $data['set_code'];
                $db_pass = $data['password'];
                $db_sent = $data['sent'] + 1;
                $db_code = quote_smart($db_code, $db);
                if ($db_pass === NULL) {
                    $error = "Password already set.";
                } else if ($db_code != $code) {
                    $error = "Invalid registration code." . $db_code . $code;
                } else {
                    $db->query("UPDATE student SET password = md5($password) WHERE student_number = $number");
                    $db->query("UPDATE student SET sent = $db_sent WHERE student_number = $number");
                    $_SESSION['reg']=md5("y");
                    $_SESSION['number']=$number;
                    header("Location: index.php");
                }
            } else {
                $error = "Student number not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($db);
    } else {
        $error = "Error connecting to database.";
    }

}

function quote_smart($value, $handle)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($handle, $value) . "'";
    }
    return $value;
}