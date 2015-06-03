<form method="post">
    <input type="text" name="string">
    <input type="submit" name="submit">
</form>
<?php
if(isset($_POST["submit"])){
    $string = $_POST['string'];
    $string .= "AMADEUS";
    echo md5($string);
}