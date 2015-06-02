<?php
$number = $_SESSION['number'];
$number = htmlspecialchars($number);

if ($connection) {
    $number = quote_smart($connection, $number);
    $SQL = "SELECT SUM(c.studyload) AS total FROM course c INNER JOIN enrolledstudent en ON c.courseID=en.courseID WHERE en.studentID=$number AND en.status IS NULL";

    $result = $connection->query($SQL);
    $num_rows = mysqli_num_rows($result);
    if ($result) {
        if ($num_rows > 0) {
            $data = $result->fetch_array();
            $total = $data['total'];
            if($total > 0){echo "You have enrolled ".$total." out of 60 credits.<br/>";}
            else {echo "You are not enrolled in any classes.<br/>";}
        }
    }
}