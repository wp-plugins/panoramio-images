<?php
/*
Plugin Name: Panoramio Images
Plugin URI: http://www.letsgeek.com/plugins/panoramio-images/
Description: Adds functions to retrieve values and images from panoramio.
Version: 1.3
Author: Rambash
Author URI: http://www.letsgeek.com

Copyright 2009  Rambash (email : rambash@letsgeek.com)

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

add_action('wp_head', 'snoppinit', 0);
function snoppinit(){
wp_deregister_script('jquery');
wp_enqueue_script( 'jquery', WP_PLUGIN_URL . '/panoramio-images/js/jquery.js', false, '1.2.6');
wp_enqueue_script( 'pamjax', WP_PLUGIN_URL . '/panoramio-images/js/pamjax.js', array('jquery'), '1.0');

}

function widget_pam_show($coordinate, $args)
	{

			global $wpdb;
			extract( $args );
			$options =  get_option('widget_pam');
			$title = $options['title'];
		
			If(substr_count($coordinate, ":")==1)
			{
				//IF one coordinate
				
				//I have NO idea how accurate this is.
				list($long, $lat) = split(':', $centercoord);

				$maxx = $long + ((($radius*0.5) / 1.8553) *  0.016666666666666666666666666666667);
				$maxy = $lat + ((($radius*0.5) / 1.84293) *  0.016666666666666666666666666666667);
				$minx = $long - ((($radius*0.5) / 1.8553) *  0.016666666666666666666666666666667);
				$miny = $lat - ((($radius*0.5) / 1.84293) *  0.016666666666666666666666666666667);
				
				?>
					<script>
						var maxx =  "<?= $maxx ?>";
						var maxy =  "<?= $maxy ?>";
						var minx  =  "<?= $minx ?>";
						var miny  =  "<?= $miny ?>";
						var start  = 0;
						var end   = <?= $options['quantity'] ?>;
						var size   = "<?= $options['size']?>";
					</script>
				<?
				
			}else{
			//IF two coordinates
			$ll = explode(":",$coordinate);
			
			?>
				<script>
					var maxx = "<?= $ll[2] ?>";
					var maxy = "<?= $ll[3] ?>";
					var minx = "<?= $ll[0] ?>";
					var miny = "<?= $ll[1] ?>";
					var start = 0;
					var end = <?= $options['quantity'] ?>;
					var size = "<?= $options['size']?>";
			</script>
			<?
	}
		
	echo '<a name="pam"></a>
			<center>
				<b>'. $before_title . $title . $after_title .'</b><br />
				<div>
					<div id="pamdiv">Loading images...</div>
					<p style="text-align:right;font-size: 85%;margin-right:1px;"><a href="#pam" id="pamore">See more photos</a></p>
				</div>
				<p id="panoramio" style="color:#A1A1A1;font-size:85%;margin-top:3px;">Photos provided by <a href="http://www.panoramio.com">Panoramio</a> are under the copyright of their owners.</p>
			</center>';	
}

function widget_pam_control() {

		$options = $newoptions = get_option('widget_pam');
	
		if ( $_POST["pam-submit"] ) {
		$newoptions['title'] = strip_tags(stripslashes($_POST['pam-title']));
		$newoptions['size'] = $_POST['pam-size'];
		$newoptions['quantity'] = (int)$_POST['pam-quantity'];
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_pam', $options);
		}
	
	?><label for="pam-title" style="line-height:25px;display:block;"><?php _e('Widget title:', 'widgets'); ?> <input style="width: 200px;" type="text" id="pam-title" name="pam-title" value="<?php echo ($options['title'] )?>" /></label>
			<label for="pam-size" style="line-height:25px;display:block;">
				<?php _e('Image size:', 'widgets'); ?>
					<select style="width: 200px;" id="pam-size" name="pam-size">
						<option value="mini_square"<?php if ($options['size'] == 'mini_square') echo ' selected' ?>>Mini square</option>	
						<option value="square"<?php if ($options['size'] == 'square') echo ' selected' ?>>Square</option>
						<option value="thumbnail"<?php if ($options['size'] == 'thumbnail') echo ' selected' ?>>Thumbnail</option>
					</select>
			</label>
			<label for="pam-quantity" style="line-height:25px;display:block;">
				<?php _e('Quantity:', 'widgets'); ?>
					<select style="width: 200px;" id="pam-quantity" name="pam-quantity"/>
						<?php for($cnt=1;$cnt<=10;$cnt++): ?>
							<option value="<?php echo $cnt ?>"<?php if((int)$cnt == $options['quantity']) echo ' selected' ?>><?php echo $cnt ?></option>
						<?php endfor; ?>
					</select>
			</label>			
			<input type="hidden" name="pam-submit" id="pam-submit" value="1" /><?
}

function widget_pam_init() {

	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

    $data = get_option('widget_pam');
    if ( ! get_option('widget_pam')){
    $data = array( 'title' => 'Panoramio Images' ,'size' => 'square', 'quantity' => 6);
      add_option('widget_pam' , $data);
    } 
    
	// This prints the widget
	function widget_pam($args) {
	
	global $wp_query;
	
		if(get_post_meta($wp_query->post->ID, "panoramio", true))
		 {
		 	extract( $args );
			echo $before_widget;
			echo "\n".'<!-- Panoramio Images: START -->'."\n";
			echo widget_pam_show(get_post_meta($wp_query->post->ID, "panoramio", true), $args);
			echo "\n".'<!-- Widget made by Rambash - http://www.letsgeek.com -->'."\n";
			echo "\n".'<!-- Panoramio Images: END -->'."\n";
			echo $after_widget;
		}
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('Panoramio Images', 'widgets'), 'widget_pam');
	register_widget_control(array('Panoramio Images', 'widgets'), 'widget_pam_control');
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_pam_init');
?>
