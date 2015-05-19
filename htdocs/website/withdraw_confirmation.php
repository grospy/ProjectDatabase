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
