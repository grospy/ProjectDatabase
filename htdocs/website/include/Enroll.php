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
            $availableEnrollSQL = "SELECT * FROM course where courseID not in (select c.courseID from course c inner join enrolled_students en on c.courseID=en.courseID where en.studentID=$number)";
            $resultAvailable = $connection->query($availableEnrollSQL);
            $num_rowsAvailable = mysqli_num_rows($resultAvailable);
			
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
						"<tr>
						<td>$name</td>
						<td>
							<a href='dates.php?courseid=" . urlencode($courseID) . "' >
								<button class='schedule'>Schedule</button>
							</a>
						</td>
						<td>$capacity</td>
						<td>$studyload</td>
						<td>
							<button class='enroll'>Enroll</button>
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
						"<tr id='unavailableCourse'>
							<td>$name</td>
							<td>
								<a href='dates.php?courseid=" . urlencode($courseID) . "' >
									<button class='schedule'>Schedule</button>
								</a>
							</td>
							<td>$capacity</td>
							<td>$studyload</td>
							<td>
								<button class='withdraw'>Withdraw</button>
							</td>
						</tr>";
                    }
                }
				/* if ($connection) {
            $SQLcheckoverlap = "select * from course where courseID in (select le.courseID from lesson le where le.date in (select date from lesson where courseID='$courseID') and le.courseID in (le.courseID='$courseID'));";
			
select courseID from course where courseID in(SELECT c.courseID FROM course c inner join enrolled_students en on c.courseID=en.courseID where studentID=552301)"			
			
			
			
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
                        echo "$overlap <br/>";
                    }
                }
            } else {
                echo "Database error";
            }
        } */
            }else {
                echo "Database error";
            } 
			
			
			
			
        }

        ?>
		

    </table>
</div>

<?php
?>