<?php
ob_start();
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
require("include/top.php");
session_destroy();
?>


    <section class="container">
        <div class="login">
            <h1>IBIS Students Enrollment</h1>

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

            <p id="br-link"><a href="login_admin.php">admin</a></p>
        </div>
        <div class="login-help">
            <p>Set/change password <a href="getcode.php">here</a>.</p>
        </div>
    </section>


<?php
require("include/bot.php");

function login(&$error)
{
    $password = $_POST['password'];
    $number = $_POST['number'];
    $number = htmlspecialchars($number);
    $password = htmlspecialchars($password);

    require("include/database.php");

    if ($connection) {
        $number = quote_smart($connection, $number);
        $password = quote_smart($connection, $password);

        $SQL = "SELECT * FROM student WHERE student_number = $number AND password = md5($password)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $result->data_seek(0);
                $data = $result->fetch_array();
                $name = $data['first_name'];
                session_start();
                $_SESSION['login'] = md5("1");
                $_SESSION['name'] = $name;
                $_SESSION['number'] = $number;
                header("Location: index.php");
            } else {
                $error = "Invalid student number or password.";
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