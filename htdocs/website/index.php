<?PHP
session_start();
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}
require("include/top.php");
?>
<!--------------------------------------------------------------- -->
<div class="dash">
    <img src="image/Inholland_logo.png" id="logotop">
    <div id="webtitle">
        International Business Innovation Studies
        </br>Elective Courses Enrolment 
    </div>
     
    <div id="welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?>
        <br/>Registration deadline: 
		<br/><span id="logout"><a href="logout.php">Log out</a></span>
    </div>    
</div>



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
	
	<div class="creditmsg">
	<?php
		$number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);
            $SQL = "select sum(c.studyload) as total from course c inner join enrolled_students en on c.courseID=en.courseID where en.studentID=$number";

			$result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
						$total = $data['total'];
						echo "You have enrolled ".$total." out of 60 credits";
					}
			}
		}
	?>
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

require("include/bot.php");
?>
