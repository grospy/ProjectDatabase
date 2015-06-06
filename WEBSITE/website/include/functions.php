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
    global $connection;
    $password = htmlspecialchars($_POST['password']);
    $number = htmlspecialchars($_POST['number']);
    if ($connection) {
        $number = quote_smart($connection, $number);
        $saltypassword = $password . "AMADEUS";
        $saltypassword = quote_smart($connection, $saltypassword);
        $SQL = "UPDATE person set last_login = CURRENT_TIMESTAMP where personID = 'admin'";
        $connection->query($SQL);
        $SQL = "SELECT * FROM student s inner join person p on p.personID = s.studentID WHERE s.studentID = $number AND s.password = md5($saltypassword) and p.current = '1';";
        $result = $connection->query($SQL);
        echo $connection->error;
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $name = mysqli_result($result, 0, 'firstName');
                session_start();
                $_SESSION['login'] = md5("1");
                $_SESSION['name'] = $name;
                $_SESSION['number'] = $number;
                header("Location: index.php");
                exit();
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

function login_admin(&$error)
{
    global $connection;
    $password = $_POST['password'];
    $username = $_POST['username'];
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    require("include/database.php");

    if ($connection) {
        $username = quote_smart($connection, $username);
        $saltypassword = $password . "AMADEUS";
        $saltypassword = quote_smart($connection, $saltypassword);

        $SQL = "SELECT * FROM admin WHERE adminID = $username AND password = md5($saltypassword)";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                session_start();
                $_SESSION['login'] = md5("2");
                header("Location: admin.php");
                exit();
            } else {
                $error = "Invalid username or password.";
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
    global $connection;
    $number = $_POST["number"];
    $code = $_POST["code"];
    $password = $_POST["password"];

    if ($connection) {
        $number = quote_smart($connection, $number);
        $code = quote_smart($connection, $code);
        $saltypassword = $password . "AMADEUS";
        $saltypassword = quote_smart($connection, $saltypassword);
        $SQL = "SELECT * FROM student WHERE studentID = $number;";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);

        if ($result) {
            if ($num_rows > 0) {
                $connection_code = mysqli_result($result, 0, 'set_code');
                $connection_code = quote_smart($connection, $connection_code);

                if ($connection_code != $code) {
                    $error = "Invalid registration code.";
                } else {
                    $connection->query("UPDATE student SET password = md5($saltypassword) WHERE studentID = $number");
                    $_SESSION['reg'] = md5("y");
                    $_SESSION['number'] = $number;
                    header("Location: index.php");
                    exit();
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

//make code to send
function getcode(&$error)
{
    global $connection;
    $number = $_POST['number'];

    if ($connection) {
        $number = quote_smart($connection, $number);

        $SQL = "SELECT * FROM student s inner join person p on s.studentID = p.PersonID WHERE studentID = $number";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);
        $limit = mysqli_result($result, 0, 'sent');
        $email = mysqli_result($result, 0, 'email');

        if ($result && $limit < 5) {
            if ($num_rows > 0) {
                $alphabet = "ABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                $code = "";
                $alphaLength = strlen($alphabet) - 1;
                for ($i = 0; $i < 8; $i++) {
                    $n = substr($alphabet, rand(0, $alphaLength), 1);
                    $code .= $n;
                }
                $limit = mysqli_result($result, 0, 'sent');
                $limit += 1;
                $connection->query("UPDATE student SET set_code = '$code' WHERE studentID = $number");
                $connection->query("UPDATE student SET sent = $limit WHERE studentID = $number");
                sendmail($code, $email);
                session_start();
                $_SESSION['number'] = $number;
                $_SESSION['login'] = md5("3");
                header("Location: setpassword.php");
                exit();

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
function sendmail($code, $email)
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
    $mail->AddAddress($email);
    if (!$mail->Send()) {
        return "Mailer Error: " . $mail->ErrorInfo;
    } else {
        return "sent";
    }
}

//Add students with cvs file
function addStudents()
{
    global $connection;
    if (isset($_POST["submit"])) {
        $filecheck = basename($_FILES['file']['name']);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));

        if (!($ext == "csv")) {
            echo "<span class='errorMsg'> File must be csv type</span>";
        } else {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $handle = fopen($file, "r");
            if ($handle !== FALSE) {
                $properData = array();
                $wrongData = TRUE;


                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $studentID = $data[0];
                    $first_name = $data[1];
                    $last_name = $data[2];
                    $email = $studentID . "@student.inholland.nl";

                    if (strlen($studentID) == 6 && preg_match("/^[0-9]+$/", $studentID) &&
                        ctype_alpha($first_name) && ctype_alpha($last_name)
                    ) {
                        array_push($properData, [$studentID, $first_name, $last_name, $email]);
                    } else {
                        $wrongData = FALSE;
                    }
                }
                if (!$wrongData) {
                    echo "<span class='errorMsg'>The csv file contains error. Please check the data!</span>";
                } else {
                    $numberOfStudent = 0;
					$sqlerror = FALSE;
					$connection->query("START TRANSACTION;");
                    for ($i = 0; $i < count($properData); $i++) {
                        $studentID = $properData[$i][0];
                        $first_name = $properData[$i][1];
                        $last_name = $properData[$i][2];
                        $email = $properData[$i][3];
						
                        $sql1 = "INSERT INTO person (personID, firstName, lastName, type) VALUES ('$studentID','$first_name','$last_name','student')";
                        $sql2 = "INSERT INTO student (studentID, email) VALUES ('$studentID','$email')";
						if ($connection->query($sql1) && $connection->query($sql2)) {
							$numberOfStudent++;	
						} else {
							echo "<span class='errorMsg'> The csv file contains error. Please check the data! </span>";
							$connection->query("ROLLBACK;");
							$sqlerror = TRUE;
							break ;
						}
                    }
						if (!$sqlerror) {
							$connection->query("COMMIT;"); 
							echo "<span class='confirmMsg'> Succeed adding $numberOfStudent students! </span><br/>";
						}
					}

            }

            fclose($handle);
        }
    }
}

function addCourseCSV()
{
    global $connection;
    if (isset($_POST["submitCourseCSV"])) {
        $filecheck = basename($_FILES['file']['name']);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
        if (!($ext == "csv")) {
            echo "<span class='errorMsg'> File must be csv type </span>";
        } else {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $handle = fopen($file, "r");
            if ($handle !== FALSE) {
                $properData = array();
                $wrongData = TRUE;

                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $courseID = $data[0];
                    $courseName = $data[1];
                    $capacity = $data[2];
                    $studyLoad = $data[3];
                    $teacherID = $data[4];
						//check if teacher is in the DB
                    if (strlen($courseID) == 7 && substr($courseID, 0, 4) == "IBIS" && preg_match("/^[0-9]+$/", substr($courseID, 4, 3)) && preg_match("/^[0-9]+$/", $teacherID) && preg_match("/^[0-9]+$/", $capacity) && preg_match("/^[0-9]+$/", $studyLoad)) {
                        array_push($properData, [$courseID, $courseName, $capacity, $studyLoad, $teacherID, "0"]);
                    } else {
                        $wrongData = FALSE;
						break;
                    }
                }
					
                if (!$wrongData) {
                    echo "<span class='errorMsg'>The csv file contains error. Please check the data!</span>";
                } else {
                    $numberOfCourse = 0;
						$sqlerror = FALSE;
						$connection->query("START TRANSACTION;");
                    for ($i = 0; $i < count($properData); $i++) {
                        $courseID = $properData[$i][0];
                        $courseName = $properData[$i][1];
                        $capacity = $properData[$i][2];
                        $studyLoad = $properData[$i][3];

                        $sql1 = "INSERT INTO course VALUES ('$courseID','$courseName','$capacity','$studyLoad',0)";
                        $sql2 = "INSERT INTO teacher VALUES ('$teacherID','$courseID')";
                        if ($connection->query($sql1) && $connection->query($sql2)) {
                            $numberOfCourse++;
                        }
							else {
								echo "<span class='errorMsg'> The csv file contains error. Please check the data! </span>";
								$connection->query("ROLLBACK;");
								$sqlerror = TRUE;
								break ;
							}
						}
						if (!$sqlerror) {
							$connection->query("COMMIT;"); 
							echo "<span class='confirmMsg'> Succeed adding $numberOfCourse! </span><br/>";
                    }
                }


            }

        }
        fclose($handle);
    }
}


function addLessonCSV()
{
    global $connection;
    if (isset($_POST["submitLessonCSV"])) {
        $filecheck = basename($_FILES['file']['name']);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
        if (!($ext == "csv")) {
            echo "<span class='errorMsg'> File must be csv type </span>";
        } else {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $handle = fopen($file, "r");
            if ($handle !== FALSE) {
				$connection->query("START TRANSACTION");
				$sqlerror = FALSE;
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);
                    $courseID = $data[0];
                    $roomNumber = $data[1];
                    $date = $data[2];
                    $timeStart = $data[3];

                    $sql1 = "INSERT INTO lesson VALUES ('$courseID','$roomNumber','$date','$timeStart')";

                    if ($connection->query($sql1)) {
                        echo "Succeed adding lesson! <br/>";
                    } else {
                        echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
						$sqlerror = TRUE;
						$connection->query("ROLLBACK");
						break; ;
                    }
					
					if (!$sqlerror) {
						$connection->query("COMMIT");
					}
                }
                fclose($handle);
            }
        }
    }
}

function addNewCourse()
{
    global $connection;
    if (isset($_POST['addCourse'])) {
        if (empty($_POST['newCourseName']) || empty($_POST['newCapacity']) || empty($_POST['newStudyLoad']) || empty($_POST['newInstructor'])) {
            echo "<span class='errorMsg'> All field have to be filled</span>";
        } else {
            $newCourseID = quote_smart($connection, htmlspecialchars($_POST['newCourseID']));
            $newCourseName = quote_smart($connection, htmlspecialchars($_POST['newCourseName']));
            $newCapacity = quote_smart($connection, htmlspecialchars($_POST['newCapacity']));
            $newStudyLoad = quote_smart($connection, htmlspecialchars($_POST['newStudyLoad']));
            $newInstructor = quote_smart($connection, htmlspecialchars($_POST['newInstructor']));

            $addCourseSQL = "insert into course value ($newCourseID, $newCourseName,$newCapacity,$newStudyLoad, 0);";
            $addTeacherSQL = "insert into teacher value ($newInstructor, $newCourseID);";
            if ($connection->query($addCourseSQL) === TRUE && $connection->query($addTeacherSQL) === TRUE) {
                echo "New course added! $newCourseID-$newCourseName, capacity : $newCapacity, study load : $newStudyLoad. ";
            } else {
                echo "<span class='errorMsg'>" . $connection->error . "</span>";
            }
        }
    }
}

//Set registration date
function addRegistrationDate()
{
    global $connection;
    if (isset($_POST["submitRegDate"])) {
        $studyYear = $_POST["studyYear"];
        $term = $_POST["term"];
        $regtype = $_POST["regtype"];
        $minRegStudyLoad = $_POST["minRegStudyLoad"];

        $today = date("Y-m-d");

        $openDay = $_POST["openDay"];
        $openMonth = $_POST["openMonth"];
        $openYear = $_POST["openYear"];
        $openDate = "$openYear-$openMonth-$openDay";

        $closeDay = $_POST["closeDay"];
        $closeMonth = $_POST["closeMonth"];
        $closeYear = $_POST["closeYear"];
        $closeDate = "$closeYear-$closeMonth-$closeDay";

        $registrationID = $studyYear . $term . $regtype;


        if (!($openDay == "Day" || $openMonth == "Month" || $openYear == "Year" || $closeDay == "Day" || $closeMonth == "Month" || $closeYear == "Year")) {
            if (($openDate > $today) && (($closeDate > $today) && ($closeDate > $openDate))) {
                $openDateSQL = "insert into registration (registrationID, year, term, opendate, closedate, type, minstudyload) values ($registrationID, $studyYear, $term,'$openYear-$openMonth-$openDay', '$closeYear-$closeMonth-$closeDay', '$regtype', $minRegStudyLoad)";
                if ($connection->query($openDateSQL) === TRUE) {
                    echo "<br/>Succeed adding registration date for study year $studyYear term $term
							<br/>open date : $openYear-$openMonth-$openDay
							<br/>close date : $closeYear-$closeMonth-$closeDay";

                } else {
                    echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
                }
            } else {
                echo "<span class='errorMsg'> date error. select open date after today. select close date after open date. </span>";
            }
        } else {
            echo "<span class='errorMsg'> all day, month and year field must be filled. </span>";
        }
    }
}

function allowStudent()
{
    global $connection;
    if (isset($_POST["filterStudent"])) {
        if (!isset($_POST['allowedStudent'])) {
            echo "<span class='errorMsg'> Please filter some student </span>";
        } else {
            $selected_radio = $_POST['allowedStudent'];
            $minStudyLoad = $_POST['minStudyLoad'];
            $addStudentID = preg_replace('/\s+/', '', $_POST['addStudentID']);

            switch ($_POST['allowedStudent']) {
                case 'allStudent':
                    echo "Registration is now opened for all student.";
                    $SQL = "update student set allowToReg=1";
                    if ($connection->query($SQL) === TRUE)
                        break;

                case 'noStudent':
                    echo "Registration is now closed for all student.";
                    echo "$addStudentID";
                    $SQL = "update student set allowToReg=0";
                    if ($connection->query($SQL) === TRUE)
                        break;

                case 'manuallyStudent':
                    if (empty($_POST["addStudentID"])) {
                        echo "Insert student ID";
                    } else {
                        $manualStudent = explode(",", $addStudentID);
                        $allStudent = array();
                        $allStudentSQL = "select personID from person WHERE type='student'";
                        $result = $connection->query($allStudentSQL);
                        $num_rows = mysqli_num_rows($result);
                        if ($result) {
                            if ($num_rows > 0) {
                                for ($x = 0; $x < $num_rows; $x++) {
                                    $studentID = mysqli_result($result, 0, 'personID');
                                    array_push($allStudent, "$studentID");
                                }
                            }
                        }
                        $text_success = "";
                        $text_fail = "";
                        foreach ($manualStudent as $aStudent) {
                            if (in_array($aStudent, $allStudent)) {
                                $manualSQL = "update student set allowToReg=1 where studentID='$aStudent';";
                                $connection->query($manualSQL);
                                $text_success .= "$aStudent, ";
                            } else ($text_fail .= "$aStudent, ");
                        }
                        echo " <p>These studentID are able to register now : $text_success </p>
					<p class='errorMsg'>These are not a valid studentID : $text_fail</p>";
                    }
                    break;


                case 'problemStudent':
                    //close registration for all student
                    $SQL = "update student set allowToReg=0";
                    $connection->query($SQL);
                    //open registration for problem student
                    $problemStudent = array();
                    $problemStudentSQL = "select s.studentID as studentID,sum(c.studyload) from course c inner join enrolledstudent e on c.courseID=e.courseID right join student s on e.studentID=s.studentID group by studentID having sum(c.studyload)<$minStudyLoad or sum(c.studyload) is null;";
                    $result = $connection->query($problemStudentSQL);
                    $num_rows = mysqli_num_rows($result);
                    if ($result) {
                        if ($num_rows > 0) {
                            for ($x = 0; $x < $num_rows; $x++) {
                                $studentID = mysqli_result($result, 0, 'studentID');
                                array_push($problemStudent, "$studentID");
                            }
                        }
                    }
                    echo "<p>Registration is opened for these students: </p>";
                    foreach ($problemStudent as $aStudent) {
                        $reEnrolStudent = "update student set allowToReg=1 where studentID='$aStudent'";
                        $connection->query($reEnrolStudent);
                        echo "$aStudent, ";
                    }
            }
        }
    }
}

//All students into table
function showStudents($search)
{
    global $connection;
    $return = "
    <form method='post'>
        <input type='submit' name = 'backToStudents' value = 'Back'>
    </form>
    <div class=\"CSSTableGenerator\">
        <table>
            <tr>
                <td>
                    ID
                </td>
                <td>
                    Name
                </td>
                <td>
                    email
                </td>
                <td>
                    Edit/delete
                </td>
                <td>
                    Current
                </td>
                <td>
                    Registration
                </td>
            </tr>
            ";
    if ($connection) {
        $SQL = "SELECT * FROM person p inner join student s on p.personID = s.StudentID where p.personID like '%$search%' || p.firstName like '%$search%' || p.lastName like '%$search%' order by current desc, p.lastname asc, p.firstname asc;";
        $result = $connection->query($SQL);
        $rows = mysqli_num_rows($result);
        //for sorting
        /* $results = array();
        while ($row = mysqli_fetch_array($result)) {
        $results[] = $row['courseID'];
        }*/
        for ($x = 0; $x < $rows; $x++) {
            $name = mysqli_result($result, $x, 'firstName');
            $name2 = mysqli_result($result, $x, 'lastName');
            $number = mysqli_result($result, $x, 'personID');
            $email = mysqli_result($result, $x, 'email');
            $current = mysqli_result($result, $x, 'current') ? "Yes" : "No";
            $reg = mysqli_result($result, $x, 'allowToReg') ? "Open" : "Closed";

            $button = "

            <form method = \"post\">
                <input type = 'hidden' name='editStudentNr' value='$number'>
                <input type = 'submit' name='editStudent' value='edit'>
            </form>

            ";

            $return .= "
            <tr>
                <td>$number</td>
                <td>$name $name2</td>
                <td>$email</td>
                <td>$button</td>
                <td>$current</td>
                <td>" . ($current == "Yes" ? "$reg" : "N/A") . "</td>
            </tr>
            ";
        }
    } else {
        $return .= "Database error";
    }
    $return .= "
        </table>
    </div>";
    return $return;
}

//Checks if course is full
function full($courseID)
{
    global $connection;

    $result = $connection->query("SELECT capacity FROM course where courseID='$courseID';");
    $capacity = mysqli_result($result, 0, 'capacity');

    $result = $connection->query("SELECT count(*) as enrolled FROM course c inner join enrolledstudent e on c.courseID=e.courseID where c.courseID = '$courseID' and e.status is null;");
    $enrolled = mysqli_result($result, 0, 'enrolled');

    if ($enrolled < $capacity) {
        return false;
    } else {
        return true;
    }
}

//Checks if course is full
function offered($courseID)
{
    global $connection;

    $result = $connection->query("SELECT offer FROM course where courseID='$courseID';");
    $offer = mysqli_result($result, 0, 'offer');

    switch ($offer) {
        case 0:
            return false;
            break;
        case 1:
            return true;
            break;
        default:
            return false;
            break;
    }
}

//Sorts all the courses
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
        $SQL = "SELECT * FROM course c INNER JOIN enrolledstudent e on c.courseID = e.courseID where e.studentID = $number and status is null;";
        $result = $connection->query($SQL);
        $enrolled = array();
        while ($row = mysqli_fetch_array($result)) {
            $enrolled[] = $row['courseID'];
        }
        //OVERLAP
        $SQL = "select * from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolledstudent where studentID='$number' and status is null)));";
        $result = $connection->query($SQL);
        $overlap = array();
        while ($row = mysqli_fetch_array($result)) {
            $overlap[] = $row['courseID'];
        }
        //PASSED
        $SQL = "SELECT * FROM course c INNER JOIN enrolledstudent e on c.courseID = e.courseID where e.studentID = $number and status = 1;";
        $result = $connection->query($SQL);
        $passed = array();
        while ($row = mysqli_fetch_array($result)) {
            $passed[] = $row['courseID'];
        }

        for ($x = 0; $x < $rows; $x++) {
            // 0-enroll 1-withdraw 2-unavailable 3-full 4-passed
            if (in_array($all[$x], $offered)) {
                if (!in_array($all[$x], $enrolled)) {
                    if (!full($all[$x])) {
                        if (!in_array($all[$x], $passed)) {
                            if (!in_array($all[$x], $overlap)) {
                                $rt .= courses2(0, $all[$x]);
                            } else {
                                $rt .= courses2(2, $all[$x]);
                            }
                        } else {
                            $rt .= courses2(4, $all[$x]);
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

//Generates rows for courses
function courses2($case, $cID)
{
    global $connection;
    $number = $_SESSION['number'];
    $number = htmlspecialchars($number);

    $sql = "Select * from registration where current = 1";
    $result = $connection->query($sql);
    $rID = mysqli_result($result, 0, 'registrationID');


    if (isset($_POST["withdraw$cID"])) {
        if ($rID) {
            $withdrawSQL = "delete from enrolledstudent where courseID='$cID' and studentID= '$number' and registrationID='$rID';";
            if ($connection->query($withdrawSQL) === TRUE) {
                $_SESSION["message"] = " - Successfully withdrawn.";
                header("Location: index.php");
                exit();
            }
            echo $connection->error;
        }
    } else if (isset($_POST["enroll$cID"])) {
        if (!full($cID)) {
            $withdrawSQL = "insert into enrolledstudent (courseID,studentID,registrationID) values ('$cID','$number','$rID');";
            if ($connection->query($withdrawSQL) === TRUE) {
                $_SESSION["message"] = " - Successfully enrolled.";
                header("Location: index.php");
                exit();
            } else {
                echo $connection->error;
            }
        } else {
            $_SESSION["message"] = " - Class full.";
            header("Location: index.php");
            exit();
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
        case 4:
            $rt .= "'passedRow'>";
            break;
    }
    $SQL = "SELECT count(*) as enrolled FROM course c inner join enrolledstudent e on c.courseID=e.courseID where c.courseID = '$cID' and (status = 0 or status is null);";
    $result = $connection->query($SQL);
    $enrolled = mysqli_result($result, 0);


    $SQL = "SELECT * FROM course where courseID = '$cID';";
    $result = $connection->query($SQL);
    $name = mysqli_result($result, 0, 'name');
    $capacity = mysqli_result($result, 0, 'capacity');
    $load = mysqli_result($result, 0, 'studyload');

    $rt .= "<td>$name</td>";
    $rt .= "<td>$enrolled/$capacity</td>";
    $rt .= "<td>$load</td>";
    $rt .= "<td>" . button($case, $cID, $name) . "</td>";
    $rt .= "</tr>";

    return $rt;


}

//Generates popup for courses
function button($case, $cID, $name)
{
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
        case 4:
            $rt .= "'passed'";
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
        case 4:
            $rt .= "Passed";
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
                $rt .= "<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you enroll to this course :</p>";
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

//Generates list of overlapping courses
function overlaps($courseID)
{
    global $connection;
    $rt = "";
    if ($connection) {
        $SQL = "select concat(courseID, ' - ', name) as overlap from course where courseID in(select le.courseID from lesson le where concat(le.date, le.time_start) in(select concat(date, time_start) from lesson where courseID = '$courseID') and le.courseID in(le.courseID = '$courseID'));";
        $result = $connection->query($SQL);
        $num_rows = mysqli_num_rows($result);
        if ($result) {
            if ($num_rows > 0) {
                $rt .= "<ul>";
                for ($x = 0;
                     $x < $num_rows;
                     $x++) {
                    $rt .= "<li>";
                    $rt .= mysqli_result($result, $x, 'overlap');
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

//Gets specific result from query
function mysqli_result($res, $row, $field = 0)
{
    $res->data_seek($row);
    $datarow = $res->fetch_array();
    return $datarow[$field];
}

function saveEditedCourse()
{
    global $connection;
    $newCourseID = $_POST['newCourseID'];
    $newCourseName = $_POST['newCourseName'];
    $newCapacity = $_POST['newCapacity'];
    $newStudyLoad = $_POST['newStudyLoad'];
    $newInstructor = $_POST['newInstructor'];
    // update course set name='3D printing', capacity=40, studyload=50 where courseID='IBIS001';
    $updateCourse = "update course set name='$newCourseName', capacity=$newCapacity, studyload=$newStudyLoad where courseID='$newCourseID';";

    $updateInstructor = "update teacher set teacherID='$newInstructor' where courseID='$newCourseID';";
    if ($connection->query($updateCourse) === TRUE && $connection->query($updateInstructor) === TRUE) {
        echo "$newCourseID";
    } else {
        echo $connection->error;
    }
}

function tabSelect()
{
    if (isset($_SESSION["tab"])) {
        if ($_SESSION["tab"] == "123") {
            return 0;
        }
        if ($_SESSION["tab"] == "S") {
            return 3;
        }
    }
    if (isset($_POST['clickSetReg'])) {
        return 0;
    }
    if (isset($_POST['grades'])) {
        return 0;
    }
	if (isset($_POST['submitStatus'])) {
        return 0;
    }
    if (isset($_POST['clickEditReg'])) {
        return 0;
    }
    if (isset($_POST["deleteReg"])) {
        return 0;
    }
    if (isset($_POST['openReg'])) {
        return 0;
    }
    if (isset($_POST['openRegNow'])) {
        return 0;
    }
    if (isset($_POST['openRegNowConfirm'])) {
        return 0;
    }
    if (isset($_POST['endReg'])) {
        return 0;
    }
    if (isset($_POST['endRegConfirm'])) {
        return 0;
    }
    if (isset($_POST['endReg2'])) {
        return 0;
    }
    if (isset($_POST['endReg2Confirm'])) {
        return 0;
    }
    if (isset($_POST['editReg'])) {
        return 0;
    }
    if (isset($_POST['filterStudent'])) {
        return 0;
    }
    if (isset($_POST['openReg'])) {
        return 0;
    }
    if (isset($_POST['backToReg'])) {
        return 0;
    }
    if (isset($_POST['closeReg'])) {
        return 0;
    }
    if (isset($_POST['offerCourse'])) {
        return 1;
    }
    if (isset($_POST['editCourseButton'])) {
        return 1;
    }
    if (isset($_POST['backToCourseList'])) {
        return 1;
    }
    if (isset($_POST['saveCourse'])) {
        return 1;
    }
    if (isset($_POST['addCourse'])) {
        return 2;
    }
    if (isset($_POST['refresh'])) {
        return 2;
    }
    if (isset($_POST['generateNumber'])) {
        return 2;
    }
    if (isset($_POST['submitCourseCSV'])) {
        return 2;
    }
    if (isset($_POST['submitLessonCSV'])) {
        return 2;
    }
    if (isset($_POST['submit2'])) {
        return 2;
    }
    if (isset($_POST['submit'])) {
        return 3;
    }
    if (isset($_POST['editStudent'])) {
        return 3;
    }
    if (isset($_POST['search'])) {
        return 3;
    }
    if (isset($_POST['backToStudents'])) {
        return 3;
    }
    if (isset($_POST['edSt'])) {
        return 3;
    }
    //DEFAULT TAB (0-3)
    return 1;
}

function tabSelect2()
{
    //DEFAULT TAB
    if (access($_SESSION['number'])) {
        return "E";
    } else {
        return "S";
    }
}

function access($sID)
{
    global $connection;
    if ($connection) {
        $now = Date('Y-m-d');
        $result = $connection->query("Select * from registration where current = '1'");
        $num = mysqli_num_rows($result);

        $res = $connection->query("SELECT s.allowToReg, p.current from student s inner join person p on p.personID = s.StudentID where studentID=$sID");

        if ($num > 0) {
            $open = mysqli_result($result, 0, 'opendate');
            $close = mysqli_result($result, 0, 'closedate');
            if (mysqli_result($res, 0, 'allowToReg') && mysqli_result($res, 0, 'current') && ($open <= $now && $close >= $now)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    if ($connection) {
        if (mysqli_result($connection->query("SELECT allowtoreg from student where studentID=$sID"), 0)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function regType()
{
    global $connection;
    if ($connection) {
        $sql = "SELECT *, (opendate <= CURDATE()) as afteropen, (closedate >= CURDATE()) as beforeclose, (closedate < CURDATE()) as afterclose, (closedate2 >= CURDATE()) as beforeclose2 from registration where current = 1 ORDER by opendate desc;";
        $res = $connection->query($sql);
        $rows = mysqli_num_rows($res);

        if ($rows < 1) {
            return 0; //No Current
        } else if (mysqli_result($res, 0, 'afteropen') && mysqli_result($res, 0, 'beforeclose')) {
            return 1; //first
        } else if (mysqli_result($res, 0, 'afterclose') && mysqli_result($res, 0, 'beforeclose2')) {
            return 2; //second
        } else if (!mysqli_result($res, 0, 'afteropen')) {
            return 3; //before
        } else {
            return 4; //After
        }
    }

}

function runCheck()
{

    switch (regType()) {
        case 1:
            start1();
            break;

        case 2:
            start2();
            break;

        case 4:
            endProcess();
            break;
    }
}

function start1(){

    global $connection;

    $result = $connection->query("SELECT * FROM log;");
    $last = mysqli_result($result, 0, 'lastdate');

    $result = $connection->query("SELECT * FROM registration WHERE current = 1;");
    $compare = mysqli_result($result, 0, 'opendate');

    if ($last < $compare) {
        $connection->query("UPDATE student set allowToReg = 1 where CURRENT = 1;");
    }
}

function start2(){
    global $connection;

    $result = $connection->query("SELECT * FROM log;");
    $last = mysqli_result($result, 0, 'lastdate');

    $result = $connection->query("SELECT * FROM registration WHERE current = 1;");
    $regID = mysqli_result($result, 0, 'registrationID');
    $minC = mysqli_result($result, 0, 'minimumcredits');

    $compare = mysqli_result($result, 0, 'closedate');
    $compare = date('Y-m-d', strtotime($compare . ' + 1 day'));
    if ($last < $compare) {
        $connection->query("UPDATE student set allowToReg = 0 where CURRENT = 1;");
        $result = $connection->query("SELECT * FROM course where offer = 1;");
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $id = mysqli_result($result, $i, 'courseID');
            $min = mysqli_result($result, $i, 'minimumstudents');
            $en = mysqli_result($connection->query("SELECT count(*) FROM enrolledstudent where courseID = '$id' and registrationID = $regID;"), 0);
            if ($en < $min) {
                $connection->query("UPDATE course set offer = 0 where courseID = '$id';");
                $connection->query("DELETE FROM enroledstudent where registrationID=$regID and courseID = $id;");
            }
        }
        $result = $connection->query(" select * from student where CURRENT = 1;");
        for ($j = 0; $j < mysqli_num_rows($result); $j++) {
            $number = mysqli_result($result, $j, 'studentID');
            $result2 = $connection->query(" select * from enrolledstudent e inner join course c on e.courseID = c.courseID where estudentID = $number && eregistrationID = $regID;");
            $credits = 0;
            for ($k = 0; $k < mysqli_num_rows($result2); $k++) {
                $credits .= mysqli_result($result2, $k, 'studyload');
            }
            if ($credits < $minC) {
                $connection->query("UPDATE student set allowToReg = 1 where studentID = $number;");
            }
        }
    }
    $now = Date('Y-m-d');
    $connection->query("UPDATE log set lastdate = '$now';");
}

function endProcess(){
    global $connection;

    $result = $connection->query("SELECT * FROM log;");
    $last = mysqli_result($result, 0, 'lastdate');

    $result = $connection->query("SELECT * FROM registration WHERE current = 1;");
    $regID = mysqli_result($result, 0, 'registrationID');

    $compare = mysqli_result($result, 0, 'closedate2');
    $compare = date('Y-m-d', strtotime($compare . ' + 1 day'));

    if ($last < $compare) {
        $connection->query("UPDATE student set allowToReg = 0 where CURRENT = 1;");
        $result = $connection->query("SELECT * FROM course where offer = 1");
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $id = mysqli_result($result, $i, 'courseID');
            $min = mysqli_result($result, $i, 'minimumstudents');
            $en = mysqli_result($connection->query("SELECT count(*) FROM enrolledstudent where courseID = '$id' and registrationID = $regID;"), 0);
            if ($en < $min) {
                $connection->query("UPDATE course set offer = 0 where courseID = '$id';");
                $connection->query("DELETE FROM enrol +edstudent where registrationID=$regID and courseID = $id");
            }
        }
    }
}