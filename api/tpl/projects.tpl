<?xml version="1.0" encoding="ISO-8859-1"?>

<projects xmlns:xlink="http://www.w3.org/1999/xlink">
	[~ foreach name=projectList item=p from=$projects ~]
		<project xlink:href='/api/projects/view/?id=[~$p.projID~]'>
			<id>[~$p.projID~]</id>
			<name>[~$p.name~]</name>
			<date>[~$p.dateCreated~]</date>
			<description>[~$p.description~]</description>
			<managedby>[~$p.firstname~] [~$p.lastname~]</managedby>
			<clientid>[~$p.userID~]</clientid>
			<clientorg xlink:href='/api/clients/[~$p.userID~]'>[~$p.clientOrganisation~]</clientorg>
		</project>
	[~ /foreach ~]
</projects>
