<?php

$mail = new mailer;
$mail->from('sender@example.com', 'Sender');
$mail->add_recipient('person1@example.com');//add a recipient in the to: field
$mail->add_cc('person2@example.com');//carbon copy
$mail->add_bcc('person3@example.com');//blind carbon copy
$mail->subject('Test');//set subject
$mail->message('Hi,

FILLER
---------------------------------------------
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
The quick brown fox jumped over the lazy dog.
---------------------------------------------

Thank You!
');//set message body
$mail->send();//send email(s)
?>