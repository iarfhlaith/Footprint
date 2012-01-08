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
 *
 * 
 * 
 *******************************************************************
 *
 * What does this script do?
 *
 *******************************************************************
 * 
 * This script attempts to bill all paying Footprint customers using the stored credit card
 * or token information in the accounts table within the system. It manages failed charge attempts
 * and executes the appropriate action depending on whether the charge attempt was successful or not.
 * It also logs all activity, issues invoices, notify's the administrator with a summary report and disbales
 * accounts as it sees fit.
 *
 *
 * Run this script at 10.00am GMT every day (and no other time).
 * Fetch all paid accounts in the database that are due for a payment.
 * i.e. Accounts that signed up on this day, 1 through to 28 (29,30,31 are all charged on the 28th of the month) in a previous month.
 * OR (if the account has been marked as a failed last payment AND the timestamp annex brings the payment up to today)
 * 
 * Example: Original Timestamp = 123456789 = March 23, 2009
 * Example: Annex = 3 days = 60*60*24*3 = 259200
 * Example: Original Timestamp + Annex = 123456789 + 259200 = 123715989
 * Example: If new timestamp = this day of the month then attempt a charge on that too.
 * 
 * Database structure for this needs to be:
 * *** accountID, signup_date (integer), last_payment_failed (boolean), last_payment_annex (integer), last_payment_failed_attempts ***
 * 
 * Loop through each one and attempt to charge each of their credit cards for the amount in their account.
 * Depending on their account type and subscribed resources.
 * 
 * If the attempted charge was successful, then generate a PDF invoice receipt, email the customer, and update the database.
 * 
 * If the payment failed then check how many attempts have been made to make this payment.
 * 
 * If it's the 1st failure then send an email to customer (request they review CC data) and try again in 3 days or as soon as the CC details are updated.
 * If it's the 2nd failure then send another email to customer (request they review CC data) and try again in 3 days or as soon as the CC details are updated.
 * If it's the 3rd failure then LOCK THE ACCOUNT (other then to update the billing information) and try again in 3 days or as soon as the CC details are updated.
 * If it's the 4th failure then email the customer and try again in 15 days or as soon as the CC details are updated. 
 * If it's the 5th failure then email the customer, hide the account completely and mark it for manual deletion.
 * 
 * After each failure update the last_payment_failed field and mark it as true. Then update the last_payment_annex according to the rules above.
 * Then increase the last_payment_failed_attempts by one.
 * 
 * 
 * Possible snag points in this are:
 * 
 * 1. Catching days that were signed up on the 29th, 30th, and 31st of the month.
 * 
 * 2. Making sure that adding the annex and the signup_date together doesn't screw up things relating to dates close to the end of the month.
 * 
 * 3. What happens if this script is run more then once in 24 hours? Make sure it doesn't re-bill accounts etc.
 * 
 * Important points
 * 
 * 1. Log both failed and successful payment attempts.
 * 2. Log all email communications with the customer.
 * 3. Send a billing report to ik@webstrong.ie after the script has been run.
 *    -  Show the number of successfully billed accounts (summary only)
 *    -  Show the number of failed accounts (and why)
 *    -  Show the number of accounts marked for deletion (which ones)
 *    -  Show the total value of the billed accounts (show me the money!)
 * 4. Store the PDF invoice.
 * 
 */

// Ensure this Script is Run via the Command Line

// Initialise Billing Gateway
// Initialise Required Classes

// Load All Paying Accounts (method)

// Loop Through Each One (foreach())

	// Attempt to Charge Account (gateway call)
	
	// If Successful 
		
		// Generate PDF Invoice
		
		// Send Notification Email (with PDF attachment) to Account Owner
		
		// Update Database with Payment Details
		
		// Store a Copy of the PDF Invoice
	
	// If NOT Successful
	
		// Check how many attempts have been made to make this payment
		
		// If this is the first 
		
			// Send Email to Customer
			
			// Mark the Database with an Annex value of 259200 (3 days) and increase the payment attempts by one.
		
		// If this is the second
		
			// Send Email to Customer
			
			// Mark the Database with an Annex value of 518400 (6 days) and increase the payment attempts by one.
		
		// If this is the third
		
			// Send Email to Customer
			
			// Lock the Account but allow the account owner to login and update their CC details
			
			// Mark the Database with an Annex value of 777600 (9 days) and increase the payment attempts by one.
		
		// If this is the fourth
		
			// Send Email to Customer
			
			// Mark the Database with an Annex value of 1296000 (15 days) and increase the payment attempts by one.
		
		// If it is the fifth
		
			// Email the Customer that their account has been deleted.
			
			// Hide the account completely and mark for manual deletion.
	
	// End If
	
	// Save the Sent Email into the logs

// End Loop

// Send Summary Email to ik@webstrong.ie






	
	
	



?>