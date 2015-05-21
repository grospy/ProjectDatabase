<?php
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>
<div class="CSSTableGenerator">
    Upload a .csv file :
    <form name="import" method="post" enctype="multipart/form-data">
        <input type="file" name="file"/><br/>
        <input type="submit" name="submit" value="Submit"/>
    </form>
    <?php
    addStudents();
    ?>
    <br/><br/>
    <button onclick='function1("Students")'>Show students</button>
    <div id='lightStudents' class='white_content'>
        <div class="CSSTableGenerator">
            <table>
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        ID
                    </td>
                </tr>
                <?php
                if ($connection) {

                    $SQL = "SELECT * FROM student;";

                    $result = $connection->query($SQL);

                    $rows = mysqli_num_rows($result);

                    //for sorting
                    /* $results = array();
                     while ($row = mysqli_fetch_array($result)) {
                         $results[] = $row['courseID'];
                     }*/

                    for ($x = 0; $x < $rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        $name = $data['first_name'];
                        $number = $data['student_number'];
                        echo "<tr><td>$name</td><td>$number</td></tr>";
                    }

                } else {
                    echo "Database error";
                }

                ?>
            </table>
        </div>
        <button class='back' onclick='function2("Students")'>Close</button>
    </div>





</div>