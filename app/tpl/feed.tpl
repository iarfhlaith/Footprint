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
<?xml version="1.0" encoding="iso-8859-1"?><rss version="2.0">
<channel>
	<title>[~$user.organisation~]</title>
	<description>Recent Activity RSS Feed</description>
	<link>https://[~$user.prefix~].footprinthq.com</link>
	<language>en-us</language>
	
	[~ foreach name=activityList item=a from=$activity ~]
	<item>
		<title>[~ $a.comment|strip_tags ~] ([~ $a.eventDate|date_format ~])</title>
		<link>https://[~$user.prefix~].footprinthq.com</link>
		<pubDate>[~ $a.eventDate|date_format_rss ~]</pubDate>
	</item>
	[~/foreach~]
	
</channel>
</rss>
