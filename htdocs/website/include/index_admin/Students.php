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



    <?php
    if (isset($_POST["submit"])) {
        $filecheck = basename($_FILES['file']['name']);
        $ext = strtolower(substr($filecheck, strrpos($filecheck, '.') + 1));
        if (!($ext == "csv")) {
            echo "file must be csv type";
        } else {
            $file = $_FILES['file']['tmp_name'];
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $handle = fopen($file, "r");
            $row = 1;
            if ($handle !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);

                    $student_number = $data[0];
                    $first_name = $data[1];
                    $last_name = $data[2];
                    $row++;
                    $sql = "INSERT INTO student (student_number, first_name, last_name) VALUES ('$student_number','$first_name','$last_name')";
                    if ($connection->query($sql) === TRUE) {
                        echo "Succeed adding $student_number, $first_name, $last_name! <br/>";
                    } else {
                        echo "fail!";
                        //can be many causes: duplicate studentID, has to be csv
                        //need sql transaction commit and rollback
                        //NOTICE! change your email, password,set_code DEFAULT to NULL in your database!
                        break;
                    }
                }
                fclose($handle);
            }
        }
    }


    ?>

</div>