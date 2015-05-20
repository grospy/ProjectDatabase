<?php
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>
<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Course
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
        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($connection, $number);

            //ALL
            $SQL = "SELECT * FROM course";
            //AVAILABLE
            $SQL1 = "select * from course where courseID not in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number')));";
            //OVERLAP
            $SQL2 = "select * from course where courseID in (select le.courseID from lesson le where concat(le.date,le.time_start) in (select concat(date,time_start) from lesson where courseID in (select courseID from enrolled_students where studentID='$number'))) and courseID not in (select courseID from enrolled_students where studentID='$number');";
            //ENROLLED
            $SQL3 = "SELECT * FROM course c inner join enrolled_students en on c.courseID=en.courseID where studentID=$number";

            $result = $connection->query($SQL);
            $result1 = $connection->query($SQL1);
            $result2 = $connection->query($SQL2);
            $result3 = $connection->query($SQL3);

            $rows = mysqli_num_rows($result);

            $results = array();
            while ($row = mysqli_fetch_array($result)) {
                $results[] = $row['courseID'];
            }
            $results1 = array();
            while ($row1 = mysqli_fetch_array($result1)) {
                $results1[] = $row1['courseID'];
            }
            $results2 = array();
            while ($row2 = mysqli_fetch_array($result2)) {
                $results2[] = $row2['courseID'];
            }
            $results3 = array();
            while ($row3 = mysqli_fetch_array($result3)) {
                $results3[] = $row3['courseID'];
            }
            $x1 = $x2 = $x3 = 0;
            for ($x = 0; $x < $rows; $x++) {
                if (in_array($results[$x], $results1)) {
                    renamethisfunction(0, $result1, $x1, $number, $connection);
                    $x1++;
                }
                if (in_array($results[$x], $results2)) {
                    renamethisfunction(1, $result2, $x2, $number, $connection);
                    $x2++;
                }
                if (in_array($results[$x], $results3)) {
                    renamethisfunction(2, $result3, $x3, $number, $connection);
                    $x3++;
                }
            }
        } else {
            echo "Database error";
        }

        ?>


    </table>
</div>