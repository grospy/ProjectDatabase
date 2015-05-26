<?php

if (isset($_POST['editCourseButton'])) {
	$courseID = $_POST['editCourseButton'];
	
	echo "$courseID";
	
	$courseNameSQL = "SELECT c.name, c.courseID, c.capacity, c.studyload, concat(p.firstName,' ',p.lastName) as instructor FROM course c INNER JOIN teacher te on te.courseID=c.courseID INNER JOIN person p ON p.personID=te.teacherID WHERE c.courseID='$courseID'";
	$result = $connection->query($courseNameSQL);
	$num_rows = mysqli_num_rows($result);
	if ($result) {
		if ($num_rows > 0) {
			for ($x = 0; $x < $num_rows; $x++) {
				$result->data_seek($x);
				$data = $result->fetch_array();
				$courseName = $data['name'];
				$courseID = $data['courseID'];
				$capacity = $data['capacity'];
				$studyload = $data['studyload'];
				$instructor = $data['instructor'];
			}
		}
	}	
	
}
?>
<form>
Course ID : 
<input type="text" value="<?php echo "$courseID" ?>" /><br/>
Course name :
<input type="text" value="<?php echo "$courseName" ?>" /><br/>
Student capacity:
<input type="number" value="<?php echo "$capacity" ?>" number"/><br/>
Study load :
<input type="number" value="<?php echo "$studyload" ?>"/><br/>
Instructor :
<input type="text"  value="<?php echo "$instructor" ?>"/><br/>



<input type='submit' name='saveCourse' value='Save changes'/>
<input type='submit' name='backToCourseList' value='Back'/>
</form>