<?php
$number = $_SESSION['number'];
$number = htmlspecialchars($number);

if ($connection) {
    $number = quote_smart($connection, $number);
    $SQL = "select sum(c.studyload) as total from course c inner join enrolled_students en on c.courseID=en.courseID where en.studentID=$number";

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