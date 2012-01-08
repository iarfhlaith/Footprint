<?php
/**
 * Footprint
 *
 * A project management tool for web designers.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package Footprint
 * @author Iarfhlaith Kelly
 * @copyright Copyright (c) 2007 - 2012, Iarfhlaith Kelly. (http://iarfhlaith.com/)
 * @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link http://footprintapp.com
 * @since Version 1.0
 * @filesource
 */
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