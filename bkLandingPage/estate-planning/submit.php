<?php
$to = 'anna.basurto@mpopc.com';
$subject = 'Lead Form Received';
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
$message .= $k.': '.$v.'<br>';
}
$message .= '</body></html>';
 
// Sending email
if(mail($to, $subject, $message, $headers)){
	mail('support@thinkzag.com', $subject, $message, $headers);
	mail('nikita04virag@gmail.com', $subject, $message, $headers);
    mail('ankitfriend07@gmail.com', $subject, $message, $headers);
    header("Location: index.php"); 
}
