<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to boilerplate_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p><?php _e( 'This post is password protected. Enter the password to view any comments.', 'boilerplate' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<!-- STARKERS NOTE: The following h3 id is left intact so that comments can be referenced on the page -->
			<h3 id="comments-title"><?php
				printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'boilerplate' ),
				number_format_i18n( get_comments_number() ), '' . get_the_title() . '' );
			?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'boilerplate' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'boilerplate' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol>
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use boilerplate_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define boilerplate_comment() and that will be used instead.
					 * See boilerplate_comment() in boilerplate/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'boilerplate_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<?php previous_comments_link( __( '&larr; Older Comments', 'boilerplate' ) ); ?>
				<?php next_comments_link( __( 'Newer Comments &rarr;', 'boilerplate' ) ); ?>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

	<?php
	/* If there are no comments and comments are closed, let's leave a little note, shall we?
	 * But we only want the note on posts and pages that had comments in the first place.
	 */
	if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'boilerplate' ); ?></p>
	<?php endif;  ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
