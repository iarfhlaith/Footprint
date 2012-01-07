{IF CHARSET}
<?php
  header("Content-Type: text/html; charset=".htmlspecialchars($PHORUM['DATA']['CHARSET']))
?>
{/IF}
<?php echo '<?' ?>xml version="1.0" encoding="{CHARSET}"<?php echo '?>' ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html lang="<?php echo $PHORUM['locale']; ?>">
  <head>
  	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/screen.css" />
    <style type="text/css">
      {INCLUDE css}
    </style>
    {IF URL->RSS}
      <link rel="alternate" type="application/rss+xml" title="RSS-Feed" href="{URL->RSS}" />
    {/IF}
    {IF URL->REDIRECT}
      <meta http-equiv="refresh" content="{IF REDIRECT_TIME}{REDIRECT_TIME}{ELSE}5{/IF}; url={URL->REDIRECT}" />
    {/IF}
    {LANG_META}
    <title>{HTML_TITLE}</title>
    {HEAD_TAGS}
  </head>
  <body onload="{IF FOCUS_TO_ID}var focuselt=document.getElementById('{FOCUS_TO_ID}'); if (focuselt) focuselt.focus();{/IF}">
    <div id='container'>
	
	<div id='head'>
	  <ul id='names'>
		<li id='fp'><a href='/'>Footprint</a></li>
		<li id="fpTopPlain"><span>Built by:</span></li>
		<li id='ws'><a href='http://www.webstrong.net'>Webstrong</a></li>
	  </ul>
	</div>
	
	<div id='bannerStripReg'>
		<div id="bannerContentReg">
		
		<h1>{TITLE}</h1>
	
		<h2>Share stories. Ask questions.</h2>
		
		</div>
	</div>
	
	<div id='navStrip'>
		<div id='navContent'>
		
		<ul class="topLevel">
			<li><a href="/">Home</a></li>
			<li><a href="/features">Features</a></li>
			<li><a href="/tour">Tour</a></li>
			<li><a href="/cases">Case Studies</a></li>
			<li><a href="/blog">Blog</a></li>
			<li><a href="/help">Help/FAQs</a></li>
			<li><a href="/pricing">Pricing &amp; Sign Up</a></li>
			<li class='active'><a href="/forums">Forums</a></li>
			<li><a href="/about">About</a></li>
		</ul>
		
		</div>
	</div>

	<div id='forumContent'>
	
	<div id="overview">
	
		<div id='forumName'>
			{IF NAME}
	  		  <h2><a href='/forums'>Forums</a> &raquo; <a href="{URL->TOP}">{NAME}</a></h2>
			{/IF}
		</div>