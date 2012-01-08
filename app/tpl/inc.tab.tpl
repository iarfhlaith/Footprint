[~*
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
*~]
<div class='tabs'>

	<ul>
	
	  <li>[~if $settings1~]<strong>[~/if~] <a href='/app/settings1.php'>User Profile</a>     	[~if $settings1~]</strong>[~/if~]</li>	
		
	[~if $user.perms.manage_colours_logos~]	  
	  <li>[~if $settings2~]<strong>[~/if~] 	  <a href='/app/settings2.php'>Colours</a> [~if $settings2~]</strong>[~/if~]</li>
	  <li>[~if $settingsLogo~]<strong>[~/if~] <a href='/app/settingsLogo.php'>Logo</a> [~if $settingsLogo~]</strong>[~/if~]</li>
	[~/if~]

	[~if $user.perms.manage_import_export~]
	  <li>[~if $settings3~]<strong>[~/if~] <a href='/app/settings3.php'>Import[~*/Export*~]</a>       [~if $settings3~]</strong>[~/if~]</li>
	[~/if~]
	
	[~if $user.perms.manage_api~]
	  <li>[~if $settings4~]<strong>[~/if~] <a href='/app/settings4.php'>API</a>       			[~if $settings4~]</strong>[~/if~]</li>
	[~/if~]
	
	  <li>[~if $settings5~]<strong>[~/if~] <a href='/app/settings5.php'>OpenID</a>     [~if $settings5~]</strong>[~/if~]</li>	
	 
	</ul>
	
	<div class='clear'></div>
	
</div>
