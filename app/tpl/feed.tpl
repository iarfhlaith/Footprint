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
