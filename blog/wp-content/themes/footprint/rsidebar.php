
<div id="rsidebar">
	<ul>
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>	
	
	<?php wp_list_categories('title_li=<h3>Blog Topics</h3>'); ?>
	
	<li>
		<div class='rssBox'>
		<a href='<?php bloginfo('rss2_url'); ?>' alt='Subscribe to our RSS feed'>
		<img src='/media/images/rss/feed-icon-32x32.png' alt='RSS' />
		<h4>Subscribe via RSS</h4>
		</a>
		</div>
	</li>
	
	<li>
	<h3>Archives</h3>
		<ul>
		<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>
				
	<?php //wp_list_pages('title_li=<h2>Pages</h2>' ); ?>
				
	<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
	<?php //wp_list_bookmarks(); ?>
	<?php } ?> 
	
	<?php endif; ?>
	</ul>
</div>