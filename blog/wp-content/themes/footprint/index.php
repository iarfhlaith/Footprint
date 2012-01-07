<?php get_header(); ?>

	<div id="overview">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
		<div class="entry">
			<div id="post-<?php the_ID(); ?>">
			
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small title="<?php the_time('Y-m-d\TH:i:sO'); ?>"><?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?></small>
				<br /><br /><?php the_content(); ?><br />
				<p class="postmetadata">
					Posted in <span class="cty"><?php the_category(', ') ?></span>
					by <?php the_author() ?> | <?php edit_post_link('Edit', '', ' | '); ?>
					<span class="cmt"><?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></span>
				</p>
				
			</div>
		</div>
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('<span class="prev"> Previous Entries</span>') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries <span class="next">&nbsp;</span>') ?></div>
		</div>

	<?php else : ?>
		<div class="entry">
			<h2>Not Found</h2>
			Sorry, but you are looking for something that isn't here.
		</div>

	<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<div class='clear'></div>

</div>

<?php get_footer(); ?>
