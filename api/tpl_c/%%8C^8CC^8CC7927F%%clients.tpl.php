<?php /* Smarty version 2.6.14, created on 2008-01-14 01:15:42
         compiled from clients.tpl */ ?>
<?php echo '<?xml'; ?>
 version="1.0" encoding="ISO-8859-1"<?php echo '?>'; ?>


<clients xmlns:xlink="http://www.w3.org/1999/xlink">
	<?php $_from = $this->_tpl_vars['clients']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['clientList'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['clientList']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['c']):
        $this->_foreach['clientList']['iteration']++;
?>
		<client xlink:href='/api/clients/view/?id=<?php echo $this->_tpl_vars['c']['userID']; ?>
'>
			<id><?php echo $this->_tpl_vars['c']['userID']; ?>
</id>
			<name><?php echo $this->_tpl_vars['c']['firstname']; ?>
 <?php echo $this->_tpl_vars['c']['lastname']; ?>
</name>
			<email><?php echo $this->_tpl_vars['c']['email']; ?>
</email>
			<organisation><?php echo $this->_tpl_vars['c']['clientOrganisation']; ?>
</organisation>
			<lastlogin><?php echo $this->_tpl_vars['c']['lastLogin']; ?>
</lastlogin>
		</client>
	<?php endforeach; endif; unset($_from); ?>
</clients>