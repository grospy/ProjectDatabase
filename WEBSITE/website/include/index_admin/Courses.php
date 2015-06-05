<div class="CSSTableGenerator">

    <table>
        <form name="offerCourse" method="post">
            <input type="submit" name="offerCourse" value="Offer checked courses"/>
            <input type="button" name="Check_All" value="Check All" onClick="CheckAll()">
            <input type="button" name="Un_CheckAll" value="Uncheck All" onClick="UnCheckAll()">

            <?php
            if (isset($_POST["offerCourse"]) && $connection) {
                if (!isset($_POST['courseForm'])) {
                    $closeAllCourseSQL = "update course set offer=0";
                    $connection->query($closeAllCourseSQL);
                    echo "<span class='errorMsg'> All course is now closed! </span>";
                } else {
                    $offeredCourse = $_POST['courseForm'];
                    $closeAllCourseSQL = "update course set offer=0";
                    $connection->query($closeAllCourseSQL);

                    foreach ($offeredCourse as $acourse) {
                        $offerCourseSQL = "update course set offer=1 where courseID='$acourse'";
                        $connection->query($offerCourseSQL);
                    }
                    echo "<span class='confirmMsg'> Successfully open checked courses!</span>";

                }
            }
            ?>

            <tr>
                <td></td>
                <td>Course</td>
                <td>Participants</td>
                <td>Edit</td>
                <td>Offered</td>
            </tr>

            <?php
            if ($connection) {
                $courseNameSQL = "SELECT name, courseID, capacity FROM course order by courseID";
                $result = $connection->query($courseNameSQL);
                $num_rows = mysqli_num_rows($result);
                if ($result) {
                    if ($num_rows > 0) {
                        for ($x = 0; $x < $num_rows; $x++) {
                            $courseName = mysqli_result($result, $x, "name");
                            $courseID = mysqli_result($result, $x, "courseID");
                            $capacity = mysqli_result($result, $x, "capacity");

                            $participantSQL = "select studentID from enrolledstudent where courseID='$courseID' and status is null";
                            $participantResult = $connection->query($participantSQL);
                            $participant = mysqli_num_rows($participantResult);

                            echo "<tr>
                            <td><input type='checkbox' name='courseForm[]' class='courseForm' value='$courseID'></td>
							<td > $courseName</td >
							<td > $participant / $capacity</td >
							<td > <input type = 'submit' name = 'editCourseButton' value = '$courseID' />	</td >
                            <td>" . (offered($courseID) == true ? "Yes" : "No") . "</tr>";
                        }
                    }
                } else {
                    echo "Database error";
                }
            }
            ?>
        </form>
    </table>
</div>