<?php
ob_start();
require('include/top.php');
require('include/functions.php');

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
                        getcode($errorMessage);
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