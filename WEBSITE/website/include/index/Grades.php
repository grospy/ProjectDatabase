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
                Status
            </td>
        </tr>
        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($connection, $number);

            $SQL = "SELECT e.registrationID, e.courseID, c.name, e.status FROM enrolledstudent e INNER JOIN course c ON c.courseID=e.courseID WHERE e.studentID ='$number'";

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
                        if ($data['status'] == '1' ){
                            $status = "Pass";
                        } else if ($data['status'] == '0' ){
                            $status = "Resit";
                        } else {
							$status = "Pending";
                        }

                        echo "\t\t\t<tr>\n\t\t\t\t<td>$regID</td>\n\t\t\t\t<td>$courseID</td><td>$coursename</td><td>$status</td>\n\t\t\t</tr>\n";
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