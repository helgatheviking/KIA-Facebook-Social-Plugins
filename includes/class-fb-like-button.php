<?php

if( !class_exists( 'KIA_FBSP_Like_Button_Widget' ) )
{
	class KIA_FBSP_Like_Button_Widget extends WP_Widget 
	{

		function KIA_FBSP_Like_Button_Widget()
		{
            $widget_ops = array(
				'classname' 	=> 'cd-fb-like-button-widget',
				'description' 	=> __('Displays a Facebook Like Button', 'kia-fbsp' ),
			);
			
			// Instantiate the parent object
			parent::WP_Widget( false, __('Facebook Like Button', 'kia-fbsp' ), $widget_ops );
			//$this->WP_Widget( 'KIA_FBSP_Like_Button_Widget', __('Facebook Like Button', 'kia-fbsp' ), $widget_ops );
		}
		
		function form( $instance )
		{ 
			$defaults = array(
				'title'			=> 'Like Us on Facebook',
				'url' 			=> null,
				'show_send' 	=> 'on',
				'like_layout' 	=> 'standard',
				'verb' 			=> 'Like',
				'width'			=> 400, 
				'color_scheme' 	=> 'light'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			extract( $instance );

			?>
			<p>
				<label for="cd-fb-title"><?php _e( 'Title:', 'kia-fbsp' ); ?></label>
				<input id="cd-fb-title" class="widefat" name="<?php echo $this-> get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="cd-fb-url"><?php _e( 'URL to Like:', 'kia-fbsp' ); ?></label>
				<input id="cd-fb-url" class="widefat" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
				<span><?php _e("Leave Blank to use the URL for whatever page you are on.",'kia-fbsp');?></span>
			</p>
			<p>
				<input id="cd-fb-send" name="<?php echo $this->get_field_name( 'show_send' ); ?>" type="checkbox" <?php checked( $show_send, 'on' ); ?> />
				<label for="cd-fb-send"><?php _e( 'Check to show the "Send" widget', 'kia-fbsp' ); ?></label>
			</p>
			<p>
				<label for="cd-fb-layout"><?php _e( 'Like Layout:', 'kia-fbsp' ); ?></label>
				<select id="cd-fb-layout" name="<?php echo $this->get_field_name( 'like_layout' ); ?>">
					<option value="standard" <?php selected( $like_layout, 'standard' ); ?>><?php _e( 'Standard', 'kia-fbsp' ); ?></option>
					<option value="button_count" <?php selected( $like_layout, 'button_count' ); ?>><?php _e( 'Button Count', 'kia-fbsp' ); ?></option>
					<option value="box_count" <?php selected( $like_layout, 'box_count' ); ?>><?php _e( 'Box Count', 'kia-fbsp' ); ?></option>
				</select>
			</p>
			<p>
				<input id="cd-fb-faces" name="<?php echo $this->get_field_name( 'show_faces' ); ?>" type="checkbox" <?php checked( $show_faces, 'on' ); ?> />
				<label for="cd-fb-faces"><?php _e( 'Check to show faces', 'kia-fbsp' ); ?></label>
			</p>
			<p>
				<label for="cd-fb-width"><?php _e( 'Width:', 'kia-fbsp' ); ?></label>
				<input id="cd-fb-width" class="widefat" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
			</p>
			<p>
				<label for="cd-fb-verb"><?php _e( 'Verb:', 'kia-fbsp' ); ?></label>
				<select id="cd-fb-verb" name="<?php echo $this->get_field_name( 'verb' ); ?>">
					<option value="like" <?php selected( $verb, 'like' ); ?>><?php _e( 'Like', 'kia-fbsp' ); ?></option>
					<option value="recommend" <?php selected( $verb, 'recommend' ); ?>><?php _e( 'Recommend', 'kia-fbsp' ); ?></option>
				</select>
			</p>
			<p>
				<label for="cd-fb-color"><?php _e( 'Color Scheme:', 'kia-fbsp' ); ?></label>
				<select id="cd-fb-color" name="<?php echo $this->get_field_name( 'color_scheme' ); ?>">
					<option value="light" <?php selected( $color_scheme, 'light' ); ?>><?php _e( 'Light', 'kia-fbsp' ); ?></option>
					<option value="dark" <?php selected( $color_scheme, 'dark' ); ?>><?php _e( 'Dark', 'kia-fbsp' ); ?></option>
				</select>
			</p>
			<?php	
		}
		
		function update( $new_instance, $old_instance )
		{
			$instance = $old_instance;
			$instance['title'] = isset( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['url'] = isset( $new_instance['url'] ) ? esc_url( $new_instance['url'], array( 'http', 'https' ) ) : '';
			$instance['show_send'] = isset( $new_instance['show_send'] ) && $new_instance['show_send'] ? 'on' : 'off';
			$instance['like_layout'] = strip_tags( $new_instance['like_layout'] );
			$instance['show_faces'] = isset( $new_instance['show_faces'] ) && $new_instance['show_faces'] ? 'on' : 'off';		
			$instance['width'] = isset( $new_instance['width'] ) ? absint( $new_instance['width'] ) : 300;
			$instance['verb'] = strip_tags( $new_instance['verb'] );	
			$instance['color_scheme'] = strip_tags( $new_instance['color_scheme'] );		
			
			return $instance;
		}
		
		function widget( $args, $instance )
		{
			extract( $args );   echo $this->limit;
			
			// Get our widget variables
			$title = apply_filters( 'widget_title', $instance['title'] );
			$url =  $instance['url']  ? ' data-href="'.$instance['url'].'"' : ' data-href="'.get_permalink().'"';
			$show_send =  $instance['show_send'] == 'on'  ? ' data-send="true"' : ' ';
			$layout = $instance['like_layout'] == 'standard' ? ' ' : ' data-layout="'. $instance['like_layout'] .'"';

			$faces = $instance['show_faces'] == 'on' ? ' data-show-faces="true"' : ' data-show-faces="false"';

			$width = empty( $instance['width'] ) ? ' data-width="400"' : ' data-width="' . $instance['width'] . '"';
			$verb = ( $instance['verb'] == "like" ) ? ' ' : ' data-action="recommend"';
			$color = $instance['color_scheme'] == 'light' ? ' ' : ' data-colorscheme="dark"';
			
			
			// Render the widget
			echo $before_widget;
			if( !empty( $title ) )
			{
				echo $before_title . $title . $after_title;
			} 

			echo '<div class="fb-like"'  . $url . $show_send . $layout . $faces . $width . $verb . $color . '></div>';
			echo $after_widget;
		}
	} // end class
	
} // end class_exists
?>