<?PHP
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login.php");
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
		<input class="tab-radio" type="radio" id="tab-1" name="tab-group-1" value="1" <?php if (!isset($_POST['submit'])) echo "Checked"?>>
		<label class="tab-label" for="tab-1">Registration</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Registration</h3>
				<?php require('include/index_admin/Registration.php');  ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" value="2">
		<label class="tab-label" for="tab-2">Enrollment</label>
		
		<div class="tab-panel">
			<div class="tab-content">
				<h3>Enrollment</h3>
				<br/>see who enrolled for what
				<?php /* require('include/index_admin/Enrollment.php'); */ ?>
			</div>
		</div>
	</div>
	
	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-3" name="tab-group-1" value="3" >
		<label class="tab-label" for="tab-3">Edit Courses</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Edit Course</h3>
				add course, delete course, edit course
				<?php /* require('include/index_admin/Courses.php'); */ ?>
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
	
<!--------------------------------------------------------------- -->


<!--<section class="container">
    <div id="content">
        <h1>Welcome, admin</h1>
        <p><a href="addstudent.php">Add a student to the database</a> </p>
        <p>
            <a href="logout.php">Log out</a>
        </p>
    </div>
</section>	
	<div class="dash">
    <img src="image/Inholland_logo.png" id="logotop">
    <div id="webtitle">
        International Business Innovation Studies
        <br/>Elective Courses Enrolment
    </div>

    <div id="welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?>
        <br/>Registration deadline: 
		<br/><span id="logout"><a href="logout.php">Log out</a></span>
    </div>
    <?php if(isset($_SESSION["message"])){echo $_SESSION["message"]; $_SESSION["message"] = "";} ?>
</div> -->

<?php
require('include/bot.php');
