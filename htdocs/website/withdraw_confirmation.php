<?PHP
session_start();
if ($_SESSION['login'] != md5("1")) {
    header("Location: login.php");
}
require("include/top.php");
   require("include/database.php");
$number = $_SESSION['number'];
$courseID = $_GET['courseid'];


?>

<div class="confirmation_message">
   <h3 align="center">Are you sure to withdraw from : </h3>
        <?php
       
     
        if ($connection) {
			$courseNameSQL = "SELECT name FROM course WHERE courseid = '$courseID'";
			$resultCourseName = $connection->query($courseNameSQL);
			$resultCourseName->data_seek(0);
			$data = $resultCourseName->fetch_array();
			$courseName = $data['name'];
			echo "
				<div class='schedule_header'>
					<h1> $courseID - $courseName </h1>
				</div>
				
				";
			}
			
           else {
                echo "Database error";
            }

        ?>
    
	<p id='overlap_message'>The course(s) below will be UNAVAILABLE if you take this course :</p>
	
	<div class="overlap">
	<?php
		
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
                        echo "$overlap <br/>";
                    }
                }
            } else {
                echo "Database error";
            }
        }
	
	?>
	</div>
	<p>
	<center>
	<a href="index.php"><button class="back">Cancel</button></a>
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
			<input type="submit" name="delete" class="back" value="
			<?php
			if (isset($_POST['delete'])) {
				$withdrawSQL = "delete from enrolled_students where courseID='$courseID' and studentID= '$number';";
				if ($connection->query($withdrawSQL) === TRUE) {
					echo "Withdraw successful!";
				}
			} else {
				echo "Withdraw";
			}
			?>"></input>
		</form>	
		
	</center>
	</p>
</div>
<?php
	
		
require('include/bot.php');
