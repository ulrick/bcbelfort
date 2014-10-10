<?php
/*
Plugin Name: Site Background Slider
Plugin URI: http://www.presspixels.com/release/background-slider/
Description: <a href="http://www.presspixels.com">Press Pixels</a> <a href="http://www.presspixels.com/release/background-slider/">Site Background Slider</a>  for WordPress adds <strong>Fullscreen Image Slideshows to your WebSite Background</strong>. Images are read from a specified folder, a selection of 8 different texture effects can be overlayed onto the images and the transition time between images can also be set. Settings can be found under your <strong>Appearance Menu</strong>!
Version: 1.0.8
Author: Lumo & Skashi @ Press Pixels
Author URI: http://www.presspixels.com

License: GPL2 - http://www.gnu.org/licenses/gpl.txt

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Make sure we don't expose any info if called directly!
if ( !function_exists( 'add_action' ) ) {
	echo "Hi there! I'm just a plugin, not much I can do when called directly.";
	exit;
}

// Version Tracking
define( 'SBS_VERSION', '1.0.8' );

// If Admin Area, add administration options page
if ( is_admin() ) require_once( dirname( __FILE__ ) . '/admin.php' );

// Class Function to filter and remove generator
class SiteBackgroundSlider {
  // Add JavaScript Files Correctly and Pass Variables
  function javaScriptFiles() {
  	$use_jquery            = get_option( 'sbs_use_jquery', '1' );
  	if( $use_jquery == 1 ) {
  		wp_deregister_script('jquery');
  		wp_register_script('jquery', ("http://code.jquery.com/jquery-latest.min.js"), false, '');
  	}
  	wp_register_script( 'jQueryNoConflict',  WP_PLUGIN_URL. "/site-background-slider/assets/jquery.noconflict.js");
  	wp_register_script( 'jQueryVegas',  WP_PLUGIN_URL. "/site-background-slider/assets/jquery.vegas.js");
  	if( $use_jquery == 1 ) { wp_enqueue_script( 'jquery' ); }
      wp_enqueue_script( 'jQueryNoConflict' );
      wp_enqueue_script( 'jQueryVegas' );
     	$resize_images = get_option( 'sbs_resize_images', '1' );
      wp_localize_script( 'jQueryVegas', 'jQueryVegasVars', array('ResizeImages' => $resize_images ) );
  }
  // Set and build the background slider javascript string
	function setBackgroundSlider() {
    $use_jquery            = get_option( 'sbs_use_jquery', '1' );
    $show_load_icon        = get_option( 'sbs_show_load_icon', '1' );
    $bg_delay              = get_option( 'sbs_bg_delay', '3000' );
    $bg_timer              = get_option( 'sbs_bg_timer', '10000' );
    $img_base_path_string  = get_option( 'sbs_img_base_path_string', 'images' );
    $shuffle_images        = get_option( 'sbs_shuffle', '0' );
    $overlay_image         = get_option( 'sbs_overlay_image', 'overlay-08.png' );
    $i                     = 0;
    $img_base_path         = get_bloginfo( 'wpurl' )."/{$img_base_path_string}";
    $files                 = glob( str_replace( "\\", "/", ABSPATH."$img_base_path_string/*" ) );
    $extension_path        = plugins_url()."/site-background-slider";
    $js_add                = $js_bg = $js_preload = $js = "";
    $loading               = $show_load_icon == 1 ? "" : ", loading: false";
    $overlay               = get_option( 'sbs_show_overlay', '1' );
    $justhome              = get_option( 'sbs_just_home', '0' );

    if( $overlay ) {
      $overlay_txt = "
          ('overlay', {
            src:'{$extension_path}/assets/images/overlay/{$overlay_image}'
          })
      ";
    } else $overlay_txt = "";

    if( is_array($files) ) {
      if( $shuffle_images == 1 ) shuffle($files);
      foreach( $files as $file ) {
        $filename     = explode( "/", $file );
        $filename     = $filename[sizeof($filename)-1];
        $js_bg       .= "{ src:'{$img_base_path}/{$filename}', fade:{$bg_delay}, delay:{$bg_timer} {$loading} },\n";
        $js_preload  .= "preloadImg('{$img_base_path}/{$filename}');\n\n";
        $i++;
      }
      $js .= "
        <script type=\"text/javascript\">
        jQuery(document).ready(function(){
          jQuery.vegas('slideshow', {
            backgrounds:[
              $js_bg
            ]
          })$overlay_txt;
        });
        function preloadImg(imgPath) {
          preloadImg = new Image();
          preloadImg.src = imgPath;
        }
        </script>
        <style type=\"text/css\">body > div { position: relative; } .vegas-loading { width: 100px; height: 100px; background: url($extension_path/assets/images/loader.gif) left bottom no-repeat; position: absolute; top: 20px; left: 20px; z-index: 131313}</style>
        ";
      echo $js;
    }
	}
  function setBackLink() {
    echo '<p class="pressback" style="position: fixed;bottom: 5px;left: 3px;font-size: 12px;font-weight: normal;letter-spacing: 1px; normal 13px/28px sans-serif; padding:0px 5px; margin: 0px;"><a style="color: #CCC;" href="http://www.presspixels.com">Press Pixels</a><br /><a style="color: #CCC;" href="http://www.presspixels.com/release/background-slider/">Background Slider</a></p>';
  }
}

if ( !is_admin() ) {
	add_action('wp_enqueue_scripts', array('SiteBackgroundSlider', 'javaScriptFiles'));
	if ( get_option( 'sbs_just_home', 0 ) == 1 ) {
		$home_page = get_option( 'sbs_homepage_url', 'http://'.$_SERVER['HTTP_HOST'] );
		$home_page = substr( $home_page, -1 ) == '/' ? $home_page : $home_page . "/";
    $current_page = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    if ( $home_page == $current_page ) {
      add_action( 'wp_head', array('SiteBackgroundSlider', 'setBackgroundSlider') );
			if ( get_option( 'sbs_link', 0 ) == 1 ) {
				add_action( 'get_template_part_content', array('SiteBackgroundSlider', 'setBackLink') );
		  }
    }
	}	else if ( get_option( 'sbs_just_home', 0 ) == 0 ) {
    add_action( 'wp_head', array('SiteBackgroundSlider', 'setBackgroundSlider') );
		if ( get_option( 'sbs_link', 0 ) == 1 ) {
			add_action( 'get_template_part_content', array('SiteBackgroundSlider', 'setBackLink') );
	  }
  }
}