<form name="editCourse" method="post" >
	<p> 
	Course ID :	<input type="text" name="newCourseID" readonly  value="
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
	
	<p> 
	Course name : <input type="text" name="newCourseName" size="50" value="
		<?php
		if (isset($_POST['addCourse'])) {
			echo $_POST['newCourseName'];} 
		else { echo "";}
		?>" />
	</p>
	
	<p> 
	Student capacity: <input type="text" name="newCapacity" value="
		<?php 
		if (isset($_POST['addCourse'])) {
			echo $_POST['newCapacity'];} 
		else { echo "";}
		?>" />
	</p>
	
	<p> 
	Study load : <input type="text" name="newStudyLoad" value="
		<?php 
		if (isset($_POST['addCourse'])) {
			echo $_POST['newStudyLoad'];} 
		else { echo "";}
		?>"/>
	</p>

	<p> 
	Instructor : 
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
	<h4>Upload a .csv file (for course): 
		<button class="instructionButton" onclick='function1("CourseInstruction")'>
			instruction
		</button>
	</h4>
	<form name="import" method="post" enctype="multipart/form-data">
		<input type="file" name="file"/><br/>
		<input type="submit" name="submitCourseCSV" value="Submit"/><?php addCourseCSV(); ?>
	</form>
</p> 

<br/>
<hr/>

<p>
	<h4>Upload a .csv file (for lesson): 
		<button class="instructionButton" onclick='function1("LessonInstruction")'>
			instruction
		</button>
	</h4>
	<form name="import" method="post" enctype="multipart/form-data">
		<input type="file" name="file"/><br/>
		<input type="submit" name="submitLessonCSV" value="Submit"/> <?php  addLessonCSV();  ?>
	</form>
</p>

<div id='lightCourseInstruction' class='white_content'>
	<img src="image/instruction_course.jpg" class="instructionImage"/>
	<button class='back' onclick='function2("CourseInstruction")'>Close</button>
</div>

<div id='lightLessonInstruction' class='white_content'>
	<img src="image/instruction_lesson.jpg" class="instructionImage"/>
	<button class='back' onclick='function2("LessonInstruction")'>Close</button>
</div>