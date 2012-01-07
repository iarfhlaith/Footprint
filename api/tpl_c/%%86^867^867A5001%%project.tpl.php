<?php /* Smarty version 2.6.14, created on 2008-01-14 00:54:30
         compiled from project.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>


<project xmlns:xlink="http://www.w3.org/1999/xlink">
	
	<id><?php echo $this->_tpl_vars['p']['projID']; ?>
</id>
	<name><?php echo $this->_tpl_vars['p']['name']; ?>
</name>
	<date><?php echo $this->_tpl_vars['p']['dateCreated']; ?>
</date>
	<description><?php echo $this->_tpl_vars['p']['description']; ?>
</description>
	<tasks xlink:href='/api/tasks/view/?id=<?php echo $this->_tpl_vars['p']['projID']; ?>
'><?php echo $this->_tpl_vars['p']['totTasks']; ?>
</tasks>
	<screenshots xlink:href='/api/screenshots/view/?id=<?php echo $this->_tpl_vars['p']['projID']; ?>
'><?php echo $this->_tpl_vars['p']['totScreenshots']; ?>
</screenshots>
	<comments><?php echo $this->_tpl_vars['p']['totComments']; ?>
</comments>
	<documents xlink:href='/api/screenshots/view/?id=<?php echo $this->_tpl_vars['p']['projID']; ?>
'><?php echo $this->_tpl_vars['p']['totDocuments']; ?>
</documents>
	<docsize><?php echo $this->_tpl_vars['p']['totDocSize']; ?>
</docsize>
	<managedby><?php echo $this->_tpl_vars['p']['firstname']; ?>
 <?php echo $this->_tpl_vars['p']['lastname']; ?>
</managedby>
	<clientid><?php echo $this->_tpl_vars['p']['userID']; ?>
</clientid>
	<clientorg xlink:href='/api/clients/view/?id=<?php echo $this->_tpl_vars['p']['userID']; ?>
'><?php echo $this->_tpl_vars['p']['clientOrganisation']; ?>
</clientorg>
	
</project>