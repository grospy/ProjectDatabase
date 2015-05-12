<?PHP
session_start();
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}
require("include/top.php");
?>

<div class="dash">
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?></p>
    <!--<p>Registration deadline:</p>-->
    <!--<p>Credits:?></p>-->
    <p><a href="logout.php">Log out</a></p>
</div>
<!--==================================================-->
<div class="tabs">

    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-1" name="tab-group-1">
        <label class="tab-label" for="tab-1">Grades</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Grades</h3>
                <?php require('include/Grades.php'); ?>
            </div>
        </div>
    </div>

    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" checked>
        <label class="tab-label" for="tab-2">Enroll</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Enroll</h3>
                <?php require('include/Enroll.php'); ?>
            </div>
        </div>
    </div>
    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
        <label class="tab-label" for="tab-3">Schedule</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Schedule</h3>
                <?php require('include/Schedule.php'); ?>
            </div>
        </div>
    </div>

    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-4" name="tab-group-1">
        <label class="tab-label" for="tab-4">Description</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Descriptions</h3>
                <?php require('include/Description.php'); ?>
            </div>
        </div>
    </div>
</div>
</div>
<!------------------------------------------------------------------>
<?php
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

require("include/bot.php");
?>
