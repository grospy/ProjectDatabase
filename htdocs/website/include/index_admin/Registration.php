<?php 
$registrationSQL = "select DATE_FORMAT(opendate, '%e-%b-%Y') as opendate, DATE_FORMAT(closedate, '%e-%b-%Y') as closedate from registration order by date(closedate) DESC limit 1";
$result = $connection->query($registrationSQL);
$num_rows = mysqli_num_rows($result);
if ($result) {
	for ($x = 0; $x < $num_rows; $x++) {
		$result->data_seek($x);
		$data = $result->fetch_array();
		$openDate = $data['opendate'];
		$closeDate = $data['closedate'];
	}
	$datenow = date('d-M-Y');
	if ($openDate<=$datenow && $closeDate>=$datenow) {
		echo "Registration is now opened from $openDate until $closeDate";
	} elseif ($openDate>$datenow || $closeDate<$datenow) {
		echo "Today is $datenow. Registration is now closed. Last registration entered is on $openDate until $closeDate";
	}	
}

?>
<br/><br/>
<hr/>
<h4>Set registration date:</h4>
<form name="regDateForm" method="post">
<p> For study year 
<select class="regdate" name="studyYear">
	<option> Year </option>
	<?php
	$currentYear = date("Y");
	for ($currentYear=date("Y")-1;$currentYear<date("Y")+2;$currentYear++) {
		echo "<option value='$currentYear'>$currentYear</option>";
	}
	?>
</select> 

, term 
<select class="regdate" name="term">
<option> Term </option>
	<option value="01">1</option>
	<option value="02">2</option>
	<option value="03">3</option>
	<option value="04">4</option>
</select>
</p>

<p>Open from 
<select class="regdate" name="openMonth">
	<option> Month </option>
	<?php
	$currentMonth = date("m");
	for ($currentMonth;$currentMonth<date("m")+2;$currentMonth++) {
		echo "<option value='$currentMonth'>".date('F',mktime(0, 0, 0, $currentMonth, 10))."</option>";
	}
	?>
	
</select>

<select class="regdate" name="openDay">
	<option> Day </option>
	<?php
	for ($numberOfDay =01; $numberOfDay<=31;$numberOfDay++) {
		echo "<option value='$numberOfDay'>$numberOfDay</option>";
	}
	?>
</select>

<select class="regdate" name="openYear">
	<option> Year </option>
	<?php
	$currentYear = date("Y");
	for ($currentYear=date("Y")-1;$currentYear<date("Y")+1;$currentYear++) {
		echo "<option value='$currentYear'>$currentYear</option>";
	}
	?>
</select> 
</p>

<p>
Close at 
<select class="regdate" name="closeMonth">
	<option> Month </option>
	<?php
	$currentMonth = date("m");
	for ($currentMonth;$currentMonth<date("m")+2;$currentMonth++) {
		echo "<option value='$currentMonth'>".date('F',mktime(0, 0, 0, $currentMonth, 10))."</option>";
	}
	?>
</select>

<select class="regdate" name="closeDay">
	<option> Day </option>
	<?php
	for ($numberOfDay =01; $numberOfDay<=31;$numberOfDay++) {
		echo "<option value='$numberOfDay'>$numberOfDay</option>";
	}
	?>
</select>

<select class="regdate" name="closeYear">
	<option> Year </option>
	<?php
	$currentYear = date("Y");
	for ($currentYear=date("Y")-1;$currentYear<date("Y")+1;$currentYear++) {
		echo "<option value='$currentYear'>$currentYear</option>";
	}
	?>
</select>

<p>
Type : <select class="regdate" name="regtype">
	<option> Type </option>
		<option value='first'>first</option>";
		<option value='second'>second</option>";
	</p>
</select>
</p>
<p>
Minimum study load : <input type='number' name='minRegStudyLoad' value='60'></input>
</p>
<input type="submit" name="submitRegDate" value="Submit registration date"/>
<?php addRegistrationDate();?>
</form>
<br/>
<hr/>

<h4> Filter student for registration :</h4>
<form name="filterStudentForm" method="post">
<p><input type='radio' name='allowedStudent' value='allStudent'>Open registration to all student</input></p>
<p><input type='radio' name='allowedStudent' value='noStudent'>Close registration to all student</input></p>
<p><input type='radio' name='allowedStudent' value='problemStudent'>Students whose credits less than</input>
<input type='number' name='minStudyLoad' value='60'></input></p>
<p><input type='radio' name='allowedStudent' value='manuallyStudent'>Manually open registration : </input></p>
<p><textarea name="addStudentID" rows="5" cols="40" placeholder="studentID, separate with comma"></textarea></p>
<input type="submit" name="filterStudent" value="Filter student"/>
<?php allowStudent();?>
</form>




