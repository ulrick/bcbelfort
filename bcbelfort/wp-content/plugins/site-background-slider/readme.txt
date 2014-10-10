=== Site Background Slider ===
Contributors: presspixels
Donate link: http://www.presspixels.com/donations/
Tags: background, images, slider, plugin, rotator
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 1.0.8

Awesome Background Image Slider Plugin for WordPress which creates fullscreen image slideshows inside your WordPress Site Background.

== Description ==

<p><a href="http://www.presspixels.com">Press Pixels</a> <a href="http://www.presspixels.com/release/background-slider/">Site Background Slider</a> for WordPress adds Fullscreen Image Slideshows to your WebSite Background. Images are read from a specified folder, a selection of 15 different texture effects can be overlaid onto the images, Image order can be shuffled plus jQuery can also be disabled if required. Image Show Time and Fade Time can also both be altered as required, your WordPress WebSite will display above the rotating images as shown in the <a href="http://backslider.presspixels.com/" rel="nofollow"  target="_blank" >Background Slider Demo</a>.</p>
<p>This WordPress Background Image Plugin has many uses, one of the primary functions being for example showing automatically rotating different <a href="http://www.presspixels.com/releases/">product</a> specific images, company logo layouts or even just different various minimal tiled colors with a texture. As the images are read from a folder, you can also just modify the folder image contents and your site background will update automatically.</p>
<p>Requires WordPress 3.0, PHP and jQuery. If you have suggestions for a new plugin or for version updates for this plugin, feel free to <a href="http://www.presspixels.com/wordpress-contact-press-pixels-support/">contact us</a>. You can also keep updated with our various channels shown below:</p>
<p> <a href="mailto:hello@presspixels.com">mail</a> / <a href="http://feeds.feedburner.com/presspixels">rss</a> / <a href="http://twitter.com/#!/sitesolution">twitter</a> / <a href="http://www.facebook.com/pages/Press-Pixels/343270052366258">facebook</a> / <a href="http://www.presspixels.com">site</a></p>

== Installation ==

Manual Installation from Download File:

1. Extract downloaded ZIP file to a location of your choice.
2. Upload folder`background-slider` to your `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in your WordPress Site.
4. Options can be found under your Admin / Appearance menu.

== Frequently Asked Questions ==

= I don't understand how the images work. Can I just change the directory or does it have to be image/slider in the gallery? =

You can set the directory to whatever you like, it is based from your WebSite root folder. So specifying 'images/slides' as an image location means that your images should be located for example as 'http://[YOUR SITE]/images/slides/image.jpg'. The default folder does not exist on setup, you will need to create it or set your own folder location.

= How are the images displayed and read? =

Images are read by the Plugin from the specified image folder location. All you have to do is optimize and place your images in that folder.

= My background load slow and weird. =

To make sure your images load quickly make sure the images are optimized (using an image editor), also make sure you dont have to many flashy Javascript thing running on the same page and the background slider will be super fast ;)

= Nothing loads in my background, nothing happens? =

Main cause of this usually is the jQuery / CSS files are not being loaded, returning a 404 not found error; check the paths in your setup (Best done using Firebug or a live code editor) For example, your site should be able to see this: http://[YOUR SITE]/wp-content/plugins/site-background-slider/assets/jquery.min.js

If the file is there, but still cannot be read, check the folder permissions (should be readable, 755). Lastly also make sure your filename has no weird characters (For example ö, ü, ä, etc).

= I have more questions. This FAQ is not very detailed? =

This plugin has its own wiki documentation available at Press Pixels. Check it out for more answers!

== Screenshots ==

1. Press Pixels Site Background Slider.
2. Admin options for the Background Slider.
3. Background Slides will rotate under your WordPress site.

== Changelog ==

= 1.0.8 =
* Added Option to enter homepage url as issues occur using pages and posts over the standard method

= 1.0.7 =
* Added Option to resize images (beta, on by default)
* Multiple fixes up including 1.0.5 and 1.0.6

= 1.0.4 =
* Added Option to show only on home page as requested!

= 1.0.3 =
* Fixed Multiple Versions of Plugin Installing in same site.
* Fixed CSS Selector as was effecting lower contained DIV (Comments).
* Shuffle function fixed, images are now, like, totally random.

= 1.0.2 =
* Added option to not show texture overlay (just show images) in admin.
* Updated Version + Name Retrieval and Display in Admin area.

= 1.0.1 =
* Updated FAQ with some common support questions.
* Removed loads of unused Java code.
* Updated Plugin reference paths to reflect WordPress install SVN.

= 1.0 =
* First Release, no changes yet!

== Upgrade Notice ==

= 1.0.8 =
New options: show only on home page: added homepage url

= 1.0.7 =
New options: show only on home page (updated) and resize images (beta)

= 1.0.4 =
Update this and also to new version after updating this!

= 1.0.3 =
Minor user bug fixes, update if your your installation is not working properly.

= 1.0.2 =
New feature, Show / Hide Texture Overlay. Plus minor changes. Upgrade recommended if you want this new feature.

= 1.0.1 =
Mainly bugs and some common notices. Upgrade recommended.

= 1.0 =
No need to upgrade, current stable release.

== Arbitrary section ==

For more information please feel free to visit Press Pixels through any of these channels:

* Site: <a href="http://www.presspixels.com">Press Pixels</a>
* Plugin: <a href="http://www.presspixels.com/release/background-slider/">Site Background Slider</a>
* Wiki: <a href="http://www.presspixels.com/background-slider-wiki-documentation/">Documentation</a>
* Other Releases: <a href="http://www.presspixels.com/releases/">Listed Here</a>