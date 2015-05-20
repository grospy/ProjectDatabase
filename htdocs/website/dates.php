<?php
require('include/top.php');
?>
<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Date
            </td>
            <td>
                Time start
            </td>
        </tr>
        <?php
        $courseID = $_GET['courseid'];
        require("include/database.php");
        if ($connection) {
            $SQL = "SELECT * FROM lesson WHERE courseid = '$courseID'";
            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        //=============================
                        $date = $data['date'];
                        $time = $data['time_start'];
                        //=============================
                        echo "<tr><td>$date</td><td>$time</td></tr>";
                    }
                }
            } else {
                echo "Database error";
            }
        }

        ?>
    </table>
	<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you take this course :</p>
	
	<div class="overlap">
	<?php
		
		if ($connection) {
            $SQLcheckoverlap = "select concat(courseID,' - ',name) as overlap from course where courseID in (select le.courseID from lesson le where le.date in (select date from lesson where courseID='$courseID') and le.courseID in (le.courseID='$courseID'));";
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
        }
	
	?>
	</div>
	<a href="index.php"><button class="back">Back</button></a>
</div>

<?php
require('include/bot.php');
