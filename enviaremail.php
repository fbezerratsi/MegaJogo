<?php 
ini_set('error_reporting', E_ALL);

$Name = "Da Duder"; //senders name 
$email = "felipe.musicrn@gmail.com"; //senders e-mail adress 
$recipient = "felipe.musicrn@gmail.com"; //recipient 
$mail_body = "The text for the mail..."; //mail body 
$subject = "Subject for reviever"; //subject 
$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields 

if( mail($recipient, $subject, $mail_body, $header) ){
    echo 'enviou!';
} //mail command :)

echo 'oi';


phpinfo();
?>