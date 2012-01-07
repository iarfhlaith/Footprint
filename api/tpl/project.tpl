<?xml version="1.0" encoding="ISO-8859-1"?>

<project xmlns:xlink="http://www.w3.org/1999/xlink">
	
	<id>[~$p.projID~]</id>
	<name>[~$p.name~]</name>
	<date>[~$p.dateCreated~]</date>
	<description>[~$p.description~]</description>
	<tasks xlink:href='/api/tasks/view/?id=[~$p.projID~]'>[~$p.totTasks~]</tasks>
	<screenshots xlink:href='/api/screenshots/view/?id=[~$p.projID~]'>[~$p.totScreenshots~]</screenshots>
	<comments>[~$p.totComments~]</comments>
	<documents xlink:href='/api/screenshots/view/?id=[~$p.projID~]'>[~$p.totDocuments~]</documents>
	<docsize>[~$p.totDocSize~]</docsize>
	<managedby>[~$p.firstname~] [~$p.lastname~]</managedby>
	<clientid>[~$p.userID~]</clientid>
	<clientorg xlink:href='/api/clients/view/?id=[~$p.userID~]'>[~$p.clientOrganisation~]</clientorg>
	
</project>