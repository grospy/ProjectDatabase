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
    <?php echo showStudents()?>





</div>