<?php get_header(); ?>

	<div id="overview">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle">Search Results</h2>

		<?php while (have_posts()) : the_post(); ?>

			<div class="entry">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>
				<br /><br />
				<?php the_content_rss('more', TRUE, '', 50); ?>
				<br /><br />
				
				<p class="postmetadata">
					Posted in <span class="cty"><?php the_category(', ') ?></span>
					by <?php the_author() ?> | <?php edit_post_link('Edit', '', ' | '); ?>
					<span class="cmt"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
				</p>
				
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
		</div>

	<?php else : ?>
	<div class="entry">
		<h2 class="center">No posts found. Try a different search?</h2>

</div>
	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<div class='clear'></div>

</div>

<?php get_footer(); ?>