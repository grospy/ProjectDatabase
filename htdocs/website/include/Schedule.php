<div class="CSSTableGenerator" >
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
        <!--------------------------------------------------------------------->

        <?php
        require("database.php");
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);

            $SQL = 	"select c.name, dayname(l.date) as day, l.date, l.time_start, concat(em.first_name,' ',em.last_name) as instructor, l.room_number from course c inner join lesson l on c.courseID=l.courseID inner join teacher te on te.courseID=c.courseID inner join employee em on em.employee_number=te.employee_number inner join enrolled_students s on s.courseID=l.courseID where s.studentID='$number' order by l.date ASC, l.time_start ASC";
			
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
						$room = $data['room_number'];
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