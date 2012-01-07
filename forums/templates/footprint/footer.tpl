        </div>
		
          <div id='sideBar'>
		  	  
			  <br />
		  	  <a href='/forums/register.php?0'>
		  	  <img src='/forums/templates/footprint/images/ask.gif' alt='Ask the Community' />
			  </a>
		  
			  <h3>Forum Actions</h3>
			  
			  <ul class='forumNav'>
			  
				{IF URL->POST}<li><a href="{URL->POST}">{LANG->NewTopic}</a></li>{/IF}
				{IF URL->TOP}<li><a href="{URL->TOP}">{LANG->MessageList}</a></li>{/IF}
				<li><a href="{URL->SEARCH}">{LANG->Search}</a></li>
			  
				{INCLUDE loginout_menu}
				
				{IF NOT LOGGEDIN}
        		<li><a href="/forums/register.php">Register Here</a></li>
				{/IF}
			  
			  </ul>
			  
			  {IF notice_all}
				{IF NEW_PRIVATE_MESSAGES}<a class="PhorumNavLink" href="{URL->PM}">{LANG->NewPrivateMessages}</a><br />{/IF}
				{IF notice_messages}<a class="PhorumNavLink" href="{notice_messages_url}">{LANG->UnapprovedMessagesLong}</a><br />{/IF}
				{IF notice_users}<a class="PhorumNavLink" href="{notice_users_url}">{LANG->UnapprovedUsersLong}</a><br />{/IF}
				{IF notice_groups}<a class="PhorumNavLink" href="{notice_groups_url}">{LANG->UnapprovedGroupMembers}</a><br />{/IF}
			  {/IF}
			  
			  <div class='rssBox'>
				<a href='/forums/rss.php?0' alt='Grab the Forum RSS Feed' class='rssDoc'>Grab the Forum Feed</a>
			  </div>
			  
			  <h3>Main Forums</h3>
			  
			   <ul class='forumNav'>
			  {LOOP FORUMS}
			    {IF FORUMS->folder_flag} {ELSE}
			  	  <li><a href="{FORUMS->url}">{FORUMS->name}</a></li>
				{/IF}
			  {/LOOP FORUMS}
			   </ul>
			  
          </div>
        
		<div class='clear'></div>
		
</div>

<div class='clearFooter'></div>

<div id='footerStrip'>
	
	<div id="footer">
		
		<div class='footerContentL'>
			<p>
				<a href='/'>Footprint</a> is a product of
				<a href='http://www.webstrong.net' target='_blank'>Webstrong Ltd.</a>
				<br />
				<br />
				<a href='mailto:info@footprinthq.com'>Email us with your feedback</a>
				<br />
				<br />
				It's now an <a href='https://github.com/iarfhlaith/Footprint'>open source project hosted on GitHub</a>.
			</p>
		</div>
		
		<div class="footerContentR">
			<p>
				<a href='/api'>Developer API</a> 		|
				<a href='/privacy'>Privacy Policy</a>   |
				<a href='/terms'>Terms of Service</a>
			<br />
			<br />
				Blog powered by  <a target='_blank' href='http://www.wordpress.org/'>WordPress</a> |
				Forum powered by <a target='_blank' href='http://www.phorum.org'>Phorum</a>
			<br /><br />
			Copyright &copy; 2007 - 2012.
			</p>
			
		</div>

		<div class="clear"></div>
	
	</div>
	
</div>
	
  </body>
</html>