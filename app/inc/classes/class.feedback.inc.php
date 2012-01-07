<?php
/**
 * Project:     Footprint - Project Collaboration for Web Designers
 * File:        class.feedback.inc.php
 *
 * Please do not copy or distribute this code without prior consent
 * from Webstrong Ltd.
 *
 * This software is protected under Irish Copyright Law.
 *
 * For questions, help, comments, discussion, etc., please visit the
 * Footprint Site Forums. @link http://www.footprintapp.com/forums
 *
 * @link 		http://www.footprintapp.com/
 * @copyright 	2007-2008 Webstrong Ltd
 * @author 		Iarfhlaith Kelly <ik at webstrong dot ie>
 * @package 	Footprint
 * @version 	1.0
 */

/**
 * @package Footprint
 *
 */ 
class feedback
{
   /**
    * The variables submitted in the form
    *
    * @var 	public object
    */
	private $vars;

   /**
    * The unique ID of the feedback submitted to the database
    *
    * @var 	public object
    */
	private $feedbackID;
	
   /**
    * The class constructor.
    */
	public function __construct(){}

   /**
    * Gets the form variables submitted
    *
	* @access 	public
	* @return 	array - Returns the form variables
    */
	public function getFormVars()
	{
		return($this->vars);
	}
	
   /**
    * Sets the form variables submitted
	*
	* @param array $vars - An array of the form variables submitted
	*
	* @access 	public
	* @return 	void
    */
	public function setFormVars($vars)
	{
		$this->vars = $vars; 
	}
	
   /**
    * Gets the feedbackID
    *
	* @access 	public
	* @return 	array - Returns the feedbackID
    */
	public function getFeedbackID()
	{
		return($this->feedbackID);
	}
	
   /**
    * Sets the feedbackID
	*
	* @param array $feedbackID - The unique ID of the submitted feedback
	*
	* @access 	public
	* @return 	void
    */
	public function setFeedbackID($id)
	{
		$this->feedbackID = $id; 
	}
	
   /**
    * Save the feedback in the database
	*
	* Dependant on: class.db.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function save()
	{
		// Timestamp
		$timestamp = time();
		
		$vars = $this->getFormVars();
		
		$dbh    = dbConnection::get()->handle();
		
		// Add Feedback Table
		$sql = "INSERT INTO app_feedback
				 ( userID
				 , subject
				 , comment
				 , referrer
				 , createdOn
				 )
				 
				VALUES
				 ('{$vars['user']['userID']}'
				 ,'{$vars['subject']}'
				 ,'{$vars['comments']}'
				 ,'{$vars['referrer']}'
				 ,'{$timestamp}')";
		
		$affected =& $dbh->exec($sql);
		if (PEAR::isError($affected)) return(false);
		
		// Fetch FeedbackID
		$id = $dbh->lastInsertID('app_feedback', 'id');
		
		$this->setFeedbackID($id);
		
		return(true);
	}
	
   /**
    * Send a receipt to the user explaining that the feedback has been received.
	*
	* Dependant on: class.mailer.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function sendReceipt()
	{
		$vars       = $this->getFormVars();
		$feedbackID = $this->getFeedbackID();
		
		// Load Email Text
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/feedback.receipt.txt');
		
		// Merge Variables into Email
		$email = str_replace('[~firstname~]'  , $vars['user']['firstname']	, $email);
		$email = str_replace('[~feedbackID~]' , $feedbackID	  		  		, $email);
		
		// Send Reset Email
		$mail = new mailer;
		$mail->from(SUPPORT_EMAIL, SUPPORT_NAME);
		$mail->add_recipient($vars['user']['email']);
		$mail->subject('[Footprint #'.$feedbackID.'] - User Feedback Received');
		$mail->message($email);
		$mail->send();
		
		return(true);
	}
	
   /**
    * Send a receipt to the user explaining that the feedback has been received.
	*
	* Dependant on: class.mailer.inc.php
	*
	* @access 	public
	* @return 	boolean
	*/
	public function notify()
	{
		$vars       = $this->getFormVars();
		$feedbackID = $this->getFeedbackID();
		
		// Load Email Text
		$email = file_get_contents(APP_ROOT.'/inc/emails/english/feedback.notify.txt');
		
		// Load Person's Name
		$name  = $vars['user']['firstname'].' '.$vars['user']['lastname'];
		
		// Merge Variables into Email
		$email = str_replace('[~name~]'       , $name 			 		, $email);
		$email = str_replace('[~comment~]'    , $vars['comments']		, $email);
		$email = str_replace('[~subject~]'    , $vars['subject'] 		, $email);
		$email = str_replace('[~email~]'      , $vars['email']   		, $email);
		$email = str_replace('[~org~]'        , $vars['organisation']   , $email);
		$email = str_replace('[~userID~]'     , $vars['userID']         , $email);
		$email = str_replace('[~feedbackID~]' , $feedbackID	  	 		, $email);
		$email = str_replace('[~prefix~]'     , $vars['prefix']	 		, $email);
		
		// Send Reset Email
		$mail = new mailer;
		$mail->from(SUPPORT_EMAIL, SUPPORT_NAME);
		$mail->add_recipient(SUPPORT_EMAIL);
		$mail->subject('[Footprint #'.$feedbackID.'] - User Feedback Received');
		$mail->message($email);
		$mail->send();
		
		return(true);
	}

}
?>