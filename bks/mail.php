<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
$mail = new PHPMailer; 
$mail->isSMTP();
//$mail->SMTPDebug = 2;
$mail->Host = 'smtp.office365.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'newhire@slnusbaum.com';
$mail->Password = 'N3h!#01!';
$mail->setFrom('newhire@slnusbaum.com', 'slnusbaum');
//$mail->addReplyTo('test@hostinger-tutorials.com', 'Your Name');
$mail->addAddress('support@thinkzag.com', 'support');
$mail->Subject = 'Testing PHPMailer';
$mail->msgHTML('Hello Test Mail', __DIR__);
$mail->Body = 'This is a plain text message body';
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}
?>