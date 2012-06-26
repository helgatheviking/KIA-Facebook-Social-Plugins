<div class="wrap">
  <div id="tabs">

  <style>
    #nav-tabs { overflow: hidden; margin: 0 0 -1px 0;} 
    #nav-tabs li { float: left; margin-bottom: 0;} 
    .ui-tabs-nav a { color: #aaa;}
    #nav-tabs li.ui-state-active a { border-bottom: 2px solid white; color: #464646; }
    h2.nav-tab-wrapper { margin-bottom: 1em;}
  </style>

  <!-- Display Plugin Icon, Header, and Description -->
  <?php screen_icon(); ?>

  <h2 class="nav-tab-wrapper">
    <ul id="nav-tabs">
      <li><a class="nav-tab" href="#general"><?php _e('General','fb_social_widgets');?></a></li>
      <li><a class="nav-tab" href="#comments"><?php _e('Comments','fb_social_widgets');?></a></li>
      <li><a class="nav-tab" href="#like"><?php _e('Like Button','fb_social_widgets');?></a></li>
    </ul>
  </h2>

  <!-- Beginning of the Plugin Options Form -->
  <form method="post" action="options.php">
    <?php settings_fields('kia_facebook_social_options'); ?>
    <?php $options = get_option('kia_facebook_social_options');?>

    <div id="general">
        <fieldset>
          <h3><?php _e('General Facebook Social Settings','fb_social_widgets');?></h3>
              <table class="form-table">
                    <tr>
                      <th scope="row"><?php _e('Enter Your App ID');?></th>
                      <td>
                        <input type="text" size="57" name="kia_facebook_social_options[app_id]" value="<?php echo $options['app_id']; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <th scope="row"><?php _e('Completely remove options on plugin removal');?></th>
                      <td>
                        <input type="checkbox" name="kia_facebook_social_options[delete]" value="1" <?php checked($options['delete'], 'true');?> />
                      </td>
                    </tr>
                  </table>
          </fieldset>
      </div>

      <div id="comments">
            
        <fieldset>
          <h3><?php _e('Facebook Comments Settings','fb_social_widgets');?></h3>
          <table class="form-table">
        <tr>
            <th scope="row"><?php _e('Replace your comments with Facebook Comments','fb_social_widgets');?></th>
            <td>
              <input type="checkbox" name="kia_facebook_social_options[display_comments]" value="1" <?php checked($options['display_comments'], 'true');?>/>
            </td>
          </tr>
        <tr>
            <th scope="row"><?php _e('Comments Title','fb_social_widgets');?></th>
            <td>
              <input type="text" size="57" name="kia_facebook_social_options[comments_title]" value="<?php echo $options['comments_title']; ?>" />
            </td>
          </tr>

        <tr>
            <th scope="row"><?php _e('Width of Facebook Comments','fb_social_widgets');?></th>
            <td>
              <input type="text" size="10" maxlength="4"  name="kia_facebook_social_options[comments_width]" value="<?php echo $options['comments_width']; ?>" />
            </td>
          </tr>

        <tr>
           <th scope="row"><?php _e('Color Scheme','fb_social_widgets');?></th>
           <td>
             <input type="radio" name="kia_facebook_social_options[comments_color_scheme]" value="light" <?php checked($options['comments_color_scheme'], 'light');?>/> Light
             <input type="radio" name="kia_facebook_social_options[comments_color_scheme]" value="dark" <?php checked($options['comments_color_scheme'], 'dark');?>/> Dark
           </td>
        </tr>

        <tr>
            <th scope="row"><?php _e('Number of Comments to Display','fb_social_widgets');?></th>
            <td>
              <input type="text" size="57" maxlength="4" name="kia_facebook_social_options[num_comments]" value="<?php echo $options['num_comments']; ?>" />
            </td>
          </tr>  

        </table>

      </div>

      <div id="like">
        <fieldset>
          <h3><?php _e('Like Button Settings','fb_social_widgets');?></h3>

          <table class="form-table">
            <tr>
            <th scope="row"><?php _e('Add Facebook Like Button','fb_social_widgets');?></th>
            <td>
              <input type="checkbox" name="kia_facebook_social_options[display_like]" value="1" <?php checked($options['display_like'], 'true');?>/>
            </td>
          </tr>

           <tr>
            <th scope="row"><?php _e('Include Send Button','fb_social_widgets');?></th>
            <td>
              <input type="checkbox" name="kia_facebook_social_options[like_send]" value="1" <?php checked($options['display_comments'], 'true');?>/>
            </td>
          </tr>

          <tr>
           <th scope="row"><?php _e('Like Button Layout','fb_social_widgets');?></th>
           <td>
             <input type="radio" name="kia_facebook_social_options[like_layout]" value="standard" <?php checked($options['like_layout'], 'standard');?>/> Standard
             <input type="radio" name="kia_facebook_social_options[like_layout]" value="button_count" <?php checked($options['like_layout'], 'button_count');?>/> Button Count
             <input type="radio" name="kia_facebook_social_options[like_layout]" value="box_count" <?php checked($options['like_layout'], 'box_count');?>/> Box Count
           </td>
        </tr>

         <tr>
            <th scope="row"><?php _e('Include Faces','fb_social_widgets');?></th>
            <td>
              <input type="checkbox" name="kia_facebook_social_options[like_faces]" value="1" <?php checked($options['like_faces'], 'true');?>/>
            </td>
          </tr>


        <tr>
            <th scope="row"><?php _e('Width of Facebook Like Button','fb_social_widgets');?></th>
            <td>
              <input type="text" size="10" maxlength="4" name="kia_facebook_social_options[like_width]" value="<?php echo $options['like_width']; ?>" />
            </td>
          </tr>

        <tr>
           <th scope="row"><?php _e('Like Color Scheme','fb_social_widgets');?></th>
           <td>
             <input type="radio" name="kia_facebook_social_options[like_color_scheme]" value="light" <?php checked($options['like_color_scheme'], 'light');?>/> <?php _e('Light','fb_social_widgets');?>
             <input type="radio" name="kia_facebook_social_options[like_color_scheme]" value="dark" <?php checked($options['like_color_scheme'], 'dark');?>/> <?php _e('Dark','fb_social_widgets');?>
           </td>
        </tr>

        <tr>
           <th scope="row"><?php _e('Like Verb','fb_social_widgets');?></th>
           <td>
             <input type="radio" name="kia_facebook_social_options[like_verb]" value="light" <?php checked($options['like_verb'], 'like');?>/> <?php _e('Like','fb_social_widgets');?>
             <input type="radio" name="kia_facebook_social_options[like_verb]" value="dark" <?php checked($options['like_verb'], 'recommends');?>/> <?php _e('Recommends','fb_social_widgets');?>
           </td>
        </tr>

          </table>

        </fieldset>

      </div>

          <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
          </p>
    </form>
  </div>
</div>