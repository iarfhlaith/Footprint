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
