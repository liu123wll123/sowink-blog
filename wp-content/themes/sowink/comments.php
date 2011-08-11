<?php
// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<div id="comments">
	<ol class="commentlist">
		<?php wp_list_comments('avatar_size=48'); ?>
	</ol>
</div>

<div id="pagination">
	<div class="alignleft"><p><?php previous_comments_link('Older Comments') ?></p></div>
	<div class="alignright"><p><?php next_comments_link('Newer Comments') ?></p></div>
</div>

<?php else :?>
<?php if ( comments_open() ) : ?>

<!-- If comments are open, but there are no comments. -->

<?php else :?>

<!-- If comments are closed. -->

<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">
	<!-- <h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3> -->

	<div class="cancel-comment-reply alignright">
		<?php cancel_comment_reply_link('Cancel Reply'); ?>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
	<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
	<?php if ( is_user_logged_in() ) : ?>
	
		<!-- nothing to see here -->
	
	<?php else : ?>
	
		<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="author"><small>Name <?php if ($req) echo "(required)"; ?></small></label></p>
	
		<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)"; ?></small></label></p>
	
		<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
		<label for="url"><small>Website</small></label></p>
	
	<?php endif; ?>
	
		<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
	
		<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /><?php comment_id_fields(); ?></p>
		<?php do_action('comment_form', $post->ID); ?>
	</form>
	
	<?php endif; ?>
</div> <!-- respond -->

<?php endif; ?>