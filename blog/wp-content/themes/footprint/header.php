<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	
	<meta name="description" content="The Footprint Blog is for posting news on anything and everything. Watch this space for upcoming releases." />
	<meta name="keywords" content="blog, news, updates, staff, next release, feature, footprint, tech stuff" />
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="/css/screen.css" />
	
	<?php wp_head(); ?>
</head>
<body>

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
	
	<div id='blogSearch'>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	</div>
	
	<h1>Our Blog</h1>

	<h2>Tips &amp; Tricks from the Footprint HQ</h2>
	
	</div>
	
</div>

<div id='navStrip'>
	
		<div id='navContent'>
		
		<ul class="topLevel">
			<li><a href="/">Home</a></li>
			<li><a href="/features">Features</a></li>
			<li><a href="/tour">Tour</a></li>
			<li><a href="/cases">Case Studies</a></li>
			<li class='active'><a href="/blog">Blog</a></li>
			<li><a href="/help">Help/FAQs</a></li>
			<li><a href="/pricing">Pricing &amp; Sign Up</a></li>
			<li><a href="/forums">Forums</a></li>
			<li><a href="/about">About</a></li>
		</ul>
		
		</div>
	
</div>

<div id="content">