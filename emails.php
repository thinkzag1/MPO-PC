<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php'; 

$servername = "localhost";
$username = "admin_mpo";
$password = "production1";
$dbname = "admin_mpo";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM ContactUsExpressSearchIndexAttributes where sent=0 and exEntryID>6731";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    	$mail='';
	  $mail.='Name:'.$row['ak_your_name'];
	  $mail.='<br>Email:'.$row['ak_your_email'];
	  $mail.='<br>Phone:'.$row['ak_your_phone_number'];
	  $mail.='<br>Message:'.$row['ak_your_message'];
	  echo '<br>'.$sql = "UPDATE ContactUsExpressSearchIndexAttributes SET sent=1 WHERE  exEntryID=".$row['exEntryID'];
	  $conn->query($sql);
	  mailsend($mail);
	  
  }
} 



function mailsend($msg){


$to = 'admin@mpopc.com';
//$to = 'ankitfriend07@gmail.com';
//$to = 'support@thinkzag.com';
$subject = ' Contact EMail';
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
$message = $msg;

//echo $message .= '</body></html>';
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

$mail->addBcc('thinkzag1@gmail.com', 'support');
$mail->Subject = $subject;
$mail->msgHTML($message, __DIR__);
$mail->Body = $message;
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}
}
?>