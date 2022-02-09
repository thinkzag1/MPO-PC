<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
$to = 'anna.basurto@mpopc.com';
//$to = 'support@thinkzag.com';
$subject = ' Estate and trust Landing Page Form Submission Received';
$from = 'info@mpopc.com';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
$a['YOURNAME']='Your Name';
$a['LNAME']='Last Name';
$a['YOUREMAILADDRESS']='Email';
$a['YOURNAME']='Your Name';
$a['YOURPHONENUMBER']='Phone Numaber';
$a['Comment']='Comment';
$message = '<html><body>';
foreach ($_REQUEST as $k=>$v){
	if($k=='Comment'){
	$k='Tell us About your Case';
	}
	if($k=='YOURNAME'){
	$k='First Name';
	}
	if($k=='LNAME'){
	$k='Last Name';
	}
	if($k=='YOUREMAILADDRESS'){
	$k='Email';
	}
	if($k=='YOURPHONENUMBER'){
	$k='Phone';
	}
	
$message .= $k.': '.$v.'<br>';
}
echo $message .= '</body></html>';
 // Sending email


$mail = new PHPMailer; 
$mail->isSMTP();
//$mail->SMTPDebug = 2;
$mail->Host = 'smtp.office365.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'admin@mpopc.com';
$mail->Password = 'Ad#582or';
$mail->setFrom('admin@mpopc.com', 'MPOPC');
//$mail->addReplyTo('test@hostinger-tutorials.com', 'Your Name');
$mail->addAddress($to, 'Admin');

//$mail->addBcc('support@thinkzag.com', 'support');
$mail->Subject = $subject;
$mail->msgHTML($message, __DIR__);
$mail->Body = $message;
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}


header("Location: ../thankyou.php");
