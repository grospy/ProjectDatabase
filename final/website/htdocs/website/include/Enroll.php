<div class="CSSTableGenerator">
    <table>
	
        <tr>
            <td>
                Course
            </td>
            <td>
                Date
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
        <!--------------------------------------------------------------------->
	
        <?php
        require("database.php");
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);
            $availableEnrollSQL = "select * from course where courseID not in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number')));";
            $resultAvailable = $connection->query($availableEnrollSQL);
            $num_rowsAvailable = mysqli_num_rows($resultAvailable);
			
			$unavailableEnrollSQL = "select * from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number'))) and courseID not in (select courseID from enrolled_students where studentID='$number');" ;
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
                        echo 
						"<tr class='availableRow'>
						<td>$name</td>
						<td>
							<a href='dates.php?courseid=" . urlencode($courseID) . "' >
								<button class='schedule'>Schedule</button>
							</a>
						</td>
						<td>$capacity</td>
						<td>$studyload</td>
						<td>
							<a href='enroll_confirmation.php?courseid=" . urlencode($courseID) . "' >
							<button class='enroll'>Enroll</button></a>
						</td>
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
                        echo 
						"<tr class='enrolledRow'>
							<td>$name</td>
							<td>
								<a href='dates.php?courseid=" . urlencode($courseID) . "' >
									<button class='schedule'>Schedule</button>
								</a>
							</td>
							<td>$capacity</td>
							<td>$studyload</td>
							<td>
								<a href='withdraw_confirmation.php?courseid=" . urlencode($courseID) . "' ><button class='withdraw'>Withdraw</button></a>
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
						<td>
							<a href='dates.php?courseid=" . urlencode($courseID) . "' >
								<button class='schedule'>Schedule</button>
							</a>
						</td>
						<td>$capacity</td>
						<td>$studyload</td>
						<td>
							<button class='unavailable'>Unavailable</button>
						</td>
						</tr>";
                    }
                }
				
            }else {
                echo "Database error";
            } 
			
			
			
			
        }

        ?>
		

    </table>
</div>

<?php
?>