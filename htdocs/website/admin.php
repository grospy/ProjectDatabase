<?PHP
session_start();
if ($_SESSION['login'] != md5("2")) {
    header("Location: login.php");
}
require('include/top.php');
require("include/database.php");

?>
<div class="dash">
    <img src="image/Inholland_logo.png" id="logotop">
    <div id="webtitle">
        International Business Innovation Studies
        <br/>Elective Courses Enrolment
    </div>

    <div id="welcome">
        Welcome Admin,
		<br/><span id="logout"><a href="logout.php">Log out</a></span>
    </div>
    <?php if(isset($_SESSION["message"])){echo $_SESSION["message"]; $_SESSION["message"] = "";} ?>
</div>



<div class="tabs">
	
	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-1" name="tab-group-1">
		<label class="tab-label" for="tab-1">Registration</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Registration</h3>
				<br/>Set registration date:
				<br/>Open from ... Close at ...
				<?php /* require('include/index_admin/Registration.php'); */ ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-2" name="tab-group-1" checked>
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
		<input class="tab-radio" type="radio" id="tab-3" name="tab-group-1">
		<label class="tab-label" for="tab-3">Edit Course</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Edit Course</h3>
				add course, delete course, edit course
				<?php /* require('include/index_admin/Course.php'); */ ?>
			</div>
		</div>
	</div>

	<div class="tab">
		<input class="tab-radio" type="radio" id="tab-4" name="tab-group-1">
		<label class="tab-label" for="tab-4">Student</label>

		<div class="tab-panel">
			<div class="tab-content">
				<h3>Student</h3>
				
				<?php require('include/index_admin/Student.php');  ?>
			</div>
		</div>
	</div>
	
	
	
</div>
	
<!--------------------------------------------------------------- -->
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
?>


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
