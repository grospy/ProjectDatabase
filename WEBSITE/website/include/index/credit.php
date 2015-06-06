<?php
$number = $_SESSION['number'];
$number = htmlspecialchars($number);

if ($connection) {
    $number = quote_smart($connection, $number);
    $SQL = "SELECT SUM(c.studyload) AS total FROM course c INNER JOIN enrolledstudent en ON c.courseID=en.courseID WHERE en.studentID=$number AND en.status IS NULL AND en.registrationID in (SELECT registrationID from registration where current = 1)";
    $SQL2 = "SELECT * FROM registration WHERE current = 1";

    $result = $connection->query($SQL);
    $result2 = $connection->query($SQL2);
    $num_rows = mysqli_num_rows($result);
    $num_rows2 = mysqli_num_rows($result2);

    if ($result) {
        if ($num_rows2 > 0) {
            if ($num_rows > 0) {
                $total = mysqli_result($result, 0, 'total');
                $needed = mysqli_result($result2, 0, 'minimumcredits');
                if ($total > 0) {
                    echo "You have enrolled $total out of the $needed needed credits.<br/>";
                } else {
                    echo "You are not enrolled in any classes.<br/>";
                }
            }
            else {
                echo "You are not enrolled in any classes.<br/>";
            }
        }else {
            echo "Registration not open.<br/>";

        }
    }
}