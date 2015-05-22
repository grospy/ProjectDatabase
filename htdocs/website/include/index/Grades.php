<div class="CSSTableGenerator" >
                    <table>
                        <tr>
                            <td>
                                Course ID
                            </td>
                            <td>
                                Year
                            </td>
                            <td>
                                Term
                            </td>
                            <td>
                                Grade
                            </td>
                        </tr>
        <?php
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($connection, $number);

            $SQL = "SELECT * FROM grade WHERE student_number =  $number";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        $courseID = $data['courseID'];
                        $year = $data['year'];
                        $term = $data['term'];
                        $grade = $data['grade'];
                        echo "\t\t\t<tr>\n\t\t\t\t<td>$courseID</td>\n\t\t\t\t<td>$year</td>\n\t\t\t\t<td>$term</td>\n\t\t\t\t<td>$grade</td>\n\t\t\t</tr>\n";
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