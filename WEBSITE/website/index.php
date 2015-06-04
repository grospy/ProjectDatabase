

<?PHP
ob_start();
session_start();
require("include/functions.php");
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}else if(!access($_SESSION['number'])){
    header("Location: regclosed.php");
}
require("include/top.php");
require("include/database.php");
?>
<div class="dash">
    <?php require("include/index/dash.php"); ?>

</div>

<div class="creditmsg">
    <?php require("include/index/credit.php"); ?>
</div>

<div class="tabs">
    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-1" name="tab-group-1">
        <label class="tab-label" for="tab-1">Grades</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Grades</h3>
                <?php require('include/index/Grades.php'); ?>
            </div>
        </div>
    </div>
    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" checked>
        <label class="tab-label" for="tab-2">Enroll</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Enroll
                <?php require('include/index/Enroll.php'); ?>
            </div>
        </div>
    </div>
    <div class="tab">
        <input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
        <label class="tab-label" for="tab-3">Schedule</label>

        <div class="tab-panel">
            <div class="tab-content">
                <h3>Schedule</h3>
                <?php require('include/index/Schedule.php'); ?>
            </div>
        </div>
    </div>
</div>

<?php
require("include/bot.php");
?>
