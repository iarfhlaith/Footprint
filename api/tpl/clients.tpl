<?xml version="1.0" encoding="ISO-8859-1"?>

<clients xmlns:xlink="http://www.w3.org/1999/xlink">
	[~ foreach name=clientList item=c from=$clients ~]
		<client xlink:href='/api/clients/view/?id=[~$c.userID~]'>
			<id>[~$c.userID~]</id>
			<name>[~$c.firstname~] [~$c.lastname~]</name>
			<email>[~$c.email~]</email>
			<organisation>[~$c.clientOrganisation~]</organisation>
			<lastlogin>[~$c.lastLogin~]</lastlogin>
		</client>
	[~ /foreach ~]
</clients>