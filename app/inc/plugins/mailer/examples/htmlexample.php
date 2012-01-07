<?php

$mail = new mailer;
$mail->from('SITE_WEBMASTER_EMAIL', 'AASMIC Webmaster');
$mail->add_recipient($email);//add a recipient in the to: field
$mail->html();
$mail->subject('Email confirmation for '.$email);//set subject
$message = '<h1>This is a test!</h1>';
$mail->message($message);//set message body
$mail->send(); 
			  
?>