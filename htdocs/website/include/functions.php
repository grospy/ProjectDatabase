<?php
require("database.php");

//Security function; puts quotes around value
function quote_smart($handle, $value)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($handle, $value) . "'";
    }
    return $value;
}

//Checks login values to provide access to site
function login(&$error)
{
    $number = htmlspecialchars($_POST['password']);
    $password = htmlspecialchars($_POST['number']);
    if ($connection) {
        $number = quote_smart($connection, $number);
        $password = quote_smart($connection, $password);

        $SQL = "SELECT * FROM student WHERE student_number = $number AND password = md5($password)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $result->data_seek(0);
                $data = $result->fetch_array();
                $name = $data['first_name'];
                session_start();
                $_SESSION['login'] = md5("1");
                $_SESSION['name'] = $name;
                $_SESSION['number'] = $number;
                header("Location: index.php");
            } else {
                $error = "Invalid student number or password.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($connection);
    } else {
        $error = "Error connecting to database.";
    }

}

function popup($number, $courseID, $connection, $case)
{
    $text = "\n\t\t\t<div class='confirmation_message'>";
    $text .= "\n\t\t\t\t<h3 align='center'>Are you sure you want to " . ($case == 0 ? 'withdraw from' : 'enroll to') . "</h3>";
    if ($connection) {
        $courseNameSQL = "SELECT name FROM course WHERE courseid = '$courseID'";
        $resultCourseName = $connection->query($courseNameSQL);
        $resultCourseName->data_seek(0);
        $data = $resultCourseName->fetch_array();
        $courseName = $data['name'];
        $text .= "\n\t\t\t\t<div class='schedule_header'>\n\t\t\t\t\t<h1> $courseID - $courseName </h1>\n\t\t\t\t</div>";
    } else {
        return "Database error";
    }
    $text .= "\n\t\t\t\t<p id='overlap_message'>The course(s) below will be ".($case == 0 ? 'AVAILABLE' : 'UNAVAILABLE')." if you withdraw from this course :</p>\n\t\t\t\t<div class='overlap'>";

    if ($connection) {
        $SQLcheckoverlap = "select concat(courseID,' - ',name) as overlap from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID='$courseID') and le.courseID in (le.courseID='$courseID'));";
        $result = $connection->query($SQLcheckoverlap);
        $num_rows = mysqli_num_rows($result);
        if ($result) {
            if ($num_rows > 0) {
                $text .= "\t\t\t\t\t\t\t<ul>\n";
                for ($x = 0;
                     $x < $num_rows;
                     $x++) {
                    $result->data_seek($x);
                    $data = $result->fetch_array();
                    $text .= "\t\t\t\t\t\t\t\t<li>";
                    $text .= $data["overlap"];
                    $text .= "</li><br/>\n";
                }
                $text .= "\t\t\t\t\t\t\t</ul>\n";
            }
        } else {
            return "Database error";
        }
    }
    $text .= "\n\t\t\t\t</div>\n\t\t\t\t<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>\n\t\t\t\t\t<input type='submit' name='". ($case==0 ? 'delete':'enroll') . $courseID . "' class=".($case==0 ? 'withdraw':'enroll')." value='";

    if (isset($_POST["delete$courseID"])) {
        $withdrawSQL = "delete from enrolled_students where courseID='$courseID' and studentID= '$number';";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully withdrawn.";
            header("Location: index.php");
        }
    } else if ($case == 0){
        $text .= "Withdraw";
    }
    else if (isset($_POST["enroll$courseID"])) {
        $withdrawSQL = "insert into enrolled_students (courseID,studentID) values ('$courseID','$number');";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully enrolled.";
            header("Location: index.php");
        }
    } else if ($case == 1){
        $text .= "Enroll";
    }

    $text .= "'>\n\t\t\t\t</form>\n\t\t\t</div>";
    return $text;
}

function renamethisfunction($case, $result, $x, $number, $connection)
{
    $result->data_seek($x);
    $data = $result->fetch_array();

    $name = $data['name'];
    $capacity = $data['capacity'];
    $studyload = $data['studyload'];
    $courseID = $data['courseID'];


    $text = "<button class='";
    switch ($case) {
        case 0:
            $text .= "enroll'";
            break;
        case 1:
            $text .= "unavailable'";
            break;
        case 2:
            $text .= "withdraw'";
            break;
    }
    if ($case != 1) {
        $text .= " onclick = 'function1(" . '"';
        $text .= $courseID . '"';
        $text .= ")'";
    }
    $text .= ">";
    switch ($case) {
        case 0:
            $text .= "Enroll";
            break;
        case 1:
            $text .= "Unavailable";
            break;
        case 2:
            $text .= "Withdraw";
            break;
    }
    $text .= "</button>";

    if ($case != 1) {
        $text .= "\n\t\t\t\t<div id='light" . $courseID . "' class='white_content'>";
        switch ($case) {
            case 0:
                $text .= popup($number, $courseID, $connection,1);
                break;
            case 2:
                $text .= popup($number, $courseID, $connection,0);
                break;
        }
        $text .= "\n\t\t\t\t\t<button class = 'back' onclick = 'function2(" . '"';
        $text .= $courseID . '"';
        $text .= ")'>Cancel</button>\n\t\t\t\t</div>";
    }


    echo "\n\t\t    <tr class='";
    switch ($case) {
        case 0:
            echo "available";
            break;
        case 1:
            echo "unavailable";
            break;
        case 2:
            echo "enrolled";
            break;
    }
    echo "Row'>\n\t\t\t<td>$name</td>\n\t\t\t<td>$capacity</td>\n\t\t\t<td>$studyload</td>\n\t\t\t<td> $text\n\t\t\t</td>\n\t\t    </tr>";
}