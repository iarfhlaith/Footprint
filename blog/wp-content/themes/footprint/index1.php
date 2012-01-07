<?php get_header(); ?>

	<div id="overview">

	<?php if ( $paged < 2 ) { // Do stuff specific to first page?>

	<?php $my_query = new WP_Query('category_name=featured&showposts=1');
	while ($my_query->have_posts()) : $my_query->the_post();
	$do_not_duplicate = $post->ID; ?>

	<h2 class="sectionhead"><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="Main Content RSS Feed" title="Main Content RSS Feed" style="float:right;margin: 2px 0 0 5px;" /></a>Feature Article</h2>
	
	<div class="featurepost" id="post-<?php the_ID(); ?>">
							
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>
	
		<p class="postinfo">By <?php the_author_posts_link(); ?> on <?php the_time('M j, Y') ?> in <?php the_category(', ') ?> | <?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?><?php edit_post_link('Edit', ' | ', ''); ?></p>
	
		<div class="entry">
		<?php the_content('Read the rest'); ?>
		</div>

	</div>
  	
<?php endwhile; ?>

<h2 class="sectionhead">
	<a href="<?php bloginfo('rss2_url'); ?>">
	<img src="<?php bloginfo('stylesheet_directory'); ?>/images/rss.gif" alt="Main Content RSS Feed" title="Main Content RSS Feed" style="float:right;margin: 2px 0 0 5px;" />
	</a>Recent Articles
</h2>

<?php if (have_posts()) : while (have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

				<div class="post" id="post-<?php the_ID(); ?>">

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> on <?php the_time('M j, Y') ?> in <?php the_category(', ') ?> | <?php comments_popup_link('0 Comments', '1 Comment', '% Comments'); ?><?php edit_post_link('Edit', ' | ', ''); ?></p>

					<div class="entry">
						<?php the_content('Read the rest'); ?>
					</div>

				</div>

<?php endwhile; endif; ?>

<?php } else { // Do stuff specific to non-first page ?>

			<div id="overview">
	
				<h2 class="sectionhead">Recent Articles</h2>

<?php if (have_posts()) : while (have_posts()) : the_post();
if( $post->ID == $do_not_duplicate ) continue; update_post_caches($posts); ?>

				<div class="post" id="post-<?php the_ID(); ?>">

					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?> &raquo;</a></h2>

					<p class="postinfo">By <?php the_author_posts_link(); ?> on <?php the_time('M j, Y') ?> | In <?php the_category(', ') ?> | <?php comments_popup_link('No Comments &raquo;', '1 Comment &raquo;', '% Comments'); ?><?php edit_post_link('Edit', ' | ', ''); ?></p>

					<div class="entry">
						<?php the_content('<strong>Read the rest &raquo;</strong>'); ?>
					</div>

				</div>

<?php endwhile; endif; ?>

<?php } ?>

				<div class="navigation">

					<div class="alignleft">
						<?php next_posts_link('&laquo; Previous Entries') ?>
					</div>

					<div class="alignright">
						<?php previous_posts_link('Next Entries &raquo;') ?>
					</div>

                		</div>

			</div>

		</div>

<?php get_sidebar(); ?>

	</div>

	<div class='clear'></div>

</div>

<?php get_footer(); ?>