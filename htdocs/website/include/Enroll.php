<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Course
            </td>
            <td>
                Capacity
            </td>
            <td>
                Study Load
            </td>
            <td>
                Enroll
            </td>
        </tr>
        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);
            $availableEnrollSQL = "select * from course where courseID not in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number')));";
            $resultAvailable = $connection->query($availableEnrollSQL);
            $num_rowsAvailable = mysqli_num_rows($resultAvailable);

            $unavailableEnrollSQL = "select * from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number'))) and courseID not in (select courseID from enrolled_students where studentID='$number');";
            $resultUnavailable = $connection->query($unavailableEnrollSQL);
            $num_rowsUnavailable = mysqli_num_rows($resultUnavailable);


            $enrolledSQL = "SELECT * FROM course c inner join enrolled_students en on c.courseID=en.courseID where studentID=$number";
            $resultEnrolledSQL = $connection->query($enrolledSQL);
            $num_rowsEnrolledSQL = mysqli_num_rows($resultEnrolledSQL);

            if ($resultAvailable || $resultEnrolledSQL) {
                if ($num_rowsAvailable > 0) {
                    for ($x = 0; $x < $num_rowsAvailable; $x++) {
                        $resultAvailable->data_seek($x);
                        $data = $resultAvailable->fetch_array();
                        //=============================
                        $name = $data['name'];
                        $capacity = $data['capacity'];
                        $studyload = $data['studyload'];
                        $courseID = $data['courseID'];
                        //=============================
                        $pre = "<a href='javascript:void(0)' onclick = 'function1(" . '"';
                        $pre .= $courseID . '"';
                        $pre .= ")'>Enroll</a>" . "<div id='light" . $courseID . "' class='white_content'>" . enroll($number, $courseID, $connection) . "<a href = 'javascript:void(0)' onclick = 'function2('" . $courseID . "')'>Close</a></div>";
                        $pre .= "<div id='fade' class='black_overlay'></div>";

                        //=============================
                        echo "<tr class='availableRow'>
						<td>$name</td>
						<td>$capacity</td>
						<td>$studyload</td>
						<td>$pre</td>
						</tr>";
                    }
                }
                if ($num_rowsEnrolledSQL > 0) {
                    for ($x = 0; $x < $num_rowsEnrolledSQL; $x++) {
                        $resultEnrolledSQL->data_seek($x);
                        $data = $resultEnrolledSQL->fetch_array();
                        //=============================
                        $name = $data['name'];
                        $capacity = $data['capacity'];
                        $studyload = $data['studyload'];
                        $courseID = $data['courseID'];
                        //=============================
                        $pre = "<button class='withdraw'>Withdraw</button>";
                        $pre = "<a href='javascript:void(0)' onclick = 'function1(" . '"';
                        $pre .= $courseID . '"';
                        $pre .= ")'>Withdraw</a>" . "<div id='light" . $courseID . "' class='white_content'>" . withdraw($number, $courseID, $connection) . "<a href = 'javascript:void(0)' onclick = 'function2('" . $courseID . "')'>Close</a></div>";
                        $pre .= "<div id='fade' class='black_overlay'></div>";
                        //=============================
                        echo
                            "<tr class='enrolledRow'>
							<td>$name</td>
							<td>$capacity</td>
							<td>$studyload</td>
							<td>
							    $pre
							</td>
						</tr>";
                    }
                }

                if ($num_rowsUnavailable > 0) {
                    for ($x = 0; $x < $num_rowsUnavailable; $x++) {
                        $resultUnavailable->data_seek($x);
                        $data = $resultUnavailable->fetch_array();
                        //=============================
                        $name = $data['name'];
                        $capacity = $data['capacity'];
                        $studyload = $data['studyload'];
                        $courseID = $data['courseID'];
                        //=============================
                        echo
                            "
						<tr class='unavailableRow'>
						<td>$name</td>
						<td>$capacity</td>
						<td>$studyload</td>
						<td>
							<button class='unavailable'>Unavailable</button>
						</td>
						</tr>";
                    }
                }

            } else {
                echo "Database error";
            }


        }

        ?>


    </table>
</div>
<?php
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
                for ($x = 0; $x < $num_rows; $x++) {
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
    $text .= "</div><form action='" . $_SERVER['PHP_SELF'] . "' method='post'><p><input type='submit' name='enroll" . $courseID . "' class='back' value='";

    if (isset($_POST["enroll$courseID"])) {
        $withdrawSQL = "insert into enrolled_students (courseID,studentID) values ('$courseID','$number');";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully enrolled.";
            header("Location: index.php");
        }
    } else {
        $text .= "Enroll";
    }

    $text .= "'></p></form><p><a href='index.php'><button class='back'>Cancel</button></a></p></div>";
    return $text;
}function withdraw($number, $courseID, $connection)
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
                for ($x = 0; $x < $num_rows; $x++) {
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
    $text .= "</div><form action='" . $_SERVER['PHP_SELF'] . "' method='post'><p><input type='submit' name='delete" . $courseID . "' class='back' value='";

    if (isset($_POST["delete$courseID"])) {
        $withdrawSQL = "delete from enrolled_students where courseID='$courseID' and studentID= '$number';";
        if ($connection->query($withdrawSQL) === TRUE) {
            $_SESSION["message"] = "Successfully withdrew.";
            header("Location: index.php");
        }
    } else {
        $text .= "Withdraw";
    }

    $text .= "'></p></form><p><a href='index.php'><button class='back'>Cancel</button></a></p></div>";
    return $text;
}