
{IF LOGGEDIN true}
	<li><a href="{URL->REGISTERPROFILE}">{LANG->MyProfile}</a></li>
	{IF ENABLE_PM}
	  <li><a href="{URL->PM}">{LANG->PrivateMessages}</a></li>
	{/IF}
	<li><a href="{URL->LOGINOUT}">{LANG->LogOut}</a></li>
{ELSE}
	<li><a href="{URL->LOGINOUT}">{LANG->LogIn}</a></li>
{/IF}