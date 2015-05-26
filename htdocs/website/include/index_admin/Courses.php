<div class="CSSTableGenerator">


<table>
<form name="offerCourse" method="post">
<input type="submit" name="offerCourse" value ="Offer checked courses"/>
<input type="button" name="Check_All" value="Check All" onClick="CheckAll()">
<input type="button" name="Un_CheckAll" value="Uncheck All" onClick="UnCheckAll()">

<?php 
if (isset($_POST["offerCourse"]) && $connection) {
	if(!isset($_POST['courseForm'])) {
		$closeAllCourseSQL = "update course set offer=0";
        $connection->query($closeAllCourseSQL);
		echo "All course is now closed.";
	} 
	else {
		$offeredCourse = $_POST['courseForm'];
		$closeAllCourseSQL = "update course set offer=0";
        $connection->query($closeAllCourseSQL);
		
		$text = "These course are opened : ";
		foreach ($offeredCourse as $acourse){
				$text .= " $acourse .";
				$offerCourseSQL = "update course set offer=1 where courseID='$acourse'";
                $connection->query($offerCourseSQL); 
		}
		echo "$text";	
	}		
}	
?>

<tr>
	<td>Course</td>
	<td>Participants</td>
	<td>Edit</td>
	<td>Offer</td>
</tr>

<?php 
if ($connection) {
	$courseNameSQL = "SELECT name, courseID FROM course order by courseID";
	$result = $connection->query($courseNameSQL);
	$num_rows = mysqli_num_rows($result);
	if ($result) {
		if ($num_rows > 0) {
			for ($x = 0; $x < $num_rows; $x++) {
				$result->data_seek($x);
				$data = $result->fetch_array();
				$courseName = $data['name'];
				$courseID = $data['courseID'];
				
				$participantSQL = "select studentID from enrolledstudent where courseID='$courseID'";
				$participantResult = $connection->query($participantSQL);
				$participant = mysqli_num_rows($participantResult);
				
				echo "<tr>
				<td>$courseName</td>
				<td>$participant</td>
				<td> <input type='submit' name='editCourseButton' value='$courseID'/>	</td>
				<td><input type='checkbox' name='courseForm[]' class='courseForm' value='$courseID'></td></tr>";
			}
		}
	} else {
		echo "Database error";
	}
}
 ?>
 </form>
 </table>
 </div>