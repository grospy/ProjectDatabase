<button id="printSchedule" onClick="printSchedule()">Print schedule</button>

<div class="CSSTableGenerator" id="printthis">
    <table >
		<tr>
            <td>
                Description
            </td>
            <td >
                Day
            </td>
            <td >
                Date
            </td>
            <td>
                Time
            </td>
            <td>
                Instructor
            </td>
            <td>
                Room
            </td>
        </tr>

        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($connection,$number);

            $SQL = 	"select c.name, dayname(l.date) as day, DATE_FORMAT(l.date, '%b %e, \'%y') as date, DATE_FORMAT(l.time_start,'%I:%i') as time_start, concat(p.firstName,' ',p.lastName) as instructor, l.roomnumber from course c inner join lesson l on c.courseID=l.courseID inner join teacher te on te.courseID=c.courseID inner join person p on p.personID=te.teacherID inner join enrolledstudent s on s.courseID=l.courseID WHERE s.studentID=$number AND s.status IS NULL order by l.date ASC, l.time_start ASC;";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        $description = $data['name'];
                        $day = $data['day'];
                        $date = $data['date'];
                        $time = $data['time_start'];
                        $instructor = $data['instructor'];
                        $room = $data['roomnumber'];
                        echo "<tr>
							<td>$description</td>
							<td>$day</td>
							<td>$date</td>
							<td>$time</td>
							<td>$instructor</td>
							<td>$room</td>
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
?>