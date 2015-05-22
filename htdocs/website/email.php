<?php
$errorMessage = "&nbsp;";
$num_rows = 0;
$email = "";
if (isset($_POST['submit'])) {
    $email = $_POST["email"];
}
require('include/top.php');
require('include/functions.php');

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

            <p id="br-link"><a href="login_admin.php">admin</a></p>
        </div>
        <div class="login-help">
            <p>Know your password? <a href="index.php">Back to log in page</a>.</p>
        </div>
    </section>
<?php
require('include/bot.php');