<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//get data from form

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// preparing mail content
$messagecontent ="Name = ". $name . "<br>Email = " . $email . "<br>Message =" . $message;


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
//     $phpmailer = new PHPMailer();
// $phpmailer->isSMTP();
// $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
// $phpmailer->SMTPAuth = true;
// $phpmailer->Port = 2525;
// $phpmailer->Username = 'd4b18f3a03356f';
// $phpmailer->Password = '72098f748ce0ae';
//     //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'd4b18f3a03356f';                     //SMTP username
    $mail->Password   = '72098f748ce0ae';                               //SMTP password
   // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('iamusmanshehu@gmail.com', 'Mailer');
    $mail->addAddress('iamusmanshehu@gmail.com', 'Usman Shehu');     //Add a recipient
    $mail->addAddress('iamusmanshehu@gmail.com');               //Name is optional
    $mail->addReplyTo($email, 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments

    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('photo.jpeg', 'photo.jpeg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = $messagecontent;
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
   // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}