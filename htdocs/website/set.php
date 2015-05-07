<?php
ob_start();
require_once "include/top.php";
$errorMessage = "&nbsp;";
$num_rows = 0;
$email = "";
if (isset($_POST['submit'])) {
    $email = $_POST["email"];
}
?>
    <section class="container">
        <div class="login">
            <h1>Set New Password</h1>

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
                            set($errorMessage);
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

            <p id="br-link"><a href="admin.php">admin</a></p>
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
    include_once "include/database.php";
    $email = $_POST['email'];

    $db = new mysqli($server, $user_name, $pass_word, $database);

    if ($db) {
        $email = quote_smart($email, $db);

        $SQL = "SELECT * FROM student WHERE email = $email";
        $result = $db->query($SQL);
        $num_rows = mysqli_num_rows($result);


        if ($result) {
            if ($num_rows > 0) {

                $result->data_seek(0);
                $data = $result->fetch_array();
                $password = $data['password'];

                if ($password != null) {
                    $error = "You already have a password. <a href='request.php'>Forgot</a>?";
                } else {
                    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                    $code = "";
                    $alphaLength = strlen($alphabet) - 1;
                    for ($i = 0; $i < 8; $i++) {
                        $n = substr($alphabet, rand(0, $alphaLength), 1);
                        $code .= $n;
                    }
                    sendmail($email, $code);
                    //header("Location: register.php");
                }
                //mysql_query("UPDATE student SET sent = $sent WHERE email = $email");
            } else {
                $error = "Email not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($db);
    } else {
        $error = "Error connecting to database.";
    }

}

function sendmail($email,$code)
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
    $mail->Body = "Use this code to finish registration: $code.";
    $mail->AddAddress($email);
    if (!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message has been sent";
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