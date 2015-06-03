<?php
include 'class.phpmailer.php';
include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded



$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "lehlouisle@gmail.com";
$mail->Password = "GMA_Jlle96*";
$mail->SetFrom("lehlouisle@gmail.com");
$mail->Subject = "Test";
$mail->Body = "hello";
$mail->AddAddress("lehlouisle@gmail.com");
 if(!$mail->Send())
 {
     echo "Mailer Error: " . $mail->ErrorInfo;
 }
 else
 {
     echo "Message has been sent";
 }