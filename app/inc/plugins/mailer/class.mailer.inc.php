<?php
class mailer
{  
	var $headers;      // An array of headers
	var $recipients;   // An array of recipients
	var $subject;      // The message subject
	var $message;      // The message body
    
	function html()
	{
		$this->headers[]  = "MIME-Version: 1.0";
		$this->headers[]  = "Content-type: text/html; charset=iso-8859-1";
	}
    
	function from($email, $name)
	{	// Sets who the email was from
		@ini_set('sendmail_from','info@footprintapp.com');
		$this->headers[] = 'From: '.$name.' <'.$email.'>';
	}
    
	function add_recipient($email)
	{	// Adds a recipient in the to: field
		$this->recipients[] = $email;
	}
    
	function add_cc($email)
	{	//Adds a carbon copy address
		$this->headers[] = 'CC: '.$email;
	}
    
	function add_bcc($email)
	{	//Adds a blind carbon copy address
		$this->headers[] = 'BCC: '.$email;
	}

	function subject($subject)
	{	//Sets the message subject
		$this->subject = $subject;
	}
    
	function message($message)
	{	//Sets the message body
		$this->message = $message;
	}
    
	function custom_header($headername, $headervalue)		
	{	//Adds a custom header
		$this->headers[] = $headername.': '.$headervalue;
	}
    
	function send()		
	{	//sends the email
		$recipients_separated = implode(",", $this->recipients);
		$headers = "";
		foreach($this->headers as $header)
		{
			$headers .= $header . "\r\n";
		}
		return mail($recipients_separated, $this->subject, $this->message, $headers);
	}   
}
?>