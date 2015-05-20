<?PHP
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login.php");
}
require('include/top.php');
require('include/functions.php');
require("include/admin/dash.php");
?>




<div class="tabs">
	
	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-1" name="tab-group-1">
		<label class="tab-label" for="tab-1">Registration</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Registration</h3>
				<?php require('include/admin/Registration.php');  ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" checked>
		<label class="tab-label" for="tab-2">Enrollment</label>
		
		<div class="tab-panel">
			<div class="tab-content">
				<h3>Enrollment</h3>
                <?php require('include/admin/Enrollment.php');  ?>
			</div>
		</div>
	</div>
	
	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
		<label class="tab-label" for="tab-3">Edit Courses</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Edit Course</h3>
                <?php require('include/admin/Courses.php');  ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-4" name="tab-group-1">
		<label class="tab-label" for="tab-4">Student</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Student</h3>
                <?php require('include/admin/Students.php');  ?>
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
