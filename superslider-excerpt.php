<?php
/**
Plugin Name: SuperSlider-Excerpt
Author URI: http://wp-superslider.com
Plugin URI: http://wp-superslider.com/superslider/superslider-excerpt
Description: SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).
Author: Daiv Mowbray
Version: 1.3

*/

/*  Copyright 2008  Daiv Mowbray  (email : daiv.mowbray@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('ssExcerpt')) {
    class ssExcerpt	{
				/**
		* @var string   The name the options are saved under in the database.
		*/
		var $js_path;
		var $ExcerptOpOut;
		var $optionsName = "ssExcerpt_options";
		var $Excerpt_domain = 'superslider-Excerpt';
		var $base_over_ride;
		var $show_over_ride;
		var $ssBaseOpOut;
     
		
		function set_Excerpt_paths()
			{
			if ( !defined( 'WP_CONTENT_URL' ) )
				define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
			if ( !defined( 'WP_CONTENT_DIR' ) )
				define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
			if ( !defined( 'WP_PLUGIN_URL' ) )
				define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
			if ( !defined( 'WP_PLUGIN_DIR' ) )
				define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
			if ( !defined( 'WP_LANG_DIR') )
				define( 'WP_LANG_DIR', WP_CONTENT_DIR . '/languages' );            
           
			}
		
		/**
		* PHP 4 Compatible Constructor
		*/
		function ssExcerpt(){//$this->__construct();
			
			ssExcerpt::Excerpt();
		
		}
		
		/**
		* PHP 5 Constructor
		*/		
		function __construct(){
		
			self::Excerpt();
		
		}
		
		function language_switcher() {

			$superslider_Excerpt_locale = get_locale();
			$superslider_Excerpt_mofile = dirname(__FILE__) . "/languages/superslider-excerpt-".$superslider_Excerpt_locale.".mo";
			$plugin_dir = basename(dirname(__FILE__));

			load_plugin_textdomain($Excerpt_domain, 'wp-content/plugins/languages/' . $plugin_dir );		
		}
		
		/**
		* Retrieves the options from the database.
		* @return array
		*/
		function set_Excerpt_options() {
			$ExcerptOptions = array(
				"load_moo"    => "on",
				"css_load"    => "default",
				"css_theme"   => "default", 
				"morph_excerpt" => "on",
				//"opacity"     => "0.7",
				"resize_dur"  => "800",
				"excerpt_class" => "",
				"trans_type"	=> "Sine",
				"trans_typeout" => "easeOut",
				"metaThumb" => "thumbnail",
				"thumb_w"  => "50",
				"thumb_h"  => "50",
				"thumb_crop"  => "on",
				"thumbsize"   =>  "thumbnail",
				"num_ran"     => "4",
				"exlinkto"   =>  "post",
				"ex_pop_size"   =>  "large",
				"make_thumb"   =>  "on"
				);
				

			$savedOptions = get_option($this->optionsName);
				if (!empty($savedOptions)) {
					foreach ($savedOptions as $key => $option) {
						$ExcerptOptions[$key] = $option;
					}
			}
			update_option($this->optionsName, $ExcerptOptions);
				return $ExcerptOptions;
		}
		
		/**
		* Saves the admin options to the database.
		*/
		function saveExcerptOptions(){
			update_option($this->optionsName, $this->ExcerptOptions);
		}
		
		/**
		* Loads functions into WP API
		* 
		*/
		function Excerpt_init() {

			$this->ExcerptOptions = $this->set_Excerpt_options();
			$this->set_Excerpt_paths();
			$this->js_path = WP_CONTENT_URL . '/plugins/'. plugin_basename(dirname(__FILE__)) . '/js/';
			
			extract($this->ExcerptOptions);
			
			// lets see if the base plugin is here and get its options
			if (class_exists('ssBase')) {
					$this->ssBaseOpOut = get_option('ssBase_options');
					//extract($this->ssBaseOpOut);
					$this->base_over_ride = $this->ssBaseOpOut[ss_global_over_ride];	
				}else{
				$this->base_over_ride = 'false';
			}
			
			// lets see if the ss-Show plugin is here
			if (class_exists('ssShow')) {
					$this->show_over_ride = 'true';
				}else{
				$this->show_over_ride = 'false';
				}

         //$this->language_switcher();
            
        if ( (class_exists('ssBase')) && ($this->ssBaseOpOut['ss_global_over_ride']) ) { extract($this->ssBaseOpOut); }

        if ($css_load == 'default') {
                $cssFile = WP_PLUGIN_URL.'/superslider-excerpt/plugin-data/superslider/ssExcerpt/'.$css_theme.'/'.$css_theme.'.css';

            } elseif ($css_load == 'pluginData') {
                $cssFile = WP_CONTENT_URL.'/plugin-data/superslider/ssExcerpt/'.$css_theme.'/'.$css_theme.'.css';
 
            }elseif ($css_load == 'off') {
                $cssFile = '';
                
            }
        wp_register_style('superslider_Excerpt', $cssFile);
  			
        wp_register_script('moocore',$this->js_path.'mootools-1.2.3-core-yc.js',NULL, '1.2.3');
        wp_register_script('moomore',$this->js_path. 'mootools-1.2.3.1-more.js',array( 'moocore' ), '1.2.3');
        //wp_register_script('excerpt',$this->js_path. 'excerpt.js',array( 'moocore' ), '1', true);
        

        if ( $morph_excerpt == 'on') {  
        
           add_action('wp_enqueue_scripts', array(&$this,'Excerpt_add_javascript'));
           
         }
         if ($css_load !== 'off' ) { 
             add_action ( 'wp_print_styles', array(&$this,'Excerpt_add_css'));
           }
         add_filter ( 'get_the_excerpt', array(&$this,'thumbnail_excerpts' ));
  
	}
		
    /**
    * Outputs the HTML for the admin sub page.
    */
    function Excerpt_ui(){
        global $base_over_ride;
        global $Excerpt_domain;
        include_once 'admin/superslider-excerpt-ui.php';
    } 
    
    function Excerpt_admin_pages(){
    
        if (  function_exists('add_options_page') &&  current_user_can('manage_options') ) {

                if (!class_exists('ssBase')) $plugin_page = add_options_page(__('Superslider Excerpt'),__('SuperSlider-Excerpt'), 8, 'superslider-excerpt', array(&$this, 'Excerpt_ui'));
                add_filter('plugin_action_links', array(&$this, 'filter_plugin_excerpt'), 10, 2 );	
                
                add_action ( 'admin_print_styles', array(&$this,'ssbox_admin_style'));
                if (!class_exists('ssBase')) add_action('admin_print_scripts-'.$plugin_page, array(&$this,'Excerpt_admin_script'));
           				
        }
    }
    function Excerpt_admin_script(){
          wp_enqueue_script('jquery-ui-tabs');	// this should load the jquery tabs script into head
    
   }
    /**
    * Add link to options page from plugin list.
    */
    function filter_plugin_excerpt($links, $file) {
         static $this_plugin;
            if (  ! $this_plugin ) $this_plugin = plugin_basename(__FILE__);

        if (  $file == $this_plugin )
            $settings_link = '<a href="admin.php?page=superslider-excerpt">'.__('Settings', $Excerpt_domain).'</a>';
            array_unshift( $links, $settings_link ); //  before other links
            return $links;
    }

		
    /**
    *	remove options from DB upon deactivation
    */
    function Excerpt_ops_deactivation(){		
        delete_option($this->optionsName);
        delete_option('excerpt_size_w');
		delete_option('excerpt_size_h');
		delete_option('excerpt_crop');
    }
    
    function Excerpt_add_javascript(){
    
       $load_moo = $this->ExcerptOpOut[load_moo];

//var_dump($this->ExcerptOpOut);
//echo 'the load moo is : '. $load_moo.'.';          

       if ( (!is_admin()) && ($load_moo == 'on') ) { //&& ( !is_singular() )
        wp_enqueue_script('moocore');		
        wp_enqueue_script('moomore');	
      }
    }

	
    /**
    * Adds a link to the stylesheet to the header
    */
    function Excerpt_add_css() {
         
         if ( ( $this->ExcerptOpOut[css_load] !== 'off' ) && ( !is_singular() ) ){
            
            wp_enqueue_style( 'superslider_Excerpt');
          
          }
    }
    
    function Excerpt_starter(){
          
          if ( is_singular()) return;
          
          extract($this->ExcerptOpOut);

   $mytrans = "Fx.Transitions.".$trans_type.".".$trans_typeout;
                   
    $mystarter = "var excerpts = $$('div.entry');
    excerpts.each(function(excerpt, i) {
    var excerptImage = excerpt.getElement('.excerpt_thumb');
    var excerptMorph = new Fx.Morph(excerptImage, {
                  unit: 'px',
                  link: 'cancel',
                  duration: ".$resize_dur.", 
                  transition: ".$mytrans.",
                  fps: 30
    });
    excerptImage.addEvents({
        mouseenter: function() {  
           excerptMorph.start('.excerpt_thumb_active');
           },
        mouseleave: function() {          
            excerptMorph.start('.excerpt_thumb');
            }
       });       
        });";
          
    $starter .= "\n"."<script type=\"text/javascript\">\n";
    $starter .= "\t"."// <![CDATA[\n";		
    $starter .= "window.addEvent('domready', function() {
                ".$mystarter."					
                });\n";
    $starter .= "\t".'// ]]>';
    $starter .= "\n".'</script>'."\n";
                        
    echo $starter;
    
    }
		
    function Excerpt() {
        
        $this->ExcerptOpOut = get_option($this->optionsName);
         
        register_activation_hook(__FILE__, array(&$this,'Excerpt_init') ); //http://codex.wordpress.org/Function_Reference/register_activation_hook
        register_deactivation_hook( __FILE__, array(&$this,'Excerpt_ops_deactivation') ); //http://codex.wordpress.org/Function_Reference/register_deactivation_hook
        
        add_action ( 'init', array(&$this,'Excerpt_init' ) );			
        add_action ( 'admin_menu', array(&$this,'Excerpt_admin_pages'));
        if ($this->ExcerptOpOut[make_thumb] == 'on') {
                add_action ( 'admin_init', array(&$this,'Excerpt_create_thumbs' ) );
                add_action( 'admin_init', array(&$this, 'Excerpt_create_media_page') );
        }

        
        
    }
    
    function thumbnail_excerpts($excerpt){
    
      extract($this->ExcerptOptions);	
      
       if ( is_single()) return;
       
       if ( $morph_excerpt == 'on')
        add_action ( "wp_footer", array(&$this,"Excerpt_starter"));
        
        global $wp_query, $wpdb;
        $id = $wp_query->post->ID;

        // check first for a post 2.9 post thumb setting
		if ( function_exists( 'get_the_post_thumbnail' )) {
 
		 $metaSrc2 = get_the_post_thumbnail($id, $thumbsize, $attr = array('class'=>'excerpt_thumb'));

		}

        // check for a meta key of thumbnail
		if ( function_exists( 'get_post_meta' ) && $metaSrc2 == '') {
            
            $metaSrc = get_post_meta($id, $metaThumb, true);
        
        }
        
        // no meta source lets check for attachments
        if ( $metaSrc == '' && $metaSrc2 == '') {
 
            $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image') );
            
            // lets get the post category
            $cat = get_the_category($id);
            $cat = $cat[0];
            $cat = 'cat-'.($cat->slug);
            
            // there are no attachments, go get a hard code
            if ( empty($attachments)) { 
            
                $this->get_hard_coded($id, $excerpt, $cat); return;
            }
        
            if (array($attachments)) $attachment = array_pop($attachments);
        
            $id = $attachment->ID;		
        
            if ( is_feed() ) {
                    $output = "\n";
                    $output .= wp_get_attachment_link($id, $size = $thumbsize, true) . "\n";
                    return $output;
            }

            switch($exlinkto){
            
            case 'lightbox':
                $link = wp_get_attachment_image_src($id, $ex_pop_size);
                $link = $link[0];
                $a_rel = ' rel="lightbox:'.$cat.'"';
                break;
            case 'post':
                $my_link = $attachment->post_parent;
                $link = get_permalink($my_link);
                $a_rel = ' rel="'.$cat.'"';
                break;
            case 'attachment':
                $link = get_permalink($id);
                $a_rel = ' rel="'.$cat.'"';
                break;
            }            
  
            $image = wp_get_attachment_image_src($id, $thumbsize);
            $linkto = 'href="'.$link.'"';
            $a_class = 'excerpt_thumb_link';           
            
            $output =  '<a '.$linkto.$a_rel .' class="'.$a_class.'" title="'.$attachment->post_title.' :: '.$attachment->post_excerpt.'" >';
            $output .= '<img id="slide-'.$id.'" src="'.$image[0].'" class="excerpt_thumb '.$excerpt_class.' '.$cat.' " alt="'.$attachment->post_content.'" width="'.$image[1].'" height="'.$image[2].'" /></a>';
        
         return $output.'<p>'.do_shortcode($excerpt).'</p>';         
         
         } else {
           
           // there was a meta key of thumbnail or post thumb so lets return it now
            $image = '<a href="'.get_permalink($id).'">';
            if($metaSrc2 != '') {
                $image .= $metaSrc2;
           
            }else{
        
                $image .= '<img src="'.$metaSrc.' " class="excerpt_thumb '.$excerpt_class.' '.$cat.'" alt="excerpt thumb" />';
            }
           $image .= '</a><p>'.do_shortcode($excerpt).'</p>';
        
            return $image;
         }

    }
    
    /*
    ** find image in the post which isn't attached
    */
    function get_hard_coded($id, $excerpt, $cat){
            
        extract($this->ExcerptOptions);	
                  
        global $wp_query, $wpdb;
        
        $rel = '';
            // check for image thumb size option based on user option of thumb size
            $mythumb_w = get_option($thumbsize."_size_w");
            $mythumb_h = get_option($thumbsize."_size_h");		
            $mysize = $mythumb_w."x".$mythumb_h;
        
        //get the post content
        $content = $wpdb->get_var('select post_content from '.$wpdb->prefix.'posts where id='.$id);
	    
	    // find the image tag in the post
	    $pos = stripos($content,"<img");
	  
          if ( $pos !==false ) {
            $content = substr( $content, $pos, stripos($content,">",$pos) );		 
            $pos = stripos($content,"src=")+4;		 
            $stopchar=" ";
                
                if ( "".substr($content,$pos,1)=='"'){
                    $stopchar = '"';
                    
                    $pos++;
                }
                if ( "".substr($content,$pos,1)=="'"){
                    $stopchar = "'";
                    
                    $pos++;
                }
            $img1 = "";                
                do{
                    $char = substr($content,$pos++,1);
                    if ( $char != $stopchar)
                        $img1 .= $char;
                } 
                while(($char != $stopchar) && ($pos < strlen($content)));
                
            $img2 = preg_replace('/(.+)-\d+x\d+(.+)/', '$1-'.$mysize.'$2', $img1);              
            
            $file3 = substr($img2,stripos($img2,"wp-content"));

            $file2 = ABSPATH.substr($img2,stripos($img2,"wp-content"));
 
            if (file_exists($file2)) {                
               echo '<a href="'.get_permalink($id).'">
               <img src="'.$img2.'" '.$rel.' class="excerpt_thumb '.$excerpt_class.' img1b" width="'.$mythumb_w.'" height=" '.$mythumb_h.'" alt="thumb" title="view post" /></a><p>'.do_shortcode($excerpt).'</p>';//return do_shortcode($output);
                return;
            } else {
                
                $this->Excerpt_default_image($excerpt, $mythumb_w, $mythumb_h, $cat);
            }
 
               
        }
        else{
        
        $this->Excerpt_default_image($excerpt, $mythumb_w, $mythumb_h, $cat);
    
        }
        return $excerpt;
    }
    
    // no image in this post, lets get a default 
    function Excerpt_default_image($excerpt, $mythumb_w, $mythumb_h, $cat){        
        
        extract($this->ExcerptOptions);	
        
        if ($css_load == 'default') {
                $default_image_path = WP_PLUGIN_URL.'/superslider-excerpt/plugin-data/superslider/ssExcerpt/excerpt-thumbs/';
            } elseif ($css_load == 'pluginData') {
                $default_image_path = WP_CONTENT_URL.'/plugin-data/superslider/ssExcerpt/excerpt-thumbs/'; 
            }
        $default_image = $default_image_path.$cat.'.jpg';       

        $image = '<a href="'.get_permalink($id).'">';

        if (file_exists(ABSPATH."/".substr($default_image,stripos($default_image,"wp-content")))) {
            
            $image .= '<img src="'.$default_image.' "  '.$rel.' width="'.$mythumb_w.'" height="'.$mythumb_h.'" class="excerpt_thumb '.$excerpt_class.' '.$cat.' img3" alt="excerpt thumb" />';

        } else {
            $n = mt_rand(1, $num_ran);
            $image .= '<img src="'.$default_image_path.'random-image-'.$n.'.jpg"  '.$rel.' width="'.$mythumb_w.'" height="'.$mythumb_h.'" class="excerpt_thumb '.$excerpt_class.' '.$cat.' img4" alt="excerpt thumb" />';

        }
        
        $image .= '</a><p>'.do_shortcode($excerpt).'</p>';
        
        echo $image;
     
    }

    function load_Excerpt(){
        
        extract($this->ExcerptOptions);	
        
       if (!is_admin()){
            if ($css_load != 'off' ) { 
                add_action ( 'wp_print_styles', array(&$this,'Excerpt_add_css' ));
             }
            if ( $morph_excerpt == 'on'){  
             
             add_action ( 'wp_print_scripts', array(&$this,'Excerpt_add_javascript' ));
             add_action ( "wp_footer", array(&$this,"Excerpt_starter"));
            }
         add_filter ( 'get_the_excerpt', array(&$this,'thumbnail_excerpts' ));
        }
    }
            
    function ssbox_admin_style(){
        if ($this->base_over_ride != "on") {
            $cssAdminFile = WP_PLUGIN_URL.'/superslider-excerpt/admin/ss_admin_style.css';
            wp_register_style('superslider_admin', $cssAdminFile);
            wp_enqueue_style( 'superslider_admin');
        }	
        
    }
    
    function Excerpt_create_thumbs(){

			$this->listnewimages();
			add_filter( 'intermediate_image_sizes',  array(&$this, 'additional_thumb_sizes') );	
	}
	
	 function Excerpt_create_media_page() {
    			
    		register_setting( 'media', ' excerpt_size_w' );
    		register_setting( 'media', ' excerpt_size_h' );
    		register_setting( 'media', ' excerpt_crop' );

    			//add_settings_section($id, $title, $callback, $page)
			add_settings_section('excerpt_section', 'SuperSlider-Excerpt Image Size', array(&$this, 'Excerpt_media_section'), 'media');
			
			add_settings_field('excerpt_size_w', 'Excerpt Width', array(&$this, 'Excerpt_media_w'), 'media', 'excerpt_section');
			add_settings_field('excerpt_size_h', 'Excerpt Height', array(&$this, 'Excerpt_media_h'), 'media', 'excerpt_section');
			add_settings_field('excerpt_crop', 'Excerpt Crop', array(&$this, 'Excerpt_media_crop'), 'media', 'excerpt_section');

    }

    function Excerpt_media_section(){
      $section = '<span class="description">Adding (excerpt) to the standard: thumbnail, medium, and large image sizes.</span>';        
       echo $section;
	}
   
	function Excerpt_media_w(){        
        $Excerpt_w = get_option ('excerpt_size_w');
        echo '<label for="excerpt_size_w">Width</label><input name="excerpt_size_w" id="excerpt_size_w" type="text" value="'. $Excerpt_w.'" class="small-text" />'; 
       
	}
	function  Excerpt_media_h(){
        $Excerpt_h = get_option('excerpt_size_h');       
        echo '<label for=" excerpt_size_h">Height</label><input name="excerpt_size_h" id="excerpt_size_h" type="text" value="'. $Excerpt_h.'" class="small-text" />
        <br />';
	}
	function  Excerpt_media_crop(){
        $Excerpt_crop = get_option('excerpt_crop');
          echo '<input type="checkbox"'; 
            checked('1', $Excerpt_crop);        
          echo ' value="1" id="excerpt_crop" name="excerpt_crop">
            <label for=" excerpt_crop">';
            _e('Crop Excerpt image to exact dimensions (normally thumbnails are proportional)'); 
          echo '</label>';	
	}
	
	function additional_thumb_sizes( $sizes ) {
			$sizes[] = "excerpt";
			return $sizes;			
	}

	function listnewimages() { 		
		extract($this->ExcerptOptions);	
		
		if( FALSE == get_option('excerpt_size_w') )
			{	
				add_option('excerpt_size_w', $thumb_w );
				add_option('excerpt_size_h', $thumb_h);
				add_option('excerpt_crop', $thumb_crop);
			}
	}

    }// end class Excerpt
}// end if class Excerpt

//instantiate the class
if (class_exists('ssExcerpt')) {
	$myssExcerpt = new ssExcerpt();
}
?>