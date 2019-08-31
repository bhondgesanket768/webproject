<?php
require 'PHPMailerAutoload.php';
//require "crendential.php";

$mailto=$_POST['mail_to'];
$mailsub=$_POST['sub'];
$mailmsgg=$_POST['mssg']; 

$mail = new PHPMailer;

$mail->SMTPDebug = 4;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;     
//$mail->Port = 25;                           // Enable SMTP authentication
$mail->Username = 'bhondgesanket007@gmail.com';                 // SMTP username
$mail->Password = 'fastime007@';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('bhondgesanket007@gmail.com', 'karma');
$mail->addAddress($_POST['mail_to']);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('bhondgesanket007@gmail.com');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $mailsub;
$mail->Body    = '<div><b>This is to notify all of you</b></div>';
$mail->AltBody = $mailmsgg;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}