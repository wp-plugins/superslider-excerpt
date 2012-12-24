=== SuperSlider-Excerpt ===
Contributors: Daiv
Donate link: http://superslider.daivmowbray.com/support-me/donate/
Tags: post_thumb, excerpts, thumbnails, morph, animation, mootools, javascript 
Requires at least: 2.6
Tested up to: 3.5
Stable tag: 2.2

SuperSlider-Excerpts automatically pulls thumbnails from your posts and morph-animates the roll over to any css style, wherever you show excerpts (archive page, feed...) The thumbnail can be any sized image and linked to post, attachment page, or other size version of image(for light box pop overs). 

== Description ==

SuperSlider-Excerpts automatically pulls thumbnails from your posts and morph-animates the roll over to any css style, wherever you show excerpts (archive page, feed...). The thumbnail can be any sized image and linked to post, attachment page, or other size version of image(for light box pop overs). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload). Compatible with [Advanced Excerpt](http://wordpress.org/extend/plugins/advanced-excerpt/ "Advanced Excerpt")

Order of thumbnail search for inclusion in your excerpt listings.
 
* If your post / page has the new 2.9 post_thumb option on your post screen, if used, this image will be used. 

* If your post / page has a meta_tag of thumbnail, it will grab the thumbnail and use that as part of your excerpt.

* If your post / page has attached images it will grab the first image and use that as part of your excerpt. 

* If your page or post has an image embedded this plugin will grab the thumbnail from the first image.   

* If your post has no image, this plugin will pull a category defined image, if you have added one. 

* And lastly if still there is no image for the post, a random image will be presented.(Selects from as many as you define in options)

**Demos**

This plugin can be seen in use here:

* [SuperSlider Excerpt demo](http://superslider.daivmowbray.com/category/plugin-news "SuperSlider Excerpt demo")

**Support**

If you have any problems or suggestions regarding these plugins [please speak up](http://wordpress.org/support/plugin/superslider-excerpt "support forum"),

== Screenshots ==

1. ![SuperSlider-Excerpt options screen](screenshot-1.png "SuperSlider-Excerpt options screen")
2. ![SuperSlider-Excerpt ](screenshot-2.png "SuperSlider-Excerpt ")
3. ![SuperSlider-Excerpt ](screenshot-3.png "SuperSlider-Excerpt Morphed on mouseover ")

== Upgrade Notice ==

You may need to re-save your settings/ options when upgrading

== Installation ==

The Easy Way

    In your WordPress admin, go to 'Plugins' and then click on 'Add New'.
    In the search box, type in 'SuperSlider-Excerpt' and hit enter. This plugin should be the first and likely the only result.
    Click on the 'Install' link.
    Once installed, click the 'Activate this plugin' link.

The Hard Way

    Download the .zip file containing the plugin, unzip.
    Upload the Superslider-Excerpts folder into your /wp-content/plugins/ directory 
    Find the Superslider-Excerpt plugin in the WordPress admin on the 'Plugins' page and click 'Activate'

== Themes ==

Create your own graphic and animation theme based on one of these provided.

**Available themes**

* default
* blue
* black
* custom

== Changelog ==

2.2 (2012/12/24)

  * fixed image size bug

2.1 (2012/12/20)

  * updated to WordPress to 3.5
  * fixed issue when requested image size is not available.
  * updated to mootools to 1.4.5

2.0 (2011/12/15)

  * added theme folder to the file storage options
  * updated to mootools to 1.4.1


1.8 (2010/07/05)

  * fixed bug: featured image, lightbox pop over failed

  
1.7 (2010/06/02)

  * fixed link to settings page
  * added save options upon deactivation option

1.6 (2010/05/31 )

  * Fixed admin options list issue with id = excerpt.
  * Fixed bug with custom field setting.

1.5 (2010/05/23 )

  * Changed the media options page layout

1.4 [march 15, 2010]

- made the excerpt holding class personable to work with any theme.

1.3 [march 10, 2010]

- updated for WP 2.9.2
- added as sub-menu for superslider

1.2 [DEC 24, 2009]

- Added new 2.9 post_thumbnail check


1.1 [DEC 3, 2009]

- Added check for custom field thumbnails
- Fixed a couple of small bugs

1.0 [DEC 2, 2009]
- first release