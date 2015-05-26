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
                    $sql1 = "INSERT INTO person (personID, firstName, lastName, type) VALUES ('$studentID','$first_name','$last_name','student')";
                    $sql2 = "INSERT INTO student (studentID, email) VALUES ('$studentID','$email')";
                    if ($connection->query($sql1) && $connection->query($sql2)) {

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

        switch ($_POST['allowedStudent']) {
            case 'allStudent':
                echo " first ";
                $type = "first";
                $regtype = "01";
                break;

            default:
                echo " second ";
                $type = "second";
                $regtype = "02";
                break;
        }

        $registrationID = $studyYear . $term . $regtype;
        $minStudyLoad = $_POST['minStudyLoad'];

        if (!($openDay == "Day" || $openMonth == "Month" || $openYear == "Year" || $closeDay == "Day" || $closeMonth == "Month" || $closeYear == "Year")) {
            if (($openDate > $today) && (($closeDate > $today) && ($closeDate > $openDate))) {
                require('include/database.php');
                $openDateSQL = "insert into registration (registrationID, year, term, opendate, closedate, type, minstudyload) values ($registrationID, $studyYear, $term,'$openYear-$openMonth-$openDay', '$closeYear-$closeMonth-$closeDay', '$type', $minStudyLoad)";
                if ($connection->query($openDateSQL) === TRUE) {
                    echo "<br/>Succeed adding registration date for study year $studyYear term $term
							<br/>open date : $openYear-$openMonth-$openDay
							<br/>close date : $closeYear-$closeMonth-$closeDay";

                } else {
                    echo "<br/>$registrationID" . $connection->error;
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
        $SQL = "SELECT * FROM person WHERE type='student';";
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
            $name = $data['firstName'];
            $name2 = $data['lastName'];
            $number = $data['personID'];
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


function full($courseID)
{
    global $connection;

    $result = $connection->query("SELECT capacity FROM course where courseID='$courseID';");
    $result->data_seek(0);
    $data = $result->fetch_array();
    $capacity = $data['capacity'];

    $result = $connection->query("SELECT count(*) as enrolled FROM course c inner join enrolledstudent e on c.courseID=e.courseID where c.courseID = '$courseID';");
    $result->data_seek(0);
    $data = $result->fetch_array();
    $enrolled = $data['enrolled'];

    if ($enrolled < $capacity) {
        return false;
    } else {
        return true;
    }
}

function courses()
{
    global $connection;
    $number = $_SESSION['number'];
    $number = htmlspecialchars($number);
    $rt = '';
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

        for ($x = 0; $x < $rows; $x++) {
            // 0-enroll 1-withdraw 2-unavailable 3-full
            if (in_array($all[$x], $offered)) {
                if (!in_array($all[$x], $enrolled)) {
                    if (!full($all[$x])) {
                        if (!in_array($all[$x], $overlap)) {
                            $rt .= courses2(0, $all[$x]);
                        } else {
                            $rt .= courses2(2, $all[$x]);
                        }
                    } else {
                        $rt .= courses2(3, $all[$x]);
                    }
                } else {
                    $rt .= courses2(1, $all[$x]);
                }
            } else {
                //THIS CLASS IS NOT OFFERED!
            }
        }
    } else {
        echo "Database error";
    }
    return $rt;
}

function courses2($case, $cID)
{
    global $connection;
    $number = $_SESSION['number'];
    $number = htmlspecialchars($number);
    if (isset($_POST["withdraw$cID"])) {
        $withdrawSQL = "delete from enrolledstudent where courseID='$cID' and studentID= '$number';";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully withdrawn.";
            header("Location: index.php");
        } else {
        }
    } else if (isset($_POST["enroll$cID"])) {
        if (!full($cID)) {
            $withdrawSQL = "insert into enrolledstudent (courseID,studentID,registrationID) values ('$cID','$number','');";
            if ($connection->query($withdrawSQL) === TRUE) {
                $_SESSION["message"] = "Successfully enrolled.";
                header("Location: index.php");
            }
        } else {
            $_SESSION["message"] = "Class full.";
            header("Location: index.php");
        }

    }
    $rt = "<tr class=";
    switch ($case) {
        case 0:
            $rt .= "'enrollRow'>";
            break;
        case 1:
            $rt .= "'withdrawRow'>";
            break;
        case 2:
            $rt .= "'unavailableRow'>";
            break;
        case 3:
            $rt .= "'fullRow'>";
            break;
    }
    $SQL = "SELECT * FROM course where courseID = '$cID';";
    $result = $connection->query($SQL);
    $result->data_seek(0);
    $data = $result->fetch_array();
    $name = $data['name'];
    $capacity = $data['capacity'];
    $load = $data['studyload'];

    $rt .= "<td>$name</td>";
    $rt .= "<td>$capacity</td>";
    $rt .= "<td>$load</td>";
    $rt .= "<td>" . button($case, $cID, $name) . "</td>";
    $rt .= "</tr>";

    return $rt;


}

function button($case, $cID, $name)
{
    global $connection;
    $number = $_SESSION['number'];
    $rt = "<button class=";
    switch ($case) {
        case 0:
            $rt .= "'enroll'";
            break;
        case 1:
            $rt .= "'withdraw'";
            break;
        case 2:
            $rt .= "'unavailable'";
            break;
        case 3:
            $rt .= "'full'";
            break;
    }
    if ($case == 0 || $case == 1) {
        $rt .= "onclick =";
        $rt .= "'function1(\"" . $cID . "\")'";
    }
    $rt .= ">";
    switch ($case) {
        case 0:
            $rt .= "Enroll";
            break;
        case 1:
            $rt .= "Withdraw";
            break;
        case 2:
            $rt .= "Unavailable";
            break;
        case 3:
            $rt .= "Full";
            break;
    }
    $rt .= "</button>";

    if ($case == 0 || $case == 1) {
        $rt .= "<div id='light" . $cID . "' class='white_content'>";
        $rt .= "<div class='confirmation_message'>";
        switch ($case) {
            case 0:
                $rt .= "<h3 align='center'>Are you sure you want to enroll to</h3>";
                break;
            case 1:
                $rt .= "<h3 align='center'>Are you sure you want to withdraw from</h3>";
                break;
        }
        $rt .= "<div class='schedule_header'>
        <h1>$name</h1>
        </div>";
        switch ($case) {
            case 0:
                $rt .= "<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you withdraw from this course :</p>";
                break;
            case 1:
                $rt .= "<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you withdraw from this course :</p>";
                break;
        }
        $rt .= "<div class='overlap'>";
        $rt .= overlaps($cID);
        $rt .= "</div>";

        $rt .= "<form method='post'>";
        $rt .= "<input type='submit' name='";
        switch ($case) {
            case 0:
                $rt .= "enroll";
                break;
            case 1:
                $rt .= "withdraw";
                break;
        }
        $rt .= $cID . "' class=";
        switch ($case) {
            case 0:
                $rt .= "'enroll'";
                break;
            case 1:
                $rt .= "'withdraw'";
                break;
        }
        $rt .= "value =";
        switch ($case) {
            case 0:
                $rt .= "'enroll'>";
                break;
            case 1:
                $rt .= "'withdraw'>";
                break;
        }
        $rt .= "</form></div>";
        $rt .= "<button class='back' onclick='function2(\"$cID\")'>Cancel</button>";
        $rt .= "</div>";
    }
    return $rt;
}

function overlaps($courseID)
{
    global $connection;
    $rt = "";
    if ($connection) {
        $SQL = "select concat(courseID, ' - ', name) as overlap from course where courseID in(select le . courseID from lesson le where concat(le . date, le . time_start) in(select concat(date, time_start) from lesson where courseID = '$courseID') and le . courseID in(le . courseID = '$courseID'));";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);
        if ($result) {
            if ($num_rows > 0) {
                $rt .= "<ul>";
                for ($x = 0;
                     $x < $num_rows;
                     $x++) {
                    $result->data_seek($x);
                    $data = $result->fetch_array();
                    $rt .= "<li>";
                    $rt .= $data["overlap"];
                    $rt .= " </li><br/>";
                }
                $rt .= "</ul> ";
            }
        } else {
            return "Database error";
        }
    }
    return $rt;
}