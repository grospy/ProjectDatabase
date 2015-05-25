<?php
require('database.php');
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
    require("database.php");
    $password = htmlspecialchars($_POST['password']);
    $number = htmlspecialchars($_POST['number']);
    if ($connection) {
        $number = quote_smart($connection, $number);
        $password = quote_smart($connection, $password);

        $SQL = "SELECT * FROM student s inner join person p on p.personID = s.studentID WHERE s.studentID = $number AND s.password = md5($password)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $result->data_seek(0);
                $data = $result->fetch_array();
                $name = $data['firstName'];
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


//Sets password
function set(&$error)
{
    require("include/database.php");
    $number = $_POST["number"];
    $code = $_POST["code"];
    $password = $_POST["password"];

    if ($connection) {
        $number = quote_smart($connection, $number);
        $code = quote_smart($connection, $code);
        $password = quote_smart($connection, $password);


        $SQL = "SELECT * FROM student WHERE studentID = $number";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $result->data_seek(0);
                $data = $result->fetch_array();
                $connection_code = $data['set_code'];
                $connection_pass = $data['password'];
                $connection_sent = $data['sent'] + 1;
                $connection_code = quote_smart($connection, $connection_code);

                if ($connection_code != $code || $code == "'NOCODE'") {
                    $error = "Invalid registration code.";
                } else {
                    $connection->query("UPDATE student SET password = md5($password) WHERE studentID = $number");
                    $connection->query("UPDATE student SET sent = $connection_sent WHERE studentID = $number");
                    $_SESSION['reg'] = md5("y");
                    $_SESSION['number'] = $number;
                    header("Location: index.php");
                }
            } else {
                $error = "Student number not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysqli_close($connection);
    } else {
        $error = "Error connecting to database.";
    }

}

//Sends mail
function send(&$error)
{
    require('functions.php');
    $email = $_POST['email'];

    $connection_handle = mysql_connect($server, $user_name, $pass_word);
    $connection_found = mysql_select_db($database, $connection_handle);

    if ($connection_found) {
        $email = quote_smart($connection_handle, $email);

        $SQL = "SELECT * FROM student WHERE email = $email";
        $result = mysql_query($SQL);
        $num_rows = mysql_num_rows($result);


        if ($result) {
            if ($num_rows > 0) {
                $password = mysql_result($result, 0, "password");
                $sent = mysql_result($result, 0, "sent");
                if ($sent < 500) {
                    $error = $password;
                    $sent++;
                    mysql_query("UPDATE student SET sent = $sent WHERE email =$email");
                } else {
                    $error = "Maximum requests exceeded(5).";
                }


                echo $password;


            } else {
                $error = "Email not found.";
            }
        } else {
            $error = "Query error.";
        }
        mysql_close($connection_handle);
    } else {
        $error = "Error connecting to database.";
    }

}

//make code to send
function getcode(&$error)
{
    require("include/database.php");
    $number = $_POST['number'];

    if ($connection) {
        $number = quote_smart($connection, $number);

        $SQL = "SELECT * FROM student WHERE studentID = $number";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);
        $result->data_seek(0);
        $data = $result->fetch_array();
        $limit = $data['sent'];

        if ($result && $limit < 5) {
            if ($num_rows > 0) {
                $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                $code = "";
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < 8; $i++) {
                    $n = substr($alphabet, rand(0, $alphaLength), 1);
                    $code .= $n;
                }
                $connection->query("UPDATE student SET set_code = '$code' WHERE studentID = $number");
                sendmail($code);
                session_start();
                $_SESSION['number'] = $number;
                $_SESSION['login'] = md5("3");
                header("Location: setpassword.php");

            } else {
                $error = "Student number not found.";
            }
        } else {
            if ($limit >= 5) {
                $error = "Email limit (5) reached. Contact a administrator.";
            } else {
                $error = "Query error.";
            }
        }
        mysqli_close($connection);
    } else {
        $error = "Error connecting to database.";
    }

}

//sends email
function sendmail($code)
{
    include 'PHPMailer/class.phpmailer.php';
    include("PHPMailer/class.smtp.php");

    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "registeramadeus@gmail.com";
    $mail->Password = "Amadeus1";
    $mail->SetFrom("registeramadeus@gmail.com");
    $mail->Subject = "Registration code";
    $mail->Body = "Use this code to finish registration: $code";
    $mail->AddAddress($_POST["number"] . "@student.inholland.nl");
    if (!$mail->Send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "sent";
    }
}

//Add students with cvs file
function addStudents()
{
    require('database.php');
    if (isset($_POST["submit"])) {
        $filecheck = basename($_FILES['file']['name']);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
        if (!($ext == "csv")) {
            echo "file must be csv type";
        } else {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $handle = fopen($file, "r");
            if ($handle !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $studentID = $data[0];
                    $first_name = $data[1];
                    $last_name = $data[2];
                    $email = $studentID . "@student.inholland.nl";
                    $sql = "INSERT INTO student (studentID, first_name, last_name, email) VALUES ('$studentID','$first_name','$last_name','$email')";
                    if ($connection->query($sql)) {
                        echo "Succeed adding $studentID, $first_name, $last_name! <br/>";
                    } else {
                        echo "<br/>" . $connection->error;
                    }
                }
                fclose($handle);
            }
        }
    }
}

//Set registration date
function addRegistrationDate()
{
    require('database.php');
    if (isset($_POST["submitRegDate"])) {
        $studyYear = $_POST["studyYear"];
        $term = $_POST["term"];

        $today = date("Y-m-d");

        $openDay = $_POST["openDay"];
        $openMonth = $_POST["openMonth"];
        $openYear = $_POST["openYear"];
        $openDate = "$openYear-$openMonth-$openDay";

        $closeDay = $_POST["closeDay"];
        $closeMonth = $_POST["closeMonth"];
        $closeYear = $_POST["closeYear"];
        $closeDate = "$closeYear-$closeMonth-$closeDay";

        if (!($openDay == "Day" || $openMonth == "Month" || $openYear == "Year" || $closeDay == "Day" || $closeMonth == "Month" || $closeYear == "Year")) {
            if (($openDate > $today) && (($closeDate > $today) && ($closeDate > $openDate))) {
                require('include/database.php');
                $openDateSQL = "insert into registration (year, term, openRegDate, closeRegDate) values ($studyYear, $term,'$openYear-$openMonth-$openDay', '$closeYear-$closeMonth-$closeDay')";
                if ($connection->query($openDateSQL) === TRUE) {
                    echo "<br/>Succeed adding registration date for study year $studyYear term $term
<br/>open date : $openYear-$openMonth-$openDay
<br/>close date : $closeYear-$closeMonth-$closeDay";
                } else {
                    echo "<br/>" . $connection->error;
                }
            } else {
                echo "date error. select open date after today. select close date after open date.";
            }
        } else {
            echo "all day, month and year field must be filled.";
        }
    }
}

function allowStudent()
{
    //add alter table student add allowToReg bit(1) not null default 0;
    require('database.php');
    if (isset($_POST["submitRegDate"])) {
        $selected_radio = $_POST['allowedStudent'];
        $minStudyLoad = $_POST['minStudyLoad'];

        switch ($_POST['allowedStudent']) {
            case 'allStudent':
                echo "all";
                $SQL = "update student set allowToReg=1";
                if ($connection->query($SQL) === TRUE)
                    break;

            case 'noStudent':
                echo "no";
                $SQL = "update student set allowToReg=0";
                if ($connection->query($SQL) === TRUE)
                    break;

            case 'problemStudent':
                echo "some";
                $problemStudent = array();
                $problemStudentSQL = "select s.studentID as studentID,sum(c.studyload) from course c inner join enrolledstudent e on c.courseID=e.courseID right join student s on e.studentID=s.studentID group by studentID having sum(c.studyload)<90 or sum(c.studyload) is null;";
                $result = $connection->query($problemStudentSQL);
                $num_rows = mysqli_num_rows($result);
                if ($result) {
                    if ($num_rows > 0) {
                        for ($x = 0; $x < $num_rows; $x++) {
                            $result->data_seek($x);
                            $data = $result->fetch_array();
                            $studentID = $data['studentID'];
                            array_push($problemStudent, "$studentID");
                        }
                    }
                }
                $allStudent = array();
                $allStudentSQL = "select studentID from student;";
                $result = $connection->query($allStudentSQL);
                $num_rows = mysqli_num_rows($result);
                if ($result) {
                    if ($num_rows > 0) {
                        for ($x = 0; $x < $num_rows; $x++) {
                            $result->data_seek($x);
                            $data = $result->fetch_array();
                            $studentID = $data['studentID'];
                            array_push($allStudent, "$studentID");
                        }
                    }
                }

                foreach ($allStudent as $aStudent) {
                    if (in_array($aStudent, $problemStudent)) {
                        $reEnrolStudent = "update student set allowToReg=1 where studentID='$aStudent'";
                        $connection->query($reEnrolStudent);
                    }
                    if (!(in_array($aStudent, $problemStudent))) {
                        $noEnrolStudent = "update student set allowToReg=0 where studentID='$aStudent'";
                        $connection->query($noEnrolStudent);
                    }
                }
                echo($allStudent[0]);
                break;


        }


    }
}

//All students into table
function showStudents()
{
    require('include/database.php');
    $return = "
<div id='lightStudents' class='white_content'>
    <div class=\"CSSTableGenerator\">
        <table>
            <tr>
                <td>
                    Name
                </td>
                <td>
                    ID
                </td>
            </tr>
            ";
    if ($connection) {
        $SQL = "SELECT * FROM student;";
        $result = $connection->query($SQL);
        $rows = mysqli_num_rows($result);
        //for sorting
        /* $results = array();
        while ($row = mysqli_fetch_array($result)) {
        $results[] = $row['courseID'];
        }*/
        for ($x = 0; $x < $rows; $x++) {
            $result->data_seek($x);
            $data = $result->fetch_array();
            $name = $data['first_name'];
            $name2 = $data['last_name'];
            $number = $data['studentID'];
            $return .= "
            <tr>
                <td>$name" . " " . "$name2</td>
                <td>$number</td>
            </tr>
            ";
        }
    } else {
        $return .= "Database error";
    }
    $return .= "
        </table>
    </div>
    <button class='back' onclick='function2(\"Students\")'>Close</button>
</div>";
    return $return;
}



//Get courses
function courses()
{
    global $connection;
    $number = $_SESSION['number'];
    $number = htmlspecialchars($number);

    if ($connection) {
        $number = quote_smart($connection, $number);

        //ALL
        $SQL = "SELECT * FROM course ORDER by courseID;";
        $resultALL = $connection->query($SQL);
        $all = array();
        $rows = mysqli_num_rows($resultALL);
        while ($row = mysqli_fetch_array($resultALL)) {
            $all[] = $row['courseID'];
        }
        //OFFERED
        $SQL = "SELECT * FROM course WHERE offer = '1';";
        $result = $connection->query($SQL);
        $offered = array();
        while ($row = mysqli_fetch_array($result)) {
            $offered[] = $row['courseID'];
        }
        //ENROLLED
        $SQL = "SELECT * FROM course c INNER JOIN enrolledstudent e on c.courseID = e.courseID where e.studentID = $number;";
        $result = $connection->query($SQL);
        $enrolled = array();
        while ($row = mysqli_fetch_array($result)) {
            $enrolled[] = $row['courseID'];
        }
        //OVERLAP
        $SQL = "select * from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolledstudent where studentID='$number'))) and courseID not in (select courseID from enrolledstudent where studentID='$number');";
        $result = $connection->query($SQL);
        $overlap = array();
        while ($row = mysqli_fetch_array($result)) {
            $overlap[] = $row['courseID'];
        }
        /*        //FULL
                $SQL = "Select * from course where (SELECT count(*) as enrolled from course c inner join enrolledstudent en on c.courseID = en.courseID where c.courseID = '$all[$x]';) >= capacity and courseID = '$all[$x]';";
                $result = $connection->query($SQL);
                $full = array();
                while ($row = mysqli_fetch_array($result)) {
                    $full[] = $row['courseID'];
                }*/
        /*        //OFFERED
                $SQL = "SELECT * FROM course where offered = yes;";
                $result = $connection->query($SQL);
                $offered = array();
                while ($row = mysqli_fetch_array($result)) {
                    $offered[] = $row['courseID'];
                }*/

        /*        //REQUIREMENTS
                $SQL = "SELECT * FROM course ORDER by courseID;";
                $result = $connection->query($SQL);
                $requirements = array();
                while ($row = mysqli_fetch_array($result)) {
                    $requirements[] = $row['courseID'];
                }*/

        for ($x = 0; $x < $rows; $x++) {


            if (in_array($all[$x], $offered)) {
                if (!in_array($all[$x], $enrolled)) {
                    if (!in_array($all[$x], $overlap)) {
                        if (!full($all[$x])) {
                            courseRow(0, $resultALL, $x, $number, $connection);
                        }else{
                            courseRow(3, $resultALL, $x, $number, $connection);
                        }
                    } else {
                        courseRow(1, $resultALL, $x, $number, $connection);
                    }
                } else {
                    courseRow(2, $resultALL, $x, $number, $connection);
                }


            } else {
                //THIS CLASS IS NOT OFFERED!
            }
        }
    } else {
        echo "Database error";
    }
}

//Returns courses in a table
function courseRow($case, $result, $x, $number, $connection)
{
    $result->data_seek($x);
    $data = $result->fetch_array();

    $name = $data['name'];
    $capacity = $data['capacity'];
    $studyload = $data['studyload'];
    $courseID = $data['courseID'];


    $text = "
<button class='";
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
        case 3:
            $text .= "full'";
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
        case 3:
            $text .= "Full";
            break;
    }
    $text .= "</button>";

    if ($case != 1) {
        $text .= "\n\t\t\t\t
<div id='light" . $courseID . "' class='white_content'>";
        switch ($case) {
            case 0:
                $text .= popup($number, $courseID, $connection, 1);
                break;
            case 2:
                $text .= popup($number, $courseID, $connection, 0);
                break;
            case 3:
                $text .= popup($number, $courseID, $connection, 2);
                break;
        }
        $text .= "\n\t\t\t\t\t
    <button class='back' onclick='function2(" . '
    "';
        $text .= $courseID . '"';
        $text .= ")'>Cancel</button>\n\t\t\t\t
</div>";
    }


    echo "\n\t\t
<tr class='";
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
        case 3:
            echo "full";
            break;
    }
    echo "Row'>\n\t\t\t
    <td>$name</td>
    \n\t\t\t
    <td>$capacity</td>
    \n\t\t\t
    <td>$studyload</td>
    \n\t\t\t
    <td> $text\n\t\t\t</td>
    \n\t\t
</tr>";
}
//Withdraw/Enroll confirmation
function popup($number, $courseID, $connection, $case)
{
    // 0 - withdraw
    // 1 - enroll
    // 2 - FULL
    $text = "\n\t\t\t<div class='confirmation_message'>";
    if ($case != 2) {
        $text .= "\n\t\t\t\t<h3 align='center'>Are you sure you want to " . ($case == 0 ? 'withdraw from' : 'enroll to') . "</h3>";
    } else {
        $text .= "Sorry, this class is full.";
    }
    if ($connection) {
        $courseNameSQL = "SELECT name FROM course WHERE courseID = '$courseID'";
        $resultCourseName = $connection->query($courseNameSQL);
        $resultCourseName->data_seek(0);
        $data = $resultCourseName->fetch_array();
        $courseName = $data['name'];
        $text .= "\n\t\t\t\t<div class='schedule_header'>\n\t\t\t\t\t<h1> $courseID - $courseName </h1>\n\t\t\t\t</div>";
    } else {
        return "Database error";
    }



    $text .= "\n\t\t\t\t<p id='overlap_message'>The course(s) below will be " . ($case == 0 ? 'AVAILABLE' : 'UNAVAILABLE') . " if you " . ($case == 0 ? 'withdraw from' : 'enroll to') . " this course :</p>\n\t\t\t\t<div class='overlap'>";



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
    if ($case != 2) {
        $text .= "\n\t\t\t\t</div>\n\t\t\t\t<form action='" . $_SERVER['PHP_SELF'] . "' method='post'>\n\t\t\t\t\t<input type='submit' name='" . ($case == 0 ? 'delete' : 'enroll') . $courseID . "' class='" . ($case == 0 ? 'withdraw' : 'enroll') . "' value='";
    }else{
        $text .= "\n\t\t\t\t</div>\n\t\t\t\t";
    }

    if (isset($_POST["delete$courseID"])) {
        $withdrawSQL = "delete from enrolledstudent where courseID='$courseID' and studentID= '$number';";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully withdrawn.";
            header("Location: index.php");
        }
    } else if ($case == 0) {
        $text .= "Withdraw";
    } else if (isset($_POST["enroll$courseID"])) {
        $withdrawSQL = "insert into enrolledstudent (courseID,studentID) values ('$courseID','$number');";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully enrolled.";
            header("Location: index.php");
        }
    } else if ($case == 1) {
        echo "dsfsdfsd";
        $text .= "Enroll";
    }

    $text .= "'" . ($case == 2 ? 'disabled' : '') . ">\n\t\t\t\t</form>\n\t\t\t</div>";
    return $text;
}

function full($courseID){
    global $connection;

    $result = $connection->query("SELECT capacity FROM course where courseID='$courseID';");
    $result->data_seek(0);
    $data = $result->fetch_array();
    $capacity = $data['capacity'];

    $result = $connection->query("SELECT count(*) as enrolled FROM course c inner join enrolledstudent e on c.courseID=e.courseID where c.courseID = '$courseID';");
    $result->data_seek(0);
    $data = $result->fetch_array();
    $enrolled = $data['enrolled'];

    return ($enrolled < $capacity ?  false:true);
}
