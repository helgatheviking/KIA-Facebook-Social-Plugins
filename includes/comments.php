<?php
	
// Do not delete these lines

if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e( 'This post is password protected. Enter the password to view comments.', 'fb_social_widgets' ); ?></p>

<?php return; } ?>

<?php if ( 'open' == $post->comment_status ) : ?>

<div id="respond">

<?php

$options = get_option('facebook_social_options');
$comments_title = empty($options['comments_title']) ?  __( 'Leave a Reply', 'fb_social_widgets') : $options['comments_title'] ;
$comments_width = empty($options['comments_width']) ?  500 : $options['comments_width'] ;
$color = empty($options['color']) ?  '' : $options['color'] ;
$num_comments = empty($options['num_comments']) ?  5 : $options['num_comments'] ;


if($comments_title){ ?>
	<h3><?php echo $comments_title; ?></h3>
<?php }	?>
	
	<div class="fb-comments" data-href="<?php echo get_permalink();?>" data-num-posts="<?php echo $posts;?>" data-width="<?php echo $comments_width;?>" <?php if($color=='dark') echo 'data-colorscheme="'.$color.'"';?>></div>

	<div class="fix"></div>

</div><!-- /#respond -->

<?php endif; // if you delete this the sky will fall on your head ?>