<?xml version="1.0" encoding="ISO-8859-1"?>

<client xmlns:xlink="http://www.w3.org/1999/xlink">
	
	<id>[~$c.userID~]</id>
    <username>[~$c.username~]</username>
    <contact>[~$c.firstname~] [~$c.lastname~]</contact>
    <email>[~$c.email~]</email>
    <lastlogin>[~$c.lastLogin~]</lastlogin>
    <totlogins>[~$c.totLogins~]</totlogins>
    <date>[~$c.createdOn~]</date>
    <organisation>[~$c.clientOrganisation~]</organisation>
	<projects>
	[~ foreach name=projectList item=p from=$projects ~]
		<project xlink:href='/api/projects/view/?id=[~$p.projID~]'>
			<id>[~$p.projID~]</id>
			<name>[~$p.name~]</name>
			<date>[~$p.dateCreated~]</date>
			<description>[~$p.description~]</description>
			<managedby>[~$p.firstname~] [~$p.lastname~]</managedby>
		</project>
	[~ /foreach ~]
	</projects>
</client>