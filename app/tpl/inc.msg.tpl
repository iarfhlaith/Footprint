<div class='notice [~$message.class~]' id='message'>
	<div class='close'>
		<a href='#'><img src='/app/media/images/icons/close.png' alt='Close' /></a>
	</div>
	<h2>[~$message.message~]</h2>
	 <p>[~$message.details~]</p>
	[~if $message.options~]
		<ul>
		[~ foreach name=optsList item=o from=$message.options ~]
			<li><a href='[~$o.link~]'>[~$o.text~]</a></li>
		[~/foreach~]
		</ul>
	[~/if~]
</div>