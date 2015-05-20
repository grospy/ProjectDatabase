<?php
ob_start();
require('include/top.php');

$errorMessage = "&nbsp;";
$num_rows = 0;
$number = "";
if (isset($_POST['submit'])) {
    $number = $_POST["number"];
}
?>
    <section class="container">
        <div class="login">
            <h1>Set New Password</h1>

            <form method="post">
                <p><input type="text" name="number" value='<?php echo htmlspecialchars($number); ?>'
                          placeholder="Student Number"></p>

                <p class="submit"><input type="submit" name="submit" value="Send Mail"></p>
            </form>
            <p id="error">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (empty($_POST["number"])) {
                        $errorMessage = "Enter student number.";
                    } else {
                        set($errorMessage);
                    }
                }
                echo $errorMessage;
                ?>
            </p>
            <br/>

            <p id="br-link"><a href="login_admin.php">admin</a></p>
        </div>
        <div class="login-help">
            <p><a href="index.php">Back to log in page</a>.</p>
        </div>
    </section>
<?php
require('include/bot.php');



//==================================================================


function set(&$error)
{
    include_once "include/database.php";
    $number = $_POST['number'];

    $db = new mysqli($server, $user_name, $pass_word, $database);

    if ($db) {
        $number = quote_smart($number, $db);

        $SQL = "SELECT * FROM student WHERE student_number = $number";
        $result = $db->query($SQL);
        $num_rows = mysqli_num_rows($result);


        if ($result) {
            if ($num_rows > 0) {

                $result->data_seek(0);
                $data = $result->fetch_array();
                $password = $data['password'];

                $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                $code = "";
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < 8; $i++) {
                    $n = substr($alphabet, rand(0, $alphaLength), 1);
                    $code .= $n;
                }
                $db->query("UPDATE student SET set_code = '$code' WHERE student_number = $number");
                $db->query("UPDATE student SET password = '$password' WHERE student_number = $number");
                sendmail($code);
                session_start();
                $_SESSION['number'] = $number;
                $_SESSION['login'] = md5("3");
                header("Location: setpassword.php");

            } else {
                $error = "index number not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($db);
    } else {
        $error = "Error connecting to database.";
    }

}

function sendmail($code)
{
    include 'PHPMailer/class.phpmailer.php';
    include("PHPMailer/class.smtp.php");

    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "registeramadeus@gmail.com";
    $mail->Password = "Amadeus1";
    $mail->SetFrom("registeramadeus@gmail.com");
    $mail->Subject = "Registration code";
    $mail->Body = "Use this code to finish registration: $code";
    $mail->AddAddress($_POST["number"] . "@student.inholland.nl");
    if (!$mail->Send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "sent";
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