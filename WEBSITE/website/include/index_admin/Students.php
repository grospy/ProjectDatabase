<?php
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>
<div class="CSSTableGenerator">

    <button onclick='function1("Students")'>Show students</button>
    <?php echo showStudents()?>


    <h4>Upload a .csv file (for adding students): <button class="instructionButton" onclick='function1("StudentInstruction")'>instruction</button></h4>
	
    <form name="import" method="post" enctype="multipart/form-data">
        <input type="file" name="file"/><br/>
        <input type="submit" name="submit" value="Submit"/> <?php addStudents();?>
	</form>
   
    <br/>
    <br />
</div>

<div id='lightStudentInstruction' class='white_content'>
<img src="image/instruction_student.jpg" class="instructionImage"/>
 <button class='back' onclick='function2("StudentInstruction")'>Close</button>
</div>