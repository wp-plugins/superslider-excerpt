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
$excerpt_domain = 'superslider-excerpt';

	if ( !current_user_can('manage_options') ) {
		// Apparently not.
		die( __( 'ACCESS DENIED: Your don\'t have permission to do this.', $excerpt_domain) );
		}
		if (isset($_POST['set_defaults']))  {
			check_admin_referer('excerpt_options');
			$excerpt_OldOptions = array(
				"load_moo"    => "on",
				"css_load"    => "default",
				"css_theme"   => "default", 
				"morph_excerpt" => "on",
				//"opacity"     => "0.7",
				"resize_dur"  => "800",
				"excerpt_class" => "",
				"trans_type"	=> "Sine",
				"trans_typeout" => "easeOut",
				"thumb_w"  => "50",
				"thumb_h"  => "50",
				"thumb_crop"  => "true",
				"thumbsize"     =>  "thumbnail",
				"num_ran"     => "4",
				"make_thumb"    =>  "on"
				);

			update_option($this->optionsName, $excerpt_OldOptions);
				
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'excerpt Default Options reloaded.', $excerpt_domain) . '</strong></p></div>';
			
		}
		elseif ($_POST['action'] == 'update' ) {
			
			check_admin_referer('excerpt_options'); // check the nonce
					// If we've updated settings, show a message
			echo '<div id="message" class="updated fade"><p><strong>' . __( 'excerpt Options saved.', $excerpt_domain) . '</strong></p></div>';
			
			$Excerpt_newOptions = array(			

				'load_moo'		=> $_POST['op_load_moo'],
				'css_load'		=> $_POST['op_css_load'],
				'css_theme'		=> $_POST["op_css_theme"],
				'morph_excerpt'		=> $_POST["op_morph_excerpt"],
				//'opacity'		=> $_POST["op_overlayOpacity"],
				'resize_dur'	=> $_POST["op_resize_duration"],
				'trans_type'	=> $_POST["op_trans_type"],
				'trans_typeout'	=> $_POST["op_trans_typeout"],
				
				'excerpt_class'	=> $_POST["op_excerpt_class"],
				'thumb_w'	=> $_POST["op_thumb_w"],
				'thumb_h'	=> $_POST["op_thumb_h"],
				'thumb_crop'	=> $_POST["op_thumb_crop"],
				
				'thumbsize'	    => $_POST["op_thumbsize"],
				'num_ran'	    => $_POST["op_num_ran"],
				'make_thumb'	=> $_POST["op_make_thumb"]
			);	

		update_option($this->optionsName, $Excerpt_newOptions);
        
        update_option('excerpt_size_w', $Excerpt_newOptions[thumb_w] );
		update_option('excerpt_size_h', $Excerpt_newOptions[thumb_h] );
		if ($Excerpt_newOptions[thumb_crop] == 'true') $c = '1'; else  
		$c = '0';
		update_option('excerpt_crop', $c);
		}	

		$Excerpt_newOptions = get_option($this->optionsName);   

	/**
	*	Let's get some variables for multiple instances
	*/
    $checked = ' checked="checked"';
    $selected = ' selected="selected"';
	$site = get_option('siteurl'); 
?>

<div class="wrap">
<form name="excerpt_options" method="post" action="<?php echo $_SERVER['REQUEST_URI'] ?>">
<?php if ( function_exists('wp_nonce_field') )
		wp_nonce_field('excerpt_options'); echo "\n"; ?>
		
<div style="">
<a href="http://wp-superslider.com/">
<img src="<?php echo $site ?>/wp-content/plugins/superslider-excerpt/admin/img/logo_superslider.png" style="margin-bottom: -15px;padding: 20px 20px 0px 20px;" alt="SuperSlider Logo" width="52" height="52" border="0" /></a>
  <h2 style="display:inline; position: relative;">SuperSlider-Excerpt Options</h2>
 </div><br style="clear:both;" />
 <script type="text/javascript">
// <![CDATA[

function create_ui_tabs() {


    jQuery(function() {
        var selector = '#ssslider';
            if ( typeof jQuery.prototype.selector === 'undefined' ) {
            // We have jQuery 1.2.x, tabs work better on UL
            selector += ' > ul';
        }
        jQuery( selector ).tabs({ fxFade: true, fxSpeed: 'slow' });

    });
}

jQuery(document).ready(function(){
        create_ui_tabs();
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
        <li <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	class="ss-state-default" ><a href="#fragment-4"><span>File storage</span></a></li>
    </ul>
    <div id="fragment-1" class="ui-tabs-panel">
 	<div <?php if ($this->base_over_ride != "on") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?>	
	>
	<h3>Excerpt Appearance</h3>
	
		<fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- Theme options start -->  	
		<legend><b><?php _e(' Themes',$excerpt_domain); ?>:</b></legend>
	<table width="100%" cellpadding="10" align="center">
	<tr>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-excerpt/admin/img/default.png" alt="default" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-excerpt/admin/img/blue.png" alt="blue" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-excerpt/admin/img/black.png" alt="black" border="0" width="110" height="25" /></td>
		<td width="25%" align="center" valign="top"><img src="<?php echo $site ?>/wp-content/plugins/superslider-excerpt/admin/img/custom.png" alt="custom" border="0" width="110" height="25" /></td>
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
   <legend><b><?php _e(' Personalize Transitions',$excerpt_domain); ?>:</b></legend>

   <ul style="list-style-type: none;">
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_morph_excerpt">
		 <input type="checkbox" 
		 <?php if($Excerpt_newOptions['morph_excerpt'] == "on") echo $checked; ?> name="op_morph_excerpt" id="op_morph_excerpt" />
		 <?php _e('Turn Morph excerpt image on'); ?></label>		 
	  </li>
	  
     <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_trans_type"><?php _e(' Transition type',$excerpt_domain); ?>:   </label>  
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
		<label for="op_trans_typeout"><?php _e(' Transition action.',$excerpt_domain); ?></label>
		<select name="op_trans_typeout" id="op_trans_typeout">
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeIn") echo $selected; ?> id="easeIn" value='easeIn'> ease in</option>
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeOut") echo $selected; ?> id="easeOut" value='easeOut'> ease out</option>
			 <option <?php if($Excerpt_newOptions['trans_typeout'] == "easeInOut") echo $selected; ?> id="easeInOut" value='easeInOut'> ease in out</option>     
		</select><br />
		<span class="setting-description"><?php _e(' IN is the begginning of transition. OUT is the end of transition.',$excerpt_domain); ?></span>
     </li>   
	 <!--<li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
     <label for="op_overlayOpacity"><?php _e(' Overlay opacity '); ?>:
		 <input type="text" class="span-text" name="op_overlayOpacity" id="op_overlayOpacity" size="3" maxlength="3"
		 value="<?php echo ($Excerpt_newOptions['opacity']); ?>" /></label> 
		 <span class="setting-description"><?php _e('   (default 0.7)',$excerpt_domain); ?></span>
	 </li>-->
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_resize_duration"><?php _e(' Transition time '); ?>:
		 <input type="text" class="span-text" name="op_resize_duration" id="op_resize_duration" size="3" maxlength="6"
		 value="<?php echo ($Excerpt_newOptions['resize_dur']); ?>" /></label> 
		 <span class="setting-description"><?php _e('  In milliseconds, ie: 1000 = 1 second, (default 500)',$excerpt_domain); ?></span>
	</li>
	<li>
		 <label for="op_excerpt_class"><?php _e('Excerpt thumbnail class'); ?>:
		 <input type="text" class="span-text" name="op_excerpt_class" id="op_excerpt_class" size="30" maxlength="300"
		 value="<?php echo ($Excerpt_newOptions['excerpt_class']); ?>" /></label> 
		 <br /><span class="setting-description"><?php _e(' Add a class for the thumbnail.',$excerpt_domain); ?></span>
		 
	</li>
      	 

     </ul>
  </fieldset>
  </div><!--  close frag 2-->
		
	<div id="fragment-3" class="ss-tabs-panel">
	<h3 class="title">Thumbnail</h3>
		  
		  <fieldset style="border:1px solid grey;margin:10px;padding:10px 10px 10px 30px;"><!-- options start -->
   <legend><b><?php _e(' Personalize thumbnails',$excerpt_domain); ?>:</b></legend>
  <ul style="list-style-type: none;">       	 
	   	  
	   <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
		 <label for="op_thumbsize"><?php _e(' Thumbnail Size'); ?>: </label> 
		 
		  <select name="op_thumbsize" id="op_thumbsize">
		      <option <?php if($Excerpt_newOptions['thumbsize'] == "excerpt") echo $selected; ?> id="ssexcerpt" value="excerpt"> excerpt</option>
		     <option <?php if ($this->show_over_ride == "true") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Excerpt_newOptions['thumbsize'] == "minithumb") echo $selected; ?> id="minithumb" value='minithumb'> minithumb</option>
			 <option <?php if($Excerpt_newOptions['thumbsize'] == "thumbnail") echo $selected; ?> id="thumbnail" value='thumbnail'> thumbnail</option>
			 <option <?php if($Excerpt_newOptions['thumbsize'] == "medium") echo $selected; ?> id="medium" value='medium'> medium</option>
			 
  		    <option <?php if ($this->show_over_ride == "true") { 
  		 echo '';
  		} else {
  		echo 'style="display:none;"';
  		}?> <?php if($Excerpt_newOptions['thumbsize'] == "slideshow") echo $selected; ?> id="slideshow" value='slideshow'> slideshow</option>		   
		 </select>	 
		 <span class="setting-description"><?php _e(' Which image size to use in your excerpt. ',$excerpt_domain); ?></span>
		 
	  </li>
	  <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
	   <span class="setting-description"><?php _e('If you want to have custom sized excerpt thumbnails, select excerpt above and turn the make thumb on. The SuperSlider-Excerpt plugin can create additional excerpt thumbnails. This happens upon image upload. So to create minithumbs for previously uploaded images you would need to install the <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" >Regenerate thumnails plugin</a>.',$excerpt_domain); ?></span><br />
		 <label for="op_make_thumb">
		      <input type="checkbox" <?php if($Excerpt_newOptions['make_thumb'] == "on") echo $checked; ?>checked="" name="op_make_thumb" id="op_make_thumb" />
		      <?php _e('Make thumbnail. '); ?></label>	
		 <label for="op_thumb_w"><?php _e(' Width '); ?>:
             <input type="text" class="span-text" name="op_thumb_w" id="op_thumb_w" size="3" maxlength="5"
             value="<?php echo ($Excerpt_newOptions['thumb_w']); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$excerpt_domain); ?></span>
		  <label for="op_thumb_h"><?php _e(' Height '); ?>:
             <input type="text" class="span-text" name="op_thumb_h" id="op_thumb_h" size="3" maxlength="5"
             value="<?php echo ($Excerpt_newOptions['thumb_h']); ?>" /> px.</label> 
             <span class="setting-description"><?php _e('  ',$excerpt_domain); ?></span>
		 <label for="op_css_load1">
			<input type="checkbox" name="op_thumb_crop" id="op_thumb_crop"
			<?php if($Excerpt_newOptions['thumb_crop'] == "true") echo $checked; ?> value="true" />
			<?php _e(' Create cropped, unsellected leaves the image proportional. ',$excerpt_domain); ?></label>
	  </li>
      <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
             <label for="op_num_ran"><?php _e(' Number of Random '); ?>:
             <input type="text" class="span-text" name="op_num_ran" id="op_num_ran" size="3" maxlength="5"
             value="<?php echo ($Excerpt_newOptions['num_ran']); ?>" /> images.</label> <br />
             <span class="setting-description"><?php _e(' How many random images to pick from, if there are no images attached or imbeded in the post. And you don\'t have default category thumbnail images created. 
             To create default category thumbnails: for each category add an image with the name <b>cat-yourCatSlugName.jpg</b> to the folder <b>plugin-data/superslider/ssExcerpt/excerpt-thumbs/</b>. 
             Categories with no excerpt image will display one of the random thumbnails.',$excerpt_domain); ?></span>
         </li>
     </ul>
   </fieldset>
</div><!-- close frag3 -->

<div id="fragment-4" class="ss-tabs-panel">
	
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
    	<?php _e(' Load Mootools 1.2 into your theme header.',$excerpt_domain); ?></label>
    	
	</li>
	
    <li style="border-bottom:1px solid #cdcdcd; padding: 6px 0px 8px 0px;">
  
    	<label for="op_css_load1">
			<input type="radio" name="op_css_load" id="op_css_load1"
			<?php if($Excerpt_newOptions['css_load'] == "default") echo $checked; ?> value="default" />
			<?php _e(' Load css from default location. excerpt plugin folder.',$excerpt_domain); ?></label><br />
    	<label for="op_css_load2">
			<input type="radio" name="op_css_load"  id="op_css_load2"
			<?php if($Excerpt_newOptions['css_load'] == "pluginData") echo $checked; ?> value="pluginData" />
			<?php _e(' Load css from plugin-data folder, see side note. (Recommended)',$excerpt_domain); ?></label><br />
    	<label for="op_css_load3">
			<input type="radio" name="op_css_load"  id="op_css_load3"
			<?php if($Excerpt_newOptions['css_load'] == "off") echo $checked; ?> value="off" />
			<?php _e(' Don\'t load css, manually add to your theme css file.',$excerpt_domain); ?></label>

    </li>
    </ul>
     </fieldset>
    
		<p>
		<?php _e(' If your theme or any other plugin loads the mootools 1.2 javascript framework into your file header, you can de-activate it here.',$excerpt_domain); ?></p><p><?php _e(' Via ftp, move the folder named plugin-data from this plugin folder into your wp-content folder. This is recomended to avoid over writing any changes you make to the css files when you update this plugin.',$excerpt_domain); ?></p></td>
	</div><!-- close frag 8 -->
</div><!--  close tabs -->

<p class="submit">
		<input type="submit" name="set_defaults" value="<?php _e(' Reload Default Options',$excerpt_domain); ?> &raquo;" />
		<input type="submit" id="update2" class="button-primary" value="<?php _e(' Update options',$excerpt_domain); ?> &raquo;" />
		<input type="hidden" name="action" id="action" value="update" />
 	</p>
 </form>
</div>
<?php
	echo "";
?>