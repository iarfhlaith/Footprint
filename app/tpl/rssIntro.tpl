<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Subscribe to your Activity Feed - [~$user.organisation~] - Footprint</title>
	
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="cache-control" value="no-cache, no store, must-revalidate">
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/app/css/screen.css" />
	
	<script type="text/javascript" src="/app/jscript/plugins/jQuery.js"></script>
	
	<script type="text/javascript">

	$(document).ready(function()
	{

  	});
	
	</script>
	
	<style type="text/css">
		[~include file='inc.css.tpl'~]
	</style>
	
</head>

<body>

[~include file='inc.nav.tpl'~]

<div id='content'>
	
	<h1 id='headerSettings'>Never Miss an Update Again with RSS</h1>
	
	<div id='clearBox'>
	
		<p>
		Stay up to date on all your account activity directly within your favourite
		RSS reader. The <span class='highlight'>feed is secure and protected</span> with your username and password.
		Use the link below to subscribe to your feed.
		</p>
		
		<div class='textBox'>
		<a href='/app/feed/?[~$user.rssKey~]' class='docType rss' target='_blank'>https://[~$user.prefix~].footprintapp.com/app/feed/?[~$user.rssKey~]</a>
		</div>
		
		<p>
			When you view or add your feed in your rss reader you will be prompted to enter the same
			username and password that you enter when logging into your account. <strong> You must use
			a reader that supports HTTP Authentication</strong> in order for it to work.
		</p>
		
		<p><br /><br /><br /></p>
		
	</div>
	
	<div id='infoPanel'>
		
		<h2>Compatible Readers</h2>
		
		<ul>		
			<li>
				<img align='absmiddle' src='/app/media/images/icons/page.gif' />
				<a href='http://www.feedreader.com/' target='_blank'>Feedreader</a></li>
			<li>
				<img align='absmiddle' src='/app/media/images/icons/page.gif' />
				<a href='http://www.newsgator.com/Individuals/NewsGatorOnline/Default.aspx'>Newsgator</a></li>
			<li>
				<img align='absmiddle' src='/app/media/images/icons/page.gif' />
				<a href='http://www.mozilla.com/thunderbird/'>Thunderbird</a></li>
		</ul>
		
		<p class='smallText'>
			Make sure your RSS Reader supports authentication. Some readers like Google Reader and Bloglines
			don't support this and as a result, they won't work with your activity feed.
		</p>
		
		<ul>		
			<li>
				<img align='absmiddle' src='/app/media/images/icons/page.gif' />
				<a href='http://www.whatisrss.com/' target='_blank'>What is RSS?</a></li>
		</ul>
		
		<p class='smallText'>
			<strong>Tip:</strong> make sure your reader doesn't publish your feed to a place that's publicly
			available.
		</p>
	
	</div>
	
	<div class='clear'></div>

</div>

[~include file='inc.end.tpl'~]

</body>
</html>
