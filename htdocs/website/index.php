<?PHP
session_start();
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}
include_once "include/top.php";
?>

<div class="dash">
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['name'].".") ?></p>
    <!--<p>Registration deadline:</p>-->
    <!--<p>Credits:?></p>-->
    <p><a href="logout.php">Log out</a></p>

</div>
<section class="container2">
    <div class="tabs">

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-1" name="tab-group-1" checked>
            <label class="tab-label" for="tab-1">Grades</label>
            <div class="tab-panel">
                <div class="tab-content">
                    <?php include 'include/student/grades.php';?>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-2" name="tab-group-1">
            <label class="tab-label" for="tab-2">Enroll</label>

            <div class="tab-panel">
                <div class="tab-content">
                    //CONTENT
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
            <label class="tab-label" for="tab-3">My Courses</label>

            <div class="tab-panel">
                <div class="tab-content">
                    //CONTENT
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-4" name="tab-group-1">
            <label class="tab-label" for="tab-4">Course Description</label>

            <div class="tab-panel">
                <div class="tab-content">
                    //CONTENT
                </div>
            </div>
        </div>

    </div>
</section>

<?php include_once "include/bot.php"; ?>
