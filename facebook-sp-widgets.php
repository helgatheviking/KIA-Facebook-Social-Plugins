<?php
/*
Plugin Name: KIA Facebook Social Plugins
Plugin URI: http://www.kathyisawesome.com
Description: Adds open graph tags, like button, facebook commpents and three facebook social plugins as wordpress widgets: Facebook Recommendations, Facebook Activity Feed, and the Facebook Like Box using Facebook's SDK
Version: 1.1
Author: Kathy Darling
Author URI: http://www.kathyisawesome.com
License: GPL2

    Copyright 2012  Kathy Darling  (email: kathy.darling@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

    This plugin is basically an update of Facebook Social Plugin Widgets by Christopher Davis
    Author URI: http://www.christopherguitar.net

*/


// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}



if (!class_exists("KIA_Facebook_Social_Widgets")) :

class KIA_Facebook_Social_Widgets {

  function KIA_Facebook_Social_Widgets(){
    // Include required files
    $this->includes();

    // Set-up Action and Filter Hooks
    register_activation_hook(__FILE__, array(__CLASS__,'add_defaults_options'));
    register_uninstall_hook(__FILE__, array(__CLASS__,'delete_plugin_options'));

    add_action('admin_init', array(__CLASS__,'init' ));
    add_action('admin_menu', array(__CLASS__,'add_options_page'));
    add_action('admin_print_scripts-settings_page_facebook-social-widgets', array(__CLASS__,'enqueue_scripts'));

    add_action('admin_footer-settings_page_facebook-social-widgets', array(__CLASS__,'print_scripts'));
    add_filter( 'plugin_action_links', array(__CLASS__,'add_action_links'), 10, 2 );
    add_action( 'wp_footer', array(__CLASS__,'print_script' ));
    add_filter( 'language_attributes', array(__CLASS__,'ie_fix'), 99 );
    add_action( 'widgets_init', array(__CLASS__,'register_widgets' ));
    add_filter('comments_template', array(__CLASS__,'facebook_comments'));
    add_action( 'wp_head', array(__CLASS__,'open_graph'), 5 );
    add_filter('the_content', array(__CLASS__,'like_button'));
  }




  /**
   * Include Required Files
   **/
  function includes() {

    $includes = array ( 'includes/class-fb-like.php',
              'includes/class-fb-recommends.php',
              'includes/class-fb-activity.php'
              );
    
    foreach ($includes as $include) require $include;

  }


  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'add_defaults_options')
  // ------------------------------------------------------------------------------

  // Define default option settings
  function add_defaults_options() {
    if(get_option('kia_facebook_social_options')) return false;

    $defaults = array( 
              "comments_title" => __( 'Leave a Reply', 'fb_social_widgets'),
              "comments_width" => "500",
              "comments_color_scheme" => "light",
              "num_comments" => "5",
              "like_layout" => "standard",
              "like_color_scheme" => "light",
              "like_width" => "500",
              "like_verb" => "like"
      );
      update_option('kia_facebook_social_options', $defaults);
  }


  // --------------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'delete_plugin_options')
  // --------------------------------------------------------------------------------------

  // Delete options table entries ONLY when plugin deactivated AND deleted
  function delete_plugin_options() {
    $options = get_option('kia_facebook_social_options', true);
    if(isset($options['delete'])) delete_option('kia_facebook_social_options');
  }



  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: add_action('admin_init', 'init' )
  // ------------------------------------------------------------------------------

  // Init plugin options to white list our options
  function init(){
    register_setting( 'kia_facebook_social_options', 'kia_facebook_social_options', array(__CLASS__,'validate_options') );
  }

  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: add_action('admin_menu', 'add_options_page');
  // ------------------------------------------------------------------------------

  // Add menu page
  function add_options_page() {
    add_options_page('Facebook Social Widgets Options Page', 'Facebook Social Widgets', 'manage_options', 'facebook-social-widgets', array(__CLASS__,'render_form'));
  }


  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: add_action('admin_print_footer_scripts-settings_page_facebook-social-widgets', array(__CLASS__,'enqueue_scripts'));
  // ------------------------------------------------------------------------------
  
  function enqueue_scripts(){
      //We can include as many Javascript files as we want here.
       wp_enqueue_script('jquery');
       wp_enqueue_script('jquery-ui-core');
       wp_enqueue_script('jquery-ui-tabs');
  }

  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION FOR: add_action('admin_footer-settings_page_facebook-social-widgets', array(__CLASS__,'print_scripts'));
  // ------------------------------------------------------------------------------


  function print_scripts(){ ?>
      <script>
        jQuery(document).ready(function($){
          $( "#tabs" ).tabs();
        });
        </script>
    <?php
  }

  // ------------------------------------------------------------------------------
  // CALLBACK FUNCTION SPECIFIED IN: add_options_page()
  // ------------------------------------------------------------------------------

  // Render the Plugin options form
  function render_form() {
    include('includes/plugin-options.php');
  }

  // Sanitize and validate input. Accepts an array, return a sanitized array.
  function validate_options($input) {

    $clean = array();

     // strip html from textboxes
    $clean['app_id'] =  wp_filter_nohtml_kses($input['app_id']); // Sanitize textbox input (strip html tags, and escape characters)
    $clean['delete'] =  isset( $input['delete'] ) ? 'true' : 'false' ;  //checkbox

    $clean['display_comments'] =  isset( $input['display_comments'] ) ? 'true' : 'false' ;  //checkbox
    $clean['comments_title'] =  wp_filter_nohtml_kses($input['comments_title']); // Sanitize textbox input (strip html tags, and escape characters)
    $clean['comments_color_scheme'] =  ($input['comments_color_scheme'] == 'dark') ? 'dark' : 'light'; //radio
    $clean['comments_width'] =  absint($input['comments_width']); // Sanitize textbox input (force number)
    $clean['num_comments'] =  absint($input['num_comments']); // Sanitize textbox input (force number)

    $clean['display_like'] =  isset( $input['display_like'] ) ? 'true' : 'false' ;  //checkbox
    $clean['like_send'] =  isset( $input['like_send'] ) ? 'true' : 'false' ;  //checkbox

    $allowed = array('standard','button_count','box_count');

    $clean['like_faces'] =  isset( $input['like_faces'] ) ? 'true' : 'false' ;  //checkbox
    $clean['like_layout'] = in_array($input['like_layout'], $allowed) ? $input['like_layout'] : 'standard';
    $clean['like_color_scheme'] =  ($input['like_color_scheme'] == 'dark') ? 'dark' : 'light'; //radio
    $clean['like_width'] =  absint($input['like_width']); // Sanitize textbox input (force number)
    $clean['like_verb'] =  ($input['like_verb'] == 'recommends') ? 'recommends' : 'like'; //radio

    return $clean;
  }

  // Display a Settings link on the main Plugins page
  function add_action_links( $links, $file ) {

    if ( $file == plugin_basename( __FILE__ ) ) {
      $posk_links = '<a href="'.admin_url('options-general.php?page=facebook-social-widgets').'">'.__('Settings').'</a>';
      // make the 'Settings' link appear first
      array_unshift( $links, $posk_links );
    }

    return $links;
  }


  /**
   * Prints out the Facebook JavaScript code.
   */
  function print_script()  {
    $options = get_option('kia_facebook_social_options');
    $app_id = empty($options['app_id']) ? ' ' : 'appId='.$options['app_id'] ;
      
  ?>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1<?php echo $app_id;?>";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <?php
    
  }

  /**
  * IE doesn't render facebook XFBML unless it finds a certain attribute on the <head>
  * tag. This takes care of that.
  */
   
  function ie_fix( $atts )  {
    // if the string already has what we need, bail
    if( preg_match( '/xmlns:fb="(.*)"/', $atts ) ) return $atts;
    $atts .= ' xmlns:fb="http://ogp.me/ns/fb#"';

    if( preg_match( '/xmlns:og="(.*)"/', $atts ) ) return $atts;
    $atts .= ' xmlns:og="http://opengraphprotocol.org/schema/"';

    return $atts;
  }

  /**
  * Register the widget here to make sure we get the right class...
  */
  function register_widgets(){
      register_widget( 'KIA_FBSP_Like_Widget' );
      register_widget( 'KIA_FBSP_Recommends_Widget' );
      register_widget( 'KIA_FBSP_Activity_Widget' );
  }

  /**
  * Use our template instead of comments.php
  */
  function facebook_comments( $file ) {
    $options = get_option('kia_facebook_social_options');

    if($options['display_comments']=="true") {
      $file = plugin_dir_path(__FILE__) . '/includes/comments.php';
    }
    return $file;
  }

  /**
  * Lets add Open Graph Meta Info
  */

  function open_graph() {
    global $post;

    $options = get_option('kia_facebook_social_options');
    $app_id = empty($options['display_like']) ? ' ' : 'appId='.$options['app_id'] ;

    if ( !is_singular()) return; //if it is not a post or a page
          echo '<meta property="fb:admins" content="YOUR USER ID"/>';
          echo '<meta property="og:title" content="' . get_the_title() . '"/>';
          echo '<meta property="og:type" content="article"/>';
          echo '<meta property="og:url" content="' . get_permalink() . '"/>';
          echo '<meta property="og:site_name" content="Your Site NAME Goes HERE"/>';
    if(has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
       $thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
      echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
    }
    echo "\n";
  }

  /**
  * Filter in the Like Button
  */
  function like_button($content){
    $options = get_option('kia_facebook_social_options');

    if($options['display_like']=="true") {
      $send = $options['like_send'];  
      $layout = $options['like_layout'];
      $width = $options['like_width'];
      $faces = $options['like_faces'];
      $verb = $options['like_verb'];
      $color = $options['like_color_scheme'];

      $content = sprintf('<div class="fb-like" style="margin-bottom: 1em;" data-send="%s" data-layout="%s" data-width="%s" data-show-faces="%s" data-action="%s" data-colorscheme="%s"></div>', $send, $layout, $like_width, $faces, $verb, $color) . $content;
    }
    return $content;
  }

} // end class
endif;

/**
* Launch the whole plugin
*/
global $fb_social_widgets;
if (class_exists("KIA_Facebook_Social_Widgets") && !$fb_social_widgets) {
    $fb_social_widgets = new KIA_Facebook_Social_Widgets(); 
} 
?>