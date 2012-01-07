<?php /* Smarty version 2.6.14, created on 2008-01-14 09:09:39
         compiled from client.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>


<client xmlns:xlink="http://www.w3.org/1999/xlink">
	
	<id><?php echo $this->_tpl_vars['c']['userID']; ?>
</id>
    <username><?php echo $this->_tpl_vars['c']['username']; ?>
</username>
    <contact><?php echo $this->_tpl_vars['c']['firstname']; ?>
 <?php echo $this->_tpl_vars['c']['lastname']; ?>
</contact>
    <email><?php echo $this->_tpl_vars['c']['email']; ?>
</email>
    <lastlogin><?php echo $this->_tpl_vars['c']['lastLogin']; ?>
</lastlogin>
    <totlogins><?php echo $this->_tpl_vars['c']['totLogins']; ?>
</totlogins>
    <date><?php echo $this->_tpl_vars['c']['createdOn']; ?>
</date>
    <organisation><?php echo $this->_tpl_vars['c']['clientOrganisation']; ?>
</organisation>
	<projects>
	<?php $_from = $this->_tpl_vars['projects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['projectList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['projectList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['p']):
        $this->_foreach['projectList']['iteration']++;
?>
		<project xlink:href='/api/projects/view/?id=<?php echo $this->_tpl_vars['p']['projID']; ?>
'>
			<id><?php echo $this->_tpl_vars['p']['projID']; ?>
</id>
			<name><?php echo $this->_tpl_vars['p']['name']; ?>
</name>
			<date><?php echo $this->_tpl_vars['p']['dateCreated']; ?>
</date>
			<description><?php echo $this->_tpl_vars['p']['description']; ?>
</description>
			<managedby><?php echo $this->_tpl_vars['p']['firstname']; ?>
 <?php echo $this->_tpl_vars['p']['lastname']; ?>
</managedby>
		</project>
	<?php endforeach; endif; unset($_from); ?>
	</projects>
</client>