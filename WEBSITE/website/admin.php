<?PHP
ob_start();
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login_admin.php");
    exit();
}
require('include/top.php');
require('include/functions.php');
runCheck();
require("include/database.php");

?>
    <div class="dash">
        <?php require("include/index_admin/dash.php"); ?>
    </div>

    <div class="creditmsg">
    </div>

    <div class="tabs">

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-1" name="tab-group-1" value="1" <?php if (tabSelect() == 0) {
                echo "Checked";
            }?>>
            <label class="tab-label" for="tab-1">Registration</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Registration</h3>
                    <?php require('include/index_admin/Registration.php'); ?>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-3" name="tab-group-1" value="3" <?php if (tabSelect() == 1) {
                echo "Checked";
            } ?>>
            <label class="tab-label" for="tab-3">Edit Courses</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Edit Course</h3>
                    <?php
                    //require('include/index_admin/Courses.php');
                    if (isset($_POST['editCourseButton'])) {
                        require('include/index_admin/editCourse.php');
                    } else if (isset($_POST['saveCourse'])) {
                        require('include/index_admin/editCourse.php');
                    } else if (isset($_POST['backToCourseList'])) {
                        require('include/index_admin/Courses.php');
                    } else {
                        require('include/index_admin/Courses.php');
                    }

                    ?>
                </div>
            </div>
        </div>

        <div class="tab">generateNumber
            <input class="tab-radio" type="radio" id="tab-4" name="tab-group-1" value="4" <?php if (tabSelect() == 2) {
                echo "Checked";
            } ?>>
            <label class="tab-label" for="tab-4">Add Course</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Add Course</h3>
                    <?php require('include/index_admin/addCourse.php'); ?>
                </div>
            </div>
        </div>

        <div class="tab">
            <input class="tab-radio" type="radio" id="tab-5" name="tab-group-1" value="5" <?php if (tabSelect() == 3) {
                echo "Checked";
            }
            $_SESSION['tab'] = 'none';?>>
            <label class="tab-label" for="tab-5">Students</label>

            <div class="tab-panel">
                <div class="tab-content">
                    <h3>Students</h3>
                    <?php require('include/index_admin/Students.php'); ?>
                </div>
            </div>
        </div>


    </div>
<?php
require('include/bot.php');