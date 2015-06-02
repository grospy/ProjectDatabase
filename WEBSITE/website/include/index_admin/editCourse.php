<?php
if (isset($_POST['editCourseButton'])) {
	$courseID = $_POST['editCourseButton'];		
	$courseNameSQL = "SELECT c.name, c.courseID, c.capacity, c.studyload, concat(p.firstName,' ',p.lastName) as instructor FROM course c INNER JOIN teacher te on te.courseID=c.courseID INNER JOIN person p ON p.personID=te.teacherID WHERE c.courseID='$courseID'";
	$result = $connection->query($courseNameSQL);
	$num_rows = mysqli_num_rows($result);
	if ($result) {
		if ($num_rows > 0) {
			for ($x = 0; $x < $num_rows; $x++) {
                $courseName = mysqli_result($result,$x,"name");
                $courseID = mysqli_result($result,$x,"courseID");
                $capacity = mysqli_result($result,$x,"capacity");
                $studyload = mysqli_result($result,$x,"studyload");
                $instructor = mysqli_result($result,$x,"instructor");
                $courseName = mysqli_result($result,$x,"name");
			}
		}
	}	
}
?>
<form name="editCourse" method="post" >
	<p> 
	Course ID :	<input type="text" name="newCourseID" value="<?php
		if (isset($_POST['saveCourse'])) {
			echo $_POST['newCourseID'];} 
		else { echo "$courseID";}
		?>" readonly/>
	</p>
	
	<p> Course name : <input type="text" name="newCourseName" size="50" value="<?php
		if (isset($_POST['saveCourse'])) {
			echo $_POST['newCourseName'];} 
		else { echo "$courseName";}
		?>" />
	</p>
	
	<p> Student capacity: <input type="text" name="newCapacity" value="<?php
		if (isset($_POST['saveCourse'])) {
			echo $_POST['newCapacity'];} 
		else { echo $capacity;}
		?>" />
	</p>
	
	<p> Study load : <input type="text" name="newStudyLoad" value="<?php
		if (isset($_POST['saveCourse'])) {
			echo $_POST['newStudyLoad'];} 
		else { echo $studyload;}
		?>"/>
	</p>
	
	<p> 
	Instructor : 
	<select name="newInstructor">
		<?php 
			$allTeacherSQL = "SELECT personID, CONCAT(firstName,' ',lastName) AS instructor FROM person WHERE type='teacher'";
			$result = $connection->query($allTeacherSQL);
			$num_rows = mysqli_num_rows($result);
			if ($result) {
				if ($num_rows > 0) {
					for ($x = 0; $x < $num_rows; $x++) {
						$result->data_seek($x);
						$data = $result->fetch_array();
						$allInstructor = $data['instructor'];
						$teacherID = $data['personID'];
						if ($allInstructor == $instructor ){
						echo "<option selected value='$teacherID'>$allInstructor</option>";
						} else {
							echo "<option  value='$teacherID'>$allInstructor</option>";
						}
					}
				}
			}
		?>
	</select>
	</p>

	<input type='submit' name='saveCourse' value='Save changes'/>
	<input type='submit' name='backToCourseList' value='Back'/> <?php saveEditedCourse() ?>
</form>