<?php
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}

if (isset($_POST['editStudent'])) {
    editStudent();
} else if (isset($_POST['edSt'])) {
    saveStudent();
} else if (isset($_POST['search'])) {
    echo showStudents($_POST["sQuery"]);
} else {
    students();
}

function students()
{
    echo "<form method='post'>
            <input type='text' name='sQuery' placeholder='Search Student'>
            <input type='submit' name='search' value='Search'>
        </form>";


    echo "<h4>Upload a .csv file (for adding students):
    <button class='instructionButton' onclick='function1(\"StudentInstruction\")'>instruction</button>
</h4>

<form name='import' method='post' enctype='multipart/form-data'>
    <input type='file' name='file'/><br/>
    <input type='submit' name='submit' value='Submit'/> ";
	 addStudents(); 
	 echo "
</form>

<br/>
<br/>
</div>

<div id='lightStudentInstruction' class='white_content'>
    <img src='image/instruction_student.jpg' class='instructionImage'/>
    <button class='back' onclick='function2(\"StudentInstruction\")'>Close</button>
</div>";


}

function editStudent()
{
    global $connection;
    $number = $_POST['editStudentNr'];
    $sql = "Select * from person p inner JOIN student s on p.personID = s.StudentID where p.personID = '$number'";
    $result = $connection->query($sql);

    $firstname = isset($_POST['edStNr']) ? $_POST['edStNr'] : mysqli_result($result, 0, 'firstName');
    $lastname = isset($_POST['edStNr']) ? $_POST['edStNr'] : mysqli_result($result, 0, 'lastName');;
    $email = isset($_POST['edStNr']) ? $_POST['edStNr'] : mysqli_result($result, 0, 'email');;

    echo "

    <form method='post'>
        Student Number:<br/>
        <input type='number' name='edStNr' value='$number' readonly><br />
        First Name:<br/>
        <input type='text' name='edStFn' value='$firstname'><br />
        Last Name:<br/>
        <input type='text' name='edStLn' value='$lastname'><br />
        Email:<br/>
        <input type='email' name='edStEm' value='$email'><br/>
        <input type='submit' name='edSt' value='Save'>






    ";
}

function saveStudent()
{
    global $connection;
    $number = $_POST['edStNr'];
    $firstname = $_POST['edStFn'];
    $lastname = $_POST['edStLn'];
    $email = $_POST['edStEm'];
    if (!$_POST['edStFn']) {
        editStudent();
        echo 'Enter first name.';
    } else if (!$_POST['edStLn']) {
        editStudent();
        echo 'Enter last name.';
    } else if (!$_POST['edStLn']) {
        editStudent();
        echo 'Enter email.';
    } else {
        $sql = "UPDATE person set firstName = '$firstname', lastName = '$lastname' where personID = '$number'";
        if ($connection->query($sql)) {
            $sql = "update student set email = '$email' where studentId = '$number'";
            if ($connection->query($sql)) {
                $_SESSION["tab"] = "S";
                header("Location: admin.php");
                exit();
            } else {
                echo $connection->error;
            }
        } else {
            echo $connection->error;
        }
    }
}
