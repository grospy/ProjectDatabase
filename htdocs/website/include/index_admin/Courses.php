<div class="CSSTableGenerator">

<?php 

//!!!!!*****create offer collumn first: alter table course add offer bit(1) not null default 1;


if (isset($_POST["offerCourse"]) && $connection) {
	if(!isset($_POST['courseForm'])) {
		echo("Please select some course.");
	} 
	else {
		$offeredCourse = $_POST['courseForm'];
		$allCourse = array();
		$courseIDSQL = "SELECT courseID FROM course";
		$result = $connection->query($courseIDSQL);
		$num_rows = mysqli_num_rows($result);
		if ($result) {
			if ($num_rows > 0) {
				for ($x = 0; $x < $num_rows; $x++) {
					$result->data_seek($x);
					$data = $result->fetch_array();
					$courseID = $data['courseID'];
					array_push($allCourse, "$courseID");
				}
			}
		}
		$text = "These course are opened : ";
		foreach ($allCourse as $acourse){
			if(in_array($acourse,$offeredCourse)){
				$text .= " $acourse .";
				$offerCourseSQL = "update course set offer=1 where courseID='$acourse'";
                $connection->query($offerCourseSQL); 
			}
			if(!(in_array($acourse,$offeredCourse))){
				$offerCourseSQL = "update course set offer=0 where courseID='$acourse'";
                $connection->query($offerCourseSQL); 
			}
		}
		echo "$text";	
	}		
}
?>
<table>
<form name="offerCourse" method="post">
<input type="submit" name="offerCourse" value ="Offer checked courses"/>
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
				
				$participantSQL = "select studentID from enrolled_students where courseID='$courseID'";
				$participantResult = $connection->query($participantSQL);
				$participant = mysqli_num_rows($participantResult);
				
				echo "<tr>
				<td>$courseName</td>
				<td>$participant</td>
				<td> <button >Edit</button>	</td>
				<td><input type='checkbox' name='courseForm[]' value='$courseID'></td></tr>";
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