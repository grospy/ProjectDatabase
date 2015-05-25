<?php

/*Been Here*/
//===============================================
//==================LOCAL HOST===================
$user_name = "root";
$pass_word = "admin";
$database = "inholland";
$server = "127.0.0.1"; 

//===============================================
//====================WEBSITE====================
//$user_name = "b5_16152360";
//$pass_word = "amadeus1";
//$database = "b5_16152360_inholland";
//$server = "sql201.byethost5.com";


//===============================================
//==================CONNECTION===================

$connection = new mysqli($server, $user_name, $pass_word, $database);