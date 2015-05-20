<?php

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

function login(&$error)
{
    $password = $_POST['password'];
    $number = $_POST['number'];
    $number = htmlspecialchars($number);
    $password = htmlspecialchars($password);

    require("database.php");

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

function enroll($number, $courseID, $connection)
{
    $text = "<div class='confirmation_message'>";
    $text .= "<h3 align='center'>Are you sure to enroll to : </h3>";
    if ($connection) {
        $courseNameSQL = "SELECT name FROM course WHERE courseid = '$courseID'";
        $resultCourseName = $connection->query($courseNameSQL);
        $resultCourseName->data_seek(0);
        $data = $resultCourseName->fetch_array();
        $courseName = $data['name'];
        $text .= "<div class='schedule_header'><h1> $courseID - $courseName </h1></div>";
    } else {
        return "Database error";
    }
    $text .= "<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you take this course :</p>

    <div class='overlap'>";

    if ($connection) {
        $SQLcheckoverlap = "select concat(courseID,' - ',name) as overlap from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID='$courseID') and le.courseID in (le.courseID='$courseID'));";
        $result = $connection->query($SQLcheckoverlap);
        $num_rows = mysqli_num_rows($result);
        if ($result) {
            if ($num_rows > 0) {
                $text .= "<ul>";
                for ($x = 0;
                     $x < $num_rows;
                     $x++) {
                    $result->data_seek($x);
                    $data = $result->fetch_array();
//=============================
                    $overlap = $data['overlap'];
//=============================
                    $text .= "$overlap <br/>";
                }
                $text .= "</ul>";
            }
        } else {
            return "Database error";
        }
    }
    $text .= "</div><form action='" . $_SERVER['PHP_SELF'] . "' method='post'><input type='submit' name='enroll" . $courseID . "' class='back' value='";

    if (isset($_POST["enroll$courseID"])) {
        $withdrawSQL = "insert into enrolled_students (courseID,studentID) values ('$courseID','$number');";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "<p class='error'>Successfully enrolled.</p>";
            header("Location: index.php");
        }
    } else {
        $text .= "Enroll";
    }

    $text .= "'></form></div>";
    return $text;
}

function withdraw($number, $courseID, $connection)
{
    $text = "<div class='confirmation_message'>";
    $text .= "<h3 align='center'>Are you sure to withdraw from : </h3>";
    if ($connection) {
        $courseNameSQL = "SELECT name FROM course WHERE courseid = '$courseID'";
        $resultCourseName = $connection->query($courseNameSQL);
        $resultCourseName->data_seek(0);
        $data = $resultCourseName->fetch_array();
        $courseName = $data['name'];
        $text .= "<div class='schedule_header'><h1> $courseID - $courseName </h1></div>";
    } else {
        return "Database error";
    }
    $text .= "<p id='overlap_message'>The course(s) below will be AVAILABLE if you withdraw from this course :</p>

    <div class='overlap'>";

    if ($connection) {
        $SQLcheckoverlap = "select concat(courseID,' - ',name) as overlap from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID='$courseID') and le.courseID in (le.courseID='$courseID'));";
        $result = $connection->query($SQLcheckoverlap);
        $num_rows = mysqli_num_rows($result);
        if ($result) {
            if ($num_rows > 0) {
                for ($x = 0;
                     $x < $num_rows;
                     $x++) {
                    $result->data_seek($x);
                    $data = $result->fetch_array();
//=============================
                    $overlap = $data['overlap'];
//=============================
                    $text .= "$overlap <br/>";
                }
            }
        } else {
            return "Database error";
        }
    }
    $text .= "</div><form action='" . $_SERVER['PHP_SELF'] . "' method='post'><input type='submit' name='delete" . $courseID . "' class='back' value='";

    if (isset($_POST["delete$courseID"])) {
        $withdrawSQL = "delete from enrolled_students where courseID='$courseID' and studentID= '$number';";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "<p class='error'>Successfully withdrawn.</p>";
            header("Location: index.php");
        }
    } else {
        $text .= "Withdraw";
    }

    $text .= "'></form></div>";
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
        $text .= "<div id='light" . $courseID . "' class='white_content'>";
        switch ($case) {
            case 0:
                $text .= enroll($number, $courseID, $connection);
                break;
            case 2:
                $text .= withdraw($number, $courseID, $connection);
                break;
        }
        $text .= "<button class = 'back' onclick = 'function2(" . '"';
        $text .= $courseID . '"';
        $text .= ")'>Cancel</button></div>";
        $text .= "<div id='fade' class='black_overlay'></div>";

    }


    echo "<tr class='";
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
    echo "Row'><td>$name</td> <td>$capacity</td> <td>$studyload</td> <td>$text</td></tr>";
}