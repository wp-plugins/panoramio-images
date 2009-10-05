<?php
/*
Plugin Name: Panoramio Images
Plugin URI: http://www.letsgeek.com/plugins/panoramio-images/
Description: Adds functions to retrieve values and images from panoramio.
Version: 1.2
Author: Rambash
Author URI: http://www.letsgeek.com/plugins/panoramio-images/

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

FUNCTIONS
	
	pam_get
	-Retrieves certain variables

	pam_show
	-Shows a set of images

	pam_showfromcenter
	-Shows a set of images based on one point

	pam_display
	-Checks if you've entered one coordinate or two coordinates and then retrieves the images.

HOWTO
Read the readme.txt
*/

add_action('wp_head', 'snoppinit', 0);
function snoppinit(){
wp_deregister_script('jquery');
wp_enqueue_script( 'jquery', WP_PLUGIN_URL . '/panoramio-images/js/jquery.js', false, '1.2.6');
wp_enqueue_script( 'pamjax', WP_PLUGIN_URL . '/panoramio-images/js/pamjax.js', array('jquery'), '1.0');

}

function pam_get($start, $end, $ll, $size, $var){

	$ll = explode(":",$ll);
	$url = 'http://www.panoramio.com/map/get_panoramas.php?order=popularity&set=public&from='.$start.'&to='.$end.'&minx='.$ll[0].'&miny='.$ll[1].'&maxx='.$ll[2].'&maxy='.$ll[3].'&size='.$size;
     
	$session = curl_init($url);

    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_FAILONERROR, true);
    curl_setopt($session, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($session, CURLOPT_TIMEOUT, 10);

    $stream = curl_exec($session);
    curl_close($session);
    $value = json_decode($stream, true);
	
	$arr = array();
	for ($i = $start; $i < $end; $i++)
	{
	 array_push($arr, $value["photos"][$i][$var]);
	}

	return $arr;
}

function pam_show($start, $end, $ll, $size){

	//If you want to change the output, edit here.
	if($ll)
		{
			echo '
			<div style="background-color:#ffffcd;padding:6px;border:1px solid #d7d8b9;margin-top:10px;">
				
					<center>
						<b>Area pictures</b><br />
						<div id="pamdiv">';
						$newstring =strstr ($string, "Boston");
						$arr = pam_get($start ,$end, $ll, $size, "photo_file_url");

						$ar = $arr;

							for($i=$start; $i<$end; $i++)
								{
									$ar[$i] = rtrim(strrchr($ar[$i], "/"), ".jpg");
								}	
						

						for($i=$start; $i<$end; $i++)
							{
								echo '<a href="http://www.panoramio.com/photo'.$ar[$i].'"><img src='.$arr[$i].' style="border:1px solid gray;margin-bottom:5px;margin:1px;"></a>';
							}		
					echo '</div>
					<p style="text-align:right;font-size: 85%;margin-right:1px;"><a href="#" id="pamore">See more photos</a></p>
					<p id="panoramio" style="color:#A1A1A1;font-size:85%;margin-top:3px;">Photos provided by <a href="http://www.panoramio.com">Panoramio</a> are under the copyright of their owners.</p></center>
			</div>';
		echo "<!-- plugin made by rambash - http://www.letsgeek.com/plugins/panoramio-images/ -->";
		$ll = explode(":",$ll);
		?>
		<script>
		var maxx = "<?= $ll[2] ?>";
		var maxy = "<?= $ll[3] ?>";
		var minx = "<?= $ll[0] ?>";
		var miny = "<?= $ll[1] ?>";
		var start = "<?= $start ?>";
		var end = "<?= $end ?>";
		</script>
		<?

		}
}

function pam_showfromcenter($start, $end, $centercoord, $radius, $size){

		//I have NO idea how accurate this is.
		list($long, $lat) = split(':', $centercoord);

		$maxx = $long + ((($radius*0.5) / 1.8553) *  0.016666666666666666666666666666667);
		$maxy = $lat + ((($radius*0.5) / 1.84293) *  0.016666666666666666666666666666667);
		$minx = $long - ((($radius*0.5) / 1.8553) *  0.016666666666666666666666666666667);
		$miny = $lat - ((($radius*0.5) / 1.84293) *  0.016666666666666666666666666666667);

		pam_show($start, $end, "$minx:$miny:$maxx:$maxy", $size);
		
}

function pam_display($start, $end, $coordinate, $size, $radius = 0.5){

			If(substr_count($coordinate, ":")>1)
			{
				pam_show($start, $end, $coordinate, $size);
				}
				else
				{
				pam_showfromcenter($start, $end, $coordinate, $radius, $size);
			}
}

function pam_widget($postmeta)
{
	if(is_single())
	{
		if($postmeta){
			pam_display(0, 6, $postmeta, "square");
		}
	}
}


?>
