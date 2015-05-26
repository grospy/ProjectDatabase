<?PHP
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login_admin.php");
}
require('include/top.php');
require('include/functions.php');
require("include/database.php");

?>
<div class="dash">
    <?php require("include/index_admin/dash.php"); ?>
</div>

<div class="creditmsg">
</div>

<div class="tabs">
	
	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-1" name="tab-group-1" value="1" <?php if (isset($_POST['submitRegDate']) || isset($_POST['filterStudent'])) echo "Checked"?>>
		<label class="tab-label" for="tab-1">Registration</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Registration</h3>
				<?php require('include/index_admin/Registration.php');  ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-3" name="tab-group-1" value="3" <?php if (isset($_POST['offerCourse']) || isset($_POST['editCourseButton']) || isset($_POST['backToCourseList']) || isset($_POST['saveCourse']) || isset($_POST['Un_CheckAll']) || (!isset($_POST['submitRegDate']) && !isset($_POST['filterStudent']))){echo "Checked";}?>>
		<label class="tab-label" for="tab-3">Edit Courses</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Edit Course</h3>
				<?php 
					//require('include/index_admin/Courses.php');
					if (isset($_POST['editCourseButton'])) {
						require('include/index_admin/editCourse.php');
					}else if (isset($_POST['backToCourseList'])) {
						require('include/index_admin/Courses.php');
					}else {
						require('include/index_admin/Courses.php');
					}
					
				?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-4" name="tab-group-1" value="4" <?php if (isset($_POST['submit'])) echo "Checked"?>>
		<label class="tab-label" for="tab-4">Students</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Student</h3>
				<?php require('include/index_admin/Students.php');  ?>
			</div>
		</div>
	</div>
	
	
	
</div>
<?php
require('include/bot.php');
