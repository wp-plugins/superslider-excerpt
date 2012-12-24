<?php
/*
Copyright 2008 daiv Mowbray

This file is part of SuperSlider-Excerpt

SuperSlider-Excerpt is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

excerpt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Fancy Categories; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	/**
   * Should you be doing this?
   */ 

	if ( !current_user_can('manage_options') ) {
		
		
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', $plugin_name) );
		}
		
		if (isset($_POST['set_defaults']))  {
			$plugin_name = 'superslider-excerpt';
			check_admin_referer('excerpt_options');
			$excerpt_OldOptions = array(
				"load_moo"    => "on",
				"css_load"    => "default",
				"css_theme"   => "default", 
				"morph_excerpt" => "on",
				"holder"     => "excerpt_wrap",
				"resize_dur"  => "800",
				"excerpt_class" => "",
				"trans_type"	=> "Sine",
				"trans_typeout" => "easeOut",
				"metaThumb" => "",
				"thumb_w"  => "50",
				"thumb_h"  => "50",
				"thumb_crop"  => "on",
				"thumbsize"     =>  "thumbnail",
				"num_ran"     => "5",
				"exlinkto"   =>  "post",
				"ex_pop_size"   =>  "large",
				"make_thumb"    =>  "on",
				'delete_options' => ''
				);

			update_option('ssExcerpt_options', $excerpt_OldOptions);
			update_option('excerpt_size_w', $excerpt_OldOptions['thumb_w'] );
		    update_option('excerpt_size_h', $excerpt_OldOptions['thumb_h'] );
		    update_option('excerpt_crop', $excerpt_OldOptions['thumb_crop']);
		    
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'SuperSlider-Excerpt Default Options reloaded.', $plugin_name) . '</strong></p></div>';
			
		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'update' ) {
			
			$plugin_name = 'superslider-excerpt';
			check_admin_referer('excerpt_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'excerpt Options saved.', $plugin_name) . '</strong></p></div>';
			
			$Excerpt_newOptions = array(			

				'load_moo' => isset($_POST['op_load_moo']) ? $_POST["op_load_moo"] : "",
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'morph_excerpt'	=> $_POST["op_morph_excerpt"],
				'holder'		=> $_POST["op_holder"],
				'resize_dur'	=> $_POST["op_resize_duration"],
				'trans_type'	=> $_POST["op_trans_type"],
				'trans_typeout'	=> $_POST["op_trans_typeout"],
				'metaThumb'	       => $_POST["op_metaThumb"],
				'excerpt_class'	   => $_POST["op_excerpt_class"],
				'thumb_w'	       => $_POST["op_thumb_w"],
				'thumb_h'	       => $_POST["op_thumb_h"],
				'thumb_crop'	   => $_POST["op_thumb_crop"],
				
				'thumbsize'	    => $_POST["op_thumbsize"],
				'num_ran'	    => $_POST["op_num_ran"],
				'exlinkto'	    => $_POST["op_exlinkto"],
				'ex_pop_size'	    => $_POST["op_ex_pop_size"],
				'make_thumb'	=> $_POST["op_make_thumb"],
				//'delete_options'	=> $_POST["op_delete_options"]
				'delete_options' => isset($_POST['op_delete_options']) ? $_POST["op_delete_options"] : ""
			);
			

		update_option('ssExcerpt_options', $Excerpt_newOptions);
        
        update_option('excerpt_size_w', $Excerpt_newOptions['thumb_w'] );
		update_option('excerpt_size_h', $Excerpt_newOptions['thumb_h'] );
		if ($Excerpt_newOptions['thumb_crop'] == 'on') $c = '1'; else  
		$c = '0';
		update_option('excerpt_crop', $c);
		
		// from here		
		}elseif (isset($_POST['proaction']) && $_POST['proaction'] == 'updatepro' ) {
			
			check_admin_referer('ssPro_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'superslider Pro Options saved.', 'superslider' ) . '</strong></p></div>';
			
			
			$ssPro_newOptions = array(				
				'pro_code' => isset($_POST['op_pro_code']) ? $_POST["op_pro_code"] : ""
				);
			update_option('ssPro_options', $ssPro_newOptions);
	
		}

	$ssPro_newOptions = get_option('ssPro_options'); 
	$ispro = '';
	if($ssPro_newOptions['pro_code'] == "We are all beautiful creative people")$ispro = true;


	$Excerpt_newOptions = get_option('ssExcerpt_options');   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
	$plugin_name = 'superslider-excerpt';
	    global $wp_version;    
        // is not version 3+
         if (version_compare($wp_version, "2.9.9", "<")) {
            $size_names = array('thumbnail' => 'thumbnail', 'medium' => 'medium', 'large' => 'large', 'full' => 'full',);
            if (function_exists('add_theme_support')) $size_names['post-thumbnail'] = 'post-thumbnail'; 
            if (class_exists("ssShow")) { $size_names['slideshow'] = 'slideshow'; $size_names['minithumb'] = 'minithumb';}
            if (class_exists("ssExcerpt")) $size_names['excerpt'] = 'excerpt'; 
            if (class_exists("ssPnext")) $size_names['prenext'] = 'prenext'; 
    /*
    * This is where you'd add any other image sizes for pre WP 3.0
    */      
       } else {       
            $size_names =  get_intermediate_image_sizes();// this only works with WP version 3+
            $size_names[] = 'full'; // adds original / full sized image to list
       }
       
?>

<div class="wrap">
<div class="ss_column1">

<form name="excerpt_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('excerpt_options'); echo "\n"; ?>
		
<div style="">
<a href="http://superslider.daivmowbray.com/">
<img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-excerpt/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Excerpt Options</h2>
 </div><br style="clear:both;" />
 <script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function ($) {

	$(function() {
        $( "#ssslider" ).tabs({ active: 1 });
    });
});	
// ]]>
</script>
 
 
<div id="ssslider" class="ui-tabs">
    <ul id="ssnav" class="ui-tabs-nav">
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ui-state-default" ><a href="#fragment-1"><span>Appearance</span></a></li>
        <li class="ui-tabs-selected"><a href="#fragment-2"><span>Transition Options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-3"><span>Thumbnail options</span></a></li>
        <li class="ui-state-default"><a href="#fragment-4"><span>Thumb Link options</span></a></li>
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ss-state-default" ><a href="#fragment-5"><span>File storage</span></a></li>
    </ul>
    <div id="fragment-1" class="ss-tabs-panel">
 	<div <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	
	>
	<h3>Excerpt Appearance</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$plugin_name); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-excerpt/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-excerpt/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-excerpt/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo WP_CONTENT_URL ?>/plugins/superslider-excerpt/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
	</tr>
	<tr>
		<td><label for="op_css_theme1">
			 <input type="radio"  name="op_css_theme" id="op_css_theme1"
			 <?php if($Excerpt_newOptions['css_theme'] == "default") echo $checked; ?> value="default" />
			</label>
		</td>
		<td> <label for="op_css_theme2">
			 <input type="radio"  name="op_css_theme" id="op_css_theme2"
			 <?php if($Excerpt_newOptions['css_theme'] == "blue") echo $checked; ?> value="blue" />
			 </label>
  		</td>
		<td><label for="op_css_theme3">
			 <input type="radio"  name="op_css_theme" id="op_css_theme3"
			 <?php if($Excerpt_newOptions['css_theme'] == "black") echo $checked; ?> value="black" />
			 </label>
  		</td>
		<td> <label for="op_css_theme4">
			 <input type="radio"  name="op_css_theme" id="op_css_theme4"
			 <?php if($Excerpt_newOptions['css_theme'] == "custom") echo $checked; ?> value="custom" />
			</label>
     </td>
	</tr>
	</table>

  </fieldset>
  </div>
</div><!--  close frag 1-->
 
 

	<div id="fragment-2" class="ss-tabs-panel">
	<h3 class="title">Excerpt Transition Options</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize Transitions',$plugin_name); ?>:</b></legend>

   <ul style="list-style-type: none;">
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_morph_excerpt">
		 <input type="checkbox" 
		 <?php if($Excerpt_newOptions['morph_excerpt'] == "on") echo $checked; ?> name="op_morph_excerpt" id="op_morph_excerpt" />
		 <?php _e('Turn Morph excerpt image on'); ?></label>		 
	  </li>
	  
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_holder"><?php _e(' Holder div class '); ?>:
		 <input type="text" class="span-text" name="op_holder" id="op_holder" size="20" maxlength="20"
		 value="<?php echo ($Excerpt_newOptions['holder']); ?>" /></label> 
		 <span class="setting-description"><?php _e('   (default "excerpt_wrap" with no period)',$plugin_name); ?></span>
	 </li>
	 
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_trans_type"><?php _e(' Transition type',$plugin_name); ?>:   </label>  
		 <select name="op_trans_type" id="op_trans_type">
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Sine") echo $selected; ?> id="Sine" value='Sine'> Sine</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Elastic") echo $selected; ?> id="Elastic" value='Elastic'> Elastic</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Bounce") echo $selected; ?> id="Bounce" value='Bounce'> Bounce</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Back") echo $selected; ?> id="Back" value='Back'> Back</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Expo") echo $selected; ?> id="Expo" value='Expo'> Expo</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Circ") echo $selected; ?> id="Circ" value='Circ'> Circ</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Quad") echo $selected; ?> id="Quad" value='Quad'> Quad</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Cubic") echo $selected; ?> id="Cubic" value='Cubic'> Cubic</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Linear") echo $selected; ?> id="Linear" value='Linear'> Linear</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Quart") echo $selected; ?> id="Quart" value='Quart'> Quart</option>
			 <option <?php if($Excerpt_newOptions['trans_type'] == "Quint") echo $selected; ?> id="Quint" value='Quint'> Quint</option>
			</select>
		<label for="op_trans_typeout"><?php _e(' Transition action.',$plugin_name); ?></label>
		<select name="op_trans_typeout" id="op_trans_typeout">
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeIn") echo $selected; ?> id="easeIn" value='easeIn'> ease in</option>
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeOut") echo $selected; ?> id="easeOut" value='easeOut'> ease out</option>
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeInOut") echo $selected; ?> id="easeInOut" value='easeInOut'> ease in out</option>     
		</select><br />
		<span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$plugin_name); ?></span>
     </li>   
	 
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_resize_duration"><?php _e(' Transition time '); ?>:
		 <input type="text" class="span-text" name="op_resize_duration" id="op_resize_duration" size="3" maxlength="6"
		 value="<?php echo ($Excerpt_newOptions['resize_dur']); ?>" /></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 500)',$plugin_name); ?></span>
	</li>
	<li>
		 <label for="op_excerpt_class"><?php _e('Excerpt thumbnail class'); ?>:
		 <input type="text" class="span-text" name="op_excerpt_class" id="op_excerpt_class" size="30" maxlength="300"
		 value="<?php echo ($Excerpt_newOptions['excerpt_class']); ?>" /></label> 
		 <br /><span class="setting-description"><?php _e(' Add a class for the thumbnail.',$plugin_name); ?></span>
		 
	</li>
      	 

     </ul>
  </fieldset>
  </div><!--  close frag 2-->
		
	<div id="fragment-3" class="ss-tabs-panel">
	<h3 class="title">Thumbnail</h3>
		  
		  <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize thumbnails',$plugin_name); ?>:</b></legend>
  <ul style="list-style-type: none;">       	 
	   	  
	   <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_thumbsize"><?php _e(' Thumbnail Size'); ?>: </label>
		
		<select name="op_thumbsize" id="op_thumbsize">   
   <?php foreach ( $size_names as $value => $name ) { 
     	$myScale = '';
		$width = get_option($name.'_size_w');
		$height = get_option($name.'_size_h'); ;
		$myScale = ' - '.$width.' x '.$height;
	?>
     <option <?php if($Excerpt_newOptions['thumbsize'] == "$name") echo $selected; ?> value='<?php echo $name; ?>'><?php echo" $name $myScale"; ?></option>
     
    <?php }?>     
    </select>
		 <span class="setting-description"><?php _e(' Which image size to use in your excerpt. ',$plugin_name); ?></span>
		 
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_metaThumb"><?php _e('Post thumbnail via custom field'); ?>:
		 <input type="text" class="span-text" name="op_metaThumb" id="op_metaThumb" size="30" maxlength="300"
		 value="<?php echo ($Excerpt_newOptions['metaThumb']); ?>" /></label> 
		 <br /><span class="setting-description"><?php _e(' Add the name of your previously used custom field, If you have used custom fields to add a thumbnail to your posts.',$plugin_name); ?></span>
		 
	</li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	    <label for="op_make_thumb">
		      <input type="checkbox" <?php if($Excerpt_newOptions['make_thumb'] == "on") echo $checked; ?>checked="" name="op_make_thumb" id="op_make_thumb" />
		      <?php _e('Make thumbnail. '); ?></label>	
		 <br /><span class="setting-description"><?php _e('If you want to have custom sized excerpt thumbnails, select excerpt from Thumbnail Size above and turn the make thumb on. The SuperSlider-Excerpt plugin can create additional excerpt thumbnails. This happens upon image upload. So to create excerpt thumbs for previously uploaded images you would need to install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" >Regenerate thumnails plugin</a>.',$plugin_name); ?></span>
		 <br />
		 <label for="op_thumb_w"><?php _e(' Width '); ?>:
             <input type="text" class="span-text" name="op_thumb_w" id="op_thumb_w" size="3" maxlength="5"
             value="<?php $size_w = get_option('excerpt_size_w'); if($size_w) { echo $size_w;} else {echo $Excerpt_newOptions[thumb_w];} ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$plugin_name); ?></span>
		  
		  <label for="op_thumb_h"><?php _e(' Height '); ?>:
             <input type="text" class="span-text" name="op_thumb_h" id="op_thumb_h" size="3" maxlength="5"
             value="<?php $size_h = get_option('excerpt_size_h'); if($size_h) { echo $size_h;} else {echo $Excerpt_newOptions[thumb_h];} ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$plugin_name); ?></span>
		 
		 <label for="op_thumb_crop">
			<input type="checkbox" name="op_thumb_crop" id="op_thumb_crop"
			<?php $crop = get_option('excerpt_crop') ; if($crop) echo $checked; ?> />
			<?php _e(' Create cropped, unsellected leaves the image proportional. ',$plugin_name); ?></label>	  
	    <br /><span class="setting-description"><?php _e('(These image settings are also available on the <a href="options-media.php">Media Settings page</a>).',$plugin_name); ?></span> 
	  </li>
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
             <label for="op_num_ran"><?php _e(' Number of Random '); ?>:
             <input type="text" class="span-text" name="op_num_ran" id="op_num_ran" size="3" maxlength="5"
             value="<?php echo ($Excerpt_newOptions['num_ran']); ?>" /> images.</label> <br />
             <span class="setting-description"><?php _e(' How many random images to pick from, if there are no images attached or imbeded in the post. And you don\'t have default category thumbnail images created. 
             To create default category thumbnails: for each category add an image with the name <b>cat-yourCatSlugName.jpg</b> to the folder <b>plugin-data/superslider/ssExcerpt/excerpt-thumbs/</b>. 
             Categories with no excerpt image will display one of the random thumbnails.',$plugin_name); ?></span>
         </li>
     </ul>
   </fieldset>
</div><!-- close frag3 -->

<div id="fragment-4" class="ss-tabs-panel">
<h3 class="title">Thumb Link</h3>
		  
    <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
        <legend><b><?php _e(' Personalize Link',$plugin_name); ?>:</b></legend>
        <ul style="list-style-type: none;">  
        
        <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_exlinkto"><?php _e(' Thumbnail Links to'); ?>: </label>
		  <select name="op_exlinkto" id="op_exlinkto">
		  	<option <?php if($Excerpt_newOptions['exlinkto'] == "post") echo $selected; ?> value='post'> post</option>
			<option <?php if($Excerpt_newOptions['exlinkto'] == "lightbox") echo $selected; ?> value='lightbox'> popover lightbox</option>
			<option <?php if($Excerpt_newOptions['exlinkto'] == "attachment") echo $selected; ?> value='attachment'> attachment</option>
		  </select>	
    </li>

        <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_ex_pop_size"><?php _e(' Popover Image Size'); ?>: </label>
		
		<select name="op_ex_pop_size" id="op_ex_pop_size">   
   <?php foreach ( $size_names as $value => $name ) { 
     	$myScale = '';
		$width = get_option($name.'_size_w');
		$height = get_option($name.'_size_h'); ;
		$myScale = ' - '.$width.' x '.$height;
		?>
		
     <option <?php if($Excerpt_newOptions['ex_pop_size'] == "$name") echo $selected; ?> id="op_thumbsize" value='<?php echo $name; ?>'><?php echo "$name $myScale"; ?></option>
     
    <?php }?>     
    </select>	 
		 <span class="setting-description"><?php _e(' Which image size to use in your excerpt thumb pop over. (lightbox plugin required) ',$plugin_name); ?></span>		 
	  </li>
    
        </ul>
   </fieldset>
</div><!-- close frag4 -->

<div id="fragment-5" class="ss-tabs-panel">
	
	<div
<?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> 
	>
	<h3 class="title">File Storage</h3>
<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Header files options start -->
   			<legend><b><?php _e(' Loading Options'); ?>:</b></legend>
  		 <ul style="list-style-type: none;">  		 
  		<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
    	<label for="op_load_moo">
    	<input type="checkbox" 
    	<?php if($Excerpt_newOptions['load_moo'] == "on") echo $checked; ?> name="op_load_moo" id="op_load_moo" />
    	<?php _e(' Load Mootools 1.4.1 into your theme header.',$plugin_name); ?></label><br />
    	<p>
		<?php _e(' If your theme or any other plugin loads the mootools 1.4.1 javascript framework into your file header, you can de-activate it here.',$plugin_name); ?></p>
    	
	</li>
	
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
  
    	<label for="op_css_load1">
			<input type="radio" name="op_css_load" id="op_css_load1"
			<?php if($Excerpt_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
			<?php _e(' Load css from default location. excerpt plugin folder.',$plugin_name); ?></label><br />
    	<label for="op_css_load2">
			<input type="radio" name="op_css_load"  id="op_css_load2"
			<?php if($Excerpt_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
			<?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$plugin_name); ?></label><br />
    	<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($Excerpt_newOptions['css_load'] == "theme") echo $checked; ?> value="theme" />
			<?php _e(' Load the css from your theme folder.',$plugin_name); ?></label><br />
        <label for="op_css_load4">
			<input type="radio" name="op_css_load"  id="op_css_load4"
			<?php if($Excerpt_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
			<?php _e(' Don\'t load css, manually add to your theme css file.',$plugin_name); ?></label><br />
        	<p><?php _e('* Based on your load css settings you will need to do one of the following. Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder, or into your WordPress theme folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$plugin_name); ?></p></td>
    </li>
    </ul>
     </fieldset>
     </div><!-- close frag 8 -->
</div><!--  close tabs -->
<p>
<label for="op_delete_options">
		      <input type="checkbox" <?php if($Excerpt_newOptions['delete_options'] == "on") echo $checked; ?> name="op_delete_options" id="op_delete_options" />
		      <?php _e('Remove options. '); ?></label>	
		 <br /><span class="setting-description"><?php _e('Select to have the plugin options removed from the data base upon deactivation.'); ?></span>
		 <br />
</p>
<p class="submit">
		<input type="submit" class="button" name="set_defaults" value="<?php _e(' Reload Default Options',$plugin_name); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e(' Update options',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
  </div>
</div><!-- close column1 -->


<div class="ss_column2">

<?php if( $ispro !== true) { ?>

	<div class="ss_donate ss_admin_box"> 
		<h2><span class="promo"><?php _e('Spread the Word!', $plugin_name); ?></span></h2>
		<p><?php _e('Want to help make this plugin even better? All donations are used to improve and maintain this plugin, so donate $5, $10, $20 or $50! We\'ll both be glad you did. Thanx. ', $plugin_name); ?></p>
       <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="hosted_button_id" value="N2F3EUVHPYY5G">
            <input type="image" class="paypal_button" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
       </form>
       
       
       <p><?php _e('Better yet, if you would like to join the exclusive pro members club,', $plugin_name); ?> <a href="http://superslider.daivmowbray.com/superslider-pro/"><?php _e('learn more'); ?></a><?php _e('or upgrade now!'); ?> </p>
       <h2><span class="promo">SuperSlider Pro</span></h2>
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="83HF3CEUD4976">
			<input type="image" class="paypal_button" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

       <p><?php _e('Or if you find this plugin useful you could :'); ?></p><ul>
       	<li><a href="http://wordpress.org/extend/plugins/<?php echo $plugin_name; ?>/"><?php _e('Rate the plugin 5 stars on WordPress.org', $plugin_name); ?></a></li>
       	<li><a href="http://superslider.daivmowbray.com/superslider/<?php echo $plugin_name; ?>/"><?php _e('Blog about it &amp; link to the plugin page', $plugin_name); ?></a></li>
       	<li><a href="http://wordpress.org/support/view/plugin-reviews/<?php echo $plugin_name; ?>"><?php _e('Post a glowing review on WordPress.org, that would be really nice.', $plugin_name); ?></a></li>
       	<li><a href="http://amzn.com/w/2GUXZ71357NX9"><?php _e('or buy me a gift from my wishlist ...', $plugin_name); ?></a></li></ul>
       
    </div>
    <div class="ss_admin_box" id="sitereview">
		<h2><?php _e('Improve your Site!', $plugin_name); ?></h2>
		<p><?php _e('Don\'t know where to start? Order a ', $plugin_name); ?><a href="http://superslider.daivmowbray.com/services/website-review/#order"><?php _e('website review', $plugin_name); ?></a> from SuperSlider!
		<a href="http://superslider.daivmowbray.com/services/website-review/"> Read more ... </a></p>	
	</div>

 
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please talk about them in the', $plugin_name); ?> <a href="http://wordpress.org/support/plugin/<?php echo $plugin_name; ?>/">Support forums</a>.</p>	
		</div>

 <?php 
 } else { ?>
	
		<div class="ss_donate ss_admin_box"> <h2><span class="promo">SuperSlider Pro</span></h2> </div>
	<div class="ss_admin_box" id="support">
		<h2><?php _e('Need support?', $plugin_name); ?></h2>
		<p><?php _e('If you are having problems with this plugin, please contact me directly via this contact form', $plugin_name); ?><br /><a href="http://superslider.daivmowbray.com/pro-support/">Pro Support</a>.</p>	
		</div>
<?php }?>

	<h2><?php _e('More SuperSlider Plugins', $plugin_name); ?></h2>
	<p><?php _e('There are 11 different SuperSlider plugins. All are free to use. Take a minute and learn what each one can do for you. They save you time and money, while making a better web site.', $plugin_name); ?></p>
	 <div class="ss_plugins_list
	 <?php if (class_exists('ssBase') && class_exists('ssShow') &&  class_exists('ssMenu') && class_exists('ssMenu') && class_exists('ssImage') && class_exists('ssExcerpt') && class_exists('ssMediaPop') && class_exists('perpost_code') && class_exists('ssPnext') && class_exists('ss_postsincat_widget') && class_exists('ssLogin') && class_exists('ssSlim')) { echo "all-installed" ; } ?>
	 "> 
	 
		<div class="ss_plugin <?php if (class_exists('ssBase')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider/" title="visit this plugin at WordPress.org to learn more">SuperSlider</a>	
		<a href="#ss_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="ss_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider base, is a global admin plugin for all SuperSlider plugins and comes stocked full of eye candy in the form of modules.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssShow')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-show/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Show</a>
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-show&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMenu')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-menu/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Menu</a>		
		<a href="#show_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-menu&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="show_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Show is your Animated slideshow plugin with automatic thumbnail list inclusion. This slideshow uses javascript to replace your gallery with a Slideshow. Highly configurable, theme based design, css based animations, automatic minithumbnail creation. Shortcode system on post and page screens to make each slideshow unique.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssImage')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-image/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Image</a>
		<a href="#image_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-image&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="image_tips_info" class="info_box" style="display:none;">
		<p>Take control your photos and image display. Can add a randomly selected image to any post without an image. Provides a shortcode for adding a photo or image to your post. Provides an easy way to change image properties globally. At the click of a button all post size images can be changed from thumbnail size image to medium size image or any available image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssExcerpt')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-excerpt/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Excerpt</a>
		<a href="#excerpt_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-excerpt&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="excerpt_tips_info" class="info_box" style="display:none;">
		<p>SuperSlider-Excerpts automatically adds thumbnails wherever you show excerpts (archive page, feed... etc). Mouseover image will then Morph its properties, (controlled with css) You can pre-define the automatic creation of excerpt sized excerpt-nails.(New image size created, upon image upload).</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssMediaPop')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-media-pop/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Media-Pop</a>	
		<a href="#media_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-media-pop&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="media_tips_info" class="info_box" style="display:none;">
		<p>Soda pop for your media. Take control of your media. Access all size versions of your uploaded image for insert. SuperSlider-Media-Pop adds numerous image enhancements to your admin panels. Displays all attached files to this post/page in post listing screen. It adds image sizes to the Upload/Insert image screen, making all image sizes available to be inserted and adding to the image link field options. Insert any image size and link to any image size.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('perpost_code')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-perpost-code/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Perpost-Code</a>
		<a href="#code_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-perpost-code&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="code_tips_info" class="info_box" style="display:none;">
		<p>Write css and javascript code directly on your post edit screen on a per post basis. Meta boxes provide a quick and easy way to enter custom code to each post. It then loads the code into your frontend theme header if the post has custom code. You may also display your custom code directly into your post with the custom_css or custom_js shortcode.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssPnext')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-previousnext-thumbs/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Previousnext-Thumbs</a>
		<a href="#pnext_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-previousnext-thumbs&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pnext_tips_info" class="info_box" style="display:none;">
		<p>Superslider-previousnext-thumbs is a previous-next post, thumbnail navigation creator. Works specifically on the single post pages. Animated rollover controlled with css and from the plugin options page. Can create custom image sizes. Automaitcally insert before or after post content or both. Or you can manually insert into your single post theme file.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ss_postsincat_widget')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-postsincat/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Postsincat</a>
		<a href="#pinc_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-postsincat&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="pinc_tips_info" class="info_box" style="display:none;">
		<p>This widget dynamically creates a list of posts from the active category. Displaying the first image and title. It will display the first image in your post as a thumbnail,it looks first for an attached image, then an embedded image then if it finds the image, it grabs the thumbnail version. Oh, and by the way, it's an animated vertical scroller, way cool.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssLogin')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://wordpress.org/extend/plugins/superslider-login/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Login</a>
		<a href="#login_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-login&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="login_tips_info" class="info_box" style="display:none;">
		<p>A tabbed slide in login panel. Theme based, animated, automatic user detection.</p>
		</div></div>
		
		<div class="ss_plugin <?php if (class_exists('ssSlim')) { echo "installed"; }else{ echo "not_installed";} ?>"><p>
		<a href="http://superslider.daivmowbray.com/superslider/superslider-slimbox/" title="visit this plugin at WordPress.org to learn more">SuperSlider-Slimbox</a>
		<a href="#slim_tips_info" class="ss_tool" style="padding: 2px 8px;"> info ?  </a><br />
		<a href="plugin-install.php?tab=search&s=superslider-slimbox&plugin-search-input=Search+Plugins" class="ss_more" title="View this plugin on your plugin install page">View on your Plugin Install page</a></p>
		<div id ="slim_tips_info" class="info_box" style="display:none;">
		<p>Another pop over light box. Theme based, animated, automatic linking, autoplay show built with slimbox2 , uses mootools 1.4.5 java script</p>
		</div></div>
	
		<br style="clear:both;" />
	 </div>
 <h3><?php _e('Services', $plugin_name); ?></h3>
		<p><?php _e('Custom plugins, custom themes, custom solutions: I\'ve been developing WordPress Themes and plugins for many years. If you need a custom solution or simply some help with your set up I am avaiable at reasonable rates. ', $plugin_name); ?><a href="http://www.daivmowbray.com/contact"><?php _e('Just send a note to me, Daiv Mowbray, through this contact form', $plugin_name); ?></a>.</p>

<?php  if( $ispro !== true) { ?>

	<div class="promo_code_form" style="text-align: center;">
	<form name="ssPro_options" method="post" action="<?php //echo $_SERVER['REQUEST_URI'] ?>">
	<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('ssPro_options'); echo "\n"; 
		?>
    		<label for="op_pro_code">
               <input type="text" class="span-text" name="op_pro_code" id="op_pro_code" size="30" maxlength="200"
			 value="<?php echo ($ssPro_newOptions['pro_code']); ?>" />
               <br /> <?php _e('Enter your SuperSlider Pro code.',$plugin_name); ?></label>	
    <p class="margin-top: 5px;">
	
		<input type="submit" id="updatePro" class="button-primary" value="<?php _e('Enter',$plugin_name); ?> &raquo;" />
		<input type="hidden" name="proaction" id="proaction" value="updatepro" />
		
 	</p>
 	</form>
 	</div>
<?php  } ?> 

</div><!-- close column2   --> 
</div><!-- close wrap to here --> 


<?php
	echo "";
?>