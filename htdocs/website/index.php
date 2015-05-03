<?php
include "top.php";
define('DB_HOST', 'localhost');
define('DB_NAME', 'inholland');
define('DB_USER', 'root');
define('DB_PASSWORD', 'admin');
$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db = mysql_select_db(DB_NAME, $con) or die("Failed to connect to MySQL: " . mysql_error());
?>

    <div class="register-form">
        <h1>Login</h1>

        <form method="POST">
            <p><label>Username: </label>
                <input id="username" type="text" name="username" placeholder="Enter Username" <?php if (isset($_POST["username"])){echo "value='".$_POST["username"]."'";}?> </p>

            <p><label>Password: </label>
                <input id="password" type="password" name="password" placeholder="Enter Password"/></p>

            <a class="btn" href="register.php">Signup</a>
            <input class="btn register" type="submit" name="submit" value="Login"/>
        </form>
<span id = "error">
<?php
if (isset($_POST['submit'])) {
    SignIn($_POST['username'], $_POST['password']);
}
?>
<?PHP

function SignIn($ID, $Password) {
    session_start();   //starting the session for user profile page
    if (!empty($_POST['username']) and !empty($_POST['password'])) {   //checking the 'user' name which is from Sign-In.html, is it empty or have some text
        $query = mysql_query("SELECT * FROM username where userName = '$ID' AND pass = '$Password'") or die(mysql_error());
        $row = mysql_fetch_array($query);
        if (!empty($row['userName']) AND !empty($row['pass'])) {
            $_SESSION['userName'] = $row['pass'];
            header("Location: connect.php");
        } else {
            echo "Invalid login.";
        }
    } else if (empty($_POST['username']) and empty($_POST['username'])) {
        echo "Enter username and password.";
    } else if (empty($_POST['username'])){
        echo "Enter username.";
    } else {
        echo "enter password";
    }
}
?>
</span>
</div>

<?php
include "bot.php";
?>