<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments">This post is password protected. Enter the password to view comments.<p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'odd';
?>

<!-- You can start editing here. -->

<a name='comments'></a>
<div class="boxcomments">

<?php if ($comments) : ?>

<?php 

	/* Count the totals */
	$numPingBacks = 0;
	$numComments  = 0;

	/* Loop through comments to count these totals */
	foreach ($comments as $comment) {
		if (get_comment_type() != "comment") { $numPingBacks++; }
		else { $numComments++; }
	}

?>

<?php 

	/* This is a loop for printing comments */
	if ($numComments != 0) : ?>

	<h2 id="commenthead">
		<?php comments_number('No Comments Yet', 'One Comment So Far', '% Comments So Far' );?>
	</h2>

	<ol class="commentlist">
	
		<?php foreach ($comments as $comment) : ?>
		<?php if (get_comment_type()=="comment") : ?>
		
		<li class="<?php if ( $comment->comment_author_email == get_the_author_email() ) echo 'mycomment'; else echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
			<?php if ($comment->comment_approved == '0') : ?>
			<em>Your comment is awaiting moderation.</em>
			<?php endif; ?>
			<?php comment_text() ?>
			<p style="margin-bottom:5px;">By <strong><?php comment_author_link() ?></strong> on <a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('M j, Y') ?></a> <?php edit_comment_link('Edit',' | ',''); ?></p>
		</li>
			
		<?php /* Changes every other comment to a different class */	
		if ('alt' == $oddcomment) $oddcomment = '';
		else $oddcomment = 'odd';
		?>
		
		<?php endif; endforeach; ?>
	
	</ol>
	
	<?php endif; ?>

<?php

	/* This is a loop for printing trackbacks if there are any */
	if ($numPingBacks != 0) : ?>

	<ol class="tblist">

	<li style="background:transparent;padding-left:0;"><h2 id="trackbacks"><?php _e($numPingBacks); ?> Trackback(s)</h2></li>
	
<?php foreach ($comments as $comment) : ?>
<?php if (get_comment_type()!="comment") : ?>

	<li id="comment-<?php comment_ID() ?>">
		<?php comment_date('M j, Y') ?>: <?php comment_author_link() ?>
		<?php if ($comment->comment_approved == '0') : ?>
		<em>Your comment is awaiting moderation.</em>
		<?php endif; ?>
	</li>
	
	<?php if('odd'==$thiscomment) { $thiscomment = 'even'; } else { $thiscomment = 'odd'; } ?>
	
<?php endif; endforeach; ?>

	</ol>

<?php endif; ?>
	
<?php else : 

	/* No comments at all means a simple message instead */ 
?>

<?php endif; ?>

<?php if (comments_open()) : ?>
	
	<?php if (get_option('comment_registration') && !$user_ID ) : ?>
		<p id="comments-blocked">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=
		<?php the_permalink(); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<h3 id="respond">Post a Comment</h3>

	<?php if ($user_ID) : ?>
	
	<p>You are logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php">
		<?php echo $user_identity; ?></a>. To logout, <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">click here</a>.
	</p>
	
<?php else : ?>	
	
		<p><label for="author">Name<?php if ($req) _e(' (required)'); ?></label>
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /></p>
				
		<p><label for="email">E-mail (will not be published)<?php if ($req) _e(' (required)'); ?></label>
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" size="22" /></p>		
		
		<p><label for="url">Website</label>
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /></p>
	
	<?php endif; ?>

		<p><textarea name="comment" id="comment" cols="5" rows="10" tabindex="4"></textarea></p>

		<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
	
	<?php do_action('comment_form', $post->ID); ?>

	</form>

<?php endif; // If registration required and not logged in ?>

<?php else : // Comments are closed ?>
	<p id="comments-closed">Sorry, comments for this entry are closed at this time.</p>
<?php endif; ?></div>