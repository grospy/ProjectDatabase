<div class="CSSTableGenerator" >
    <table>
        <tr>
            <td>
                Registration ID
            </td>
            <td>
                Course ID
            </td>
            <td>
                Description
            </td>
            <td>
                Grade
            </td>
            <td>
                Status
            </td>
        </tr>
        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($connection, $number);

            $SQL = "SELECT e.registrationID, e.courseID, c.name, e.grade, e.status FROM enrolledstudent e INNER JOIN course c ON c.courseID=e.courseID WHERE studentID =  $number AND status IS NOT NULL";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        $regID = $data['registrationID'];
                        $courseID = $data['courseID'];
                        $coursename = $data['name'];
                        $grade = $data['grade'];
                        if ($data['status'] == 1 ){
                            $status = "Final";
                        } else {
                            $status = "Resit";
                        }

                        echo "\t\t\t<tr>\n\t\t\t\t<td>$regID</td>\n\t\t\t\t<td>$courseID</td><td>$coursename</td>\n\t\t\t\t<td>$grade</td>\n\t\t\t\t<td>$status</td>\n\t\t\t</tr>\n";
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