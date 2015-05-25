<br/>Set registration date:

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
</p>
<input type="submit" name="submitRegDate"/>
</form>

<?php
addRegistrationDate()
?>
