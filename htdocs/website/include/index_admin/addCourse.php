<form name="editCourse" method="post" >
<p> Course ID :
<input type="text" name="newCourseID" readonly value="
<?php
if (isset($_POST['addCourse'])) {
	echo "";} elseif (isset($_POST['clearfield'])) {
	echo "";} 
if (isset($_POST['generateNumber'])) { 
	$sql = "SELECT courseID FROM course ORDER BY courseID DESC limit 1";
	$result = $connection->query($sql);
	$row=mysqli_fetch_row($result);
	$lastCourseNumber = substr("$row[0]",4);
	$newCourseNumber = $lastCourseNumber+1;
	if(strlen($newCourseNumber)==1) {
		$newCourseNumber="00".$newCourseNumber;
	} elseif(strlen($newCourseNumber)==2) {
		$newCourseNumber="0".$newCourseNumber;
	} else{}
		$courseID = "IBIS".$newCourseNumber;
	echo $courseID;
}
?>" />
</p>
<p> Course name : <input type="text" name="newCourseName" size="50" value="
<?php
if (isset($_POST['addCourse'])) {
	echo $_POST['newCourseName'];} 
else { echo "";}
?>" /></p>
<p> Student capacity: <input type="text" name="newCapacity" value="
<?php 
if (isset($_POST['addCourse'])) {
	echo $_POST['newCapacity'];} 
else { echo "";}
?>" /></p>
<p> Study load : <input type="text" name="newStudyLoad" value="
<?php 
if (isset($_POST['addCourse'])) {
	echo $_POST['newStudyLoad'];} 
else { echo "";}
?>"/></p>

<p> Instructor : 
<select name="newInstructor">
<option value="" disabled selected></option>
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
				echo "<option  value='$teacherID'>$allInstructor</option>";
				}
			}
		}
?>
</select>
</p>

<input type='submit' name='generateNumber' value='Generate New Course Number'/>
<input type='submit' name='refresh' value='Clear Field'/>
<input type='submit' name='addCourse' value='Add New Course'/> <?php addNewCourse(); ?>
</form>
<br/>
<hr/>
<p>
<h4>Upload a .csv file : </h4>
<form name="import" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/><br/>
    <input type="submit" name="submit2" value="Submit"/><?php addCourseCSV(); ?>
</form>
</p> 
   
<?php
function addNewCourse(){
	global $connection;
	if (isset($_POST['addCourse'])){
		if (empty($_POST['newCourseName']) || empty($_POST['newCapacity']) || empty($_POST['newStudyLoad']) ||  empty($_POST['newInstructor']) ){
		echo "cant be empty";
		} else {
		$newCourseID = $_POST['newCourseID'];
		$newCourseName = $_POST['newCourseName'];
		$newCapacity = $_POST['newCapacity'];
		$newStudyLoad = $_POST['newStudyLoad'];
		$newInstructor = $_POST['newInstructor'];
		echo "$newInstructor";
		$addCourseSQL = "insert into course value ('$newCourseID', '$newCourseName',$newCapacity,$newStudyLoad, 0);";
		$addTeacherSQL = "insert into teacher (teacherID, courseID) value ('$newInstructor', '$newCourseID');";
		if ($connection->query($addCourseSQL) === TRUE  && $connection->query($newInstructor) === TRUE  ) {
				echo "$newCourseID";
			} //insert teacher still has problem
			else {
				echo $connection->error;
			}
		}
	}
}
?>

