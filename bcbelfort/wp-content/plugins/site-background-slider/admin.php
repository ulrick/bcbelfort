<?php

if ($_REQUEST['page'] == 'sitebackgroundslider') {
  // Add the CSS for Admin
  wp_register_style('site-background-slider.css',  plugins_url() . '/site-background-slider/assets/site-background-slider.css');
  wp_enqueue_style('site-background-slider.css');
  
  // Footer Left and Right
add_filter('admin_footer_text', 'left_admin_footer_text_output'); //left side
function left_admin_footer_text_output($text) {
    $text = 'This plugin is based on the Vegas Background jQuery Plugin. Credits go to <a href=\'http://vegas.jaysalvat.com/\' target=\'_blank\'>Jay Salvat</a>.';
    return $text;
}
 
add_filter('update_footer', 'right_admin_footer_text_output', 11); //right side
function right_admin_footer_text_output($text) {
    $text = 'A <a href=\'http://www.presspixels.com/\' target=\'_blank\'>Press Pixels</a> Plugin, built for WordPress by Lumo and Skashi.';
    return $text;
}

}
require_once( dirname(__FILE__) . '/presspixels.admin.php' );

if (!class_exists('SiteBackgroundSliderAdmin')) {

  class SiteBackgroundSliderAdmin {

    var $_page_types = array(
        'sbs_use_jquery',
        'sbs_shuffle',
        'sbs_overlay_image',
        'sbs_bg_delay',
        'sbs_bg_timer',
        'sbs_show_overlay',
        'sbs_show_load_icon',
        'sbs_just_home',
        'sbs_resize_images',
        'sbs_img_base_path_string',
        'sbs_link',
        'sbs_homepage_url'
    );

    // default constructor
    function SiteBackgroundSliderAdmin() {
      // Hook for adding Admin menus
      add_action('admin_menu', array(&$this, 'add_menu_options'));
      if ($_REQUEST['page'] == 'sitebackgroundslider')
        add_action('admin_head', array(&$this, 'get_sbs_js'));
    }

    // action function for above hook
    function add_menu_options() {
      $title = 'Background Slider';
      add_theme_page($title, $title, 'manage_options', 'backgroundslider', array(&$this, 'display'));
    }

    function get_sbs_js() {
      $page_types = $this->_page_types;
      $js = "<script type='text/javascript'>\njQuery.noConflict();\njQuery(document).ready(function() {\n";
      for ($i = 0; $i < sizeof($page_types); $i++) {
        $page_type = str_replace(array("_", " "), "-", $page_types[$i]);
        $js .= "
        jQuery('input#checkbox-{$page_type}').iToggle({
      		easing: 'easeOutExpo',
      		onClickOn: function(){
      		  jQuery('#cb-{$page_type}').val(1);
      		},
      		onClickOff: function(){
      			jQuery('#cb-{$page_type}').val(0);
      		}
      	});
                ";
      }
      $js .= "});\n</script>\n";
      echo $js;
    }

    // display() displays the page content for the Remove Meta Generator settings submenu
    function display() {
      $presspixelsadmin = new PressPixelsAdmin();
      $plugin_data = get_plugin_data( __FILE__ );
	    $plugin_version = $plugin_data['Version'];
	    $plugin_name = $plugin_data['Name'];
      // See if the user has posted us some information
      // If they did, this hidden field will be set to 'Y'
      if (isset($_POST['sbs_submit_hidden']) and $_POST['sbs_submit_hidden'] == 'Y') {
        $page_types = $this->_page_types;
        for ($i = 0; $i < sizeof($page_types); $i++) {
          update_option($page_types[$i], $_REQUEST[$page_types[$i]]);
        }
        // Put an settings updated message on the screen
        echo '<div class="updated"><p><strong>' . __('settings saved.', 'menu-sbsadmin') . '</strong></p></div>';
      }
      // Now display the settings editing screen
      ?>
<div class="wrap" style="margin-top:20px">
	<div id="icon-tools" class="icon32"><br /></div>
	<h2>Site Background Slider</h2>
	<div class="postbox-container" style="width: 67%; margin-right: 2%; margin-top: 20px" >
		<div class="metabox-holder">
			<div class="inside">
				<form name="form1" method="post" action="">
          			<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span>Core Settings</span></h3>
						<div class="inside">
							<p>Press Pixels Site Background Slider for WordPress adds Fullscreen Image Slideshows to your WebSite Background. Images are read from a specified folder, a selection of 8 different texture effects can be overlaid onto the images and the transition time between images can also be set.</p>
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="twp_items">Overlay Texture for Images</label>
										</th>
										<td>
                      <?php echo $presspixelsadmin->makeHtmlFormField('filelist', 'sbs_overlay_image', get_option('sbs_overlay_image', 'overlay-01.png'), null, null, null, null, dirname( __FILE__ ).'/assets/images/overlay' ) ?>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="twp_errmsg">Background Timer Delay in Seconds: (10000 = 10 Seconds)</label>
										</th>
										<td>
											<input id="twp_errmsg" name="sbs_bg_timer" type="text" class="regular-text" value="<?php echo get_option('sbs_bg_timer', 10000)?>" size="30">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="twp_errmsg">Background Fade Delay in Seconds: (3000 = 3 Seconds)</label>
										</th>
										<td>
											<input id="twp_errmsg" name="sbs_bg_delay" type="text" class="regular-text" value="<?php echo get_option('sbs_bg_delay', 3000)?>" size="30">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="twp_errmsg">Background Images Location</label>
										</th>
										<td>
											<input id="twp_errmsg" name="sbs_img_base_path_string" type="text" class="regular-text" value="<?php echo get_option('sbs_img_base_path_string', 'wp-includes/images')?>" size="50">
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">Other Various Settings:</th>
										<td>
											<input id="sbs_resize_images" class="checkbox" type="checkbox" value="1" name="sbs_resize_images" <?php if( get_option('sbs_resize_images', 1) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_resize_images">Resize Images? (Beta)</label>
											<br>
											<input id="sbs_just_home" class="checkbox" type="checkbox" value="1" name="sbs_just_home" <?php if( get_option('sbs_just_home', 0) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_just_home">Show only on Home Page</label>
											<br>
											<input id="sbs_use_jquery" class="checkbox" type="checkbox" value="1" name="sbs_use_jquery" <?php if( get_option('sbs_use_jquery', 1) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_use_jquery">Include jQuery library framework</label>
											<br>
											<input id="sbs_show_overlay" class="checkbox" type="checkbox" value="1" name="sbs_show_overlay" <?php if( get_option('sbs_show_overlay', 1) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_show_overlay">Show the image overlay</label>
											<br>
										  <input id="sbs_show_load_icon" class="checkbox" type="checkbox" value="1" name="sbs_show_load_icon" <?php if( get_option('sbs_show_load_icon', 1) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_show_load_icon">Show the loading icon</label>
											<br>
											<input id="sbs_shuffle" class="checkbox" type="checkbox" value="1" name="sbs_shuffle" <?php if( get_option('sbs_shuffle', 0) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_shuffle">Random (Shuffle) Images</label>
											<br>
											<input id="sbs_link" class="checkbox" type="checkbox" value="1" name="sbs_link" <?php if( get_option('sbs_link', 1) == 1 ) echo 'checked="true"';?>>
											<label for="sbs_link">Show Press Pixels Link</label>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="twp_errmsg">Homepage URL</label>
										</th>
										<td>
											<input id="twp_errmsg" name="sbs_homepage_url" type="text" class="regular-text" value="<?php echo get_option('sbs_homepage_url', 'http://'.$_SERVER['HTTP_HOST'])?>" size="50">
										</td>
									</tr>
								</tbody>
							</table>
							<input type="hidden" name="sbs_submit_hidden" value="Y">
							<p class="submit"><input type="submit" name="Submit" class="button-save" value="<?php esc_attr_e('Save Changes') ?>" /></p>
						</div>
					</div>			 
				</form>	 
			</div>
		</div>
	</div>
          <div class="postbox-container" style="width: 30%; margin-top: 20px" >
				<div class="metabox-holder">
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span>Looking for Support?</span></h3>
						<div class="inside">
						 	<p>If you are having problems with this plugin and need support, please <a target="_blank" href="http://www.presspixels.com/wordpress-contact-press-pixels-support/" target="_blank">contact online</a> or alternatively <a href="mailto:hello@presspixels.com">send a mail</a> and we will help sort you out ASAP!</p>
						</div>
					</div>
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span>Press Pixels Info</span></h3>
						<div class="inside">
							<p>Press Pixels is all over the Web, you can keep focused with all the latest news at any of the Press Pixels pages listed below:</p>
							<p><a target="_blank" href="http://twitter.com/sitesolution" target="_blank">Twitter</a>&nbsp;&nbsp;<a target="_blank" href="http://www.facebook.com/pages/Press-Pixels/343270052366258?sk=wall" target="_blank">Facebook</a>&nbsp;&nbsp;<a target="_blank" href="http://feeds.feedburner.com/presspixels" target="_blank">RSS</a>&nbsp;&nbsp;<a target="_blank" href=“http://www.presspixels.com/release/background-slider/“>Slider</a>&nbsp;&nbsp;<a target="_blank" href="http://www.presspixels.com" target="_blank">Site</a></dt></p>
						</div>
					</div>
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div>
						<h3 class="hndle"><span>Latest News from Press Pixels</span></h3>
						<div class="inside">
							<p>Checkout the latest news and updated content from the Press Pixels Team:</p>
							<?php // import rss feed
							if(function_exists('fetch_feed')) {
								$rss = fetch_feed('http://feeds.feedburner.com/presspixels');
								if(!is_wp_error($rss)) : // error check
									$maxitems = $rss->get_item_quantity(5); // number of items
									$rss_items = $rss->get_items(0, $maxitems);
								endif;
							?>
						<ul>
						<?php if($maxitems == 0) echo '<dt>Updating... more news soon!</dt>';
						else foreach ($rss_items as $item) : ?>
						<li>
							<a target="_blank" href="<?php echo $item->get_permalink(); ?>" 
							title="<?php echo $item->get_date('j F Y @ g:i a'); ?>">
							<?php echo $item->get_title(); ?>
							</a>
						</li>
						<?php endforeach; ?>
						</ul>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
      </div><!-- end wrap div -->
      <?php
    }

  }

  $site_background_slider_admin = new SiteBackgroundSliderAdmin();
}
