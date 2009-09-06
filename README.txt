=== Panoramio Images ===
Contributors: rambash
Donate link: -
Tags: panoramio, api, images
Requires at least: -
Tested up to: -
Stable tag: trunk

A wordpress plugin for retrieving images and values through the Panoramio API.

== Description ==

A wordpress plugin for retrieving images and values through the Panoramio API.


== Installation ==
Just copy the files to your wordpress plugins directory and activate it through the admin interface.

== Screenshots ==

1. The output from pam_display

== FUNCTIONS ==
pam_get($start, $end, $ll, $size, $var)

	* returns $var-values into an array

pam_show($start, $end, $ll, $size)

	* displays images

pam_showfromcenter($start, $end, $centercoord, $radius, $size)

	* creates a rectangle around $centercoord with the sides being $radius in km

pam_display($start, $end, $coordinate, $size, $radius = 0.5)

	* Checks if you've entered one coordinate or two coordinates and then retrieves the images.

== VARIABLES ==

$start

	* Integer value that decides where panoramio should start retrieving images.

$end	

	* Integer value that decides where panoramio should stop retrieving images.

$size

	* medium
	* small
	* thumbnail
	* square
	* mini_square

$var

	  Name			  Ex
	* photo_id Ex     505229
	* photo_title     Etangs près de Dijon"
	* photo_url       http://www.panoramio.com/photo/505229"
	* photo_file_url  http://static2.bareka.com/photos/medium/505229.jpg"
	* longitude       5.168552
	* latitude        47.312642
	* width           350
	* height          500
	* upload_date     20 January 2007
	* owner_id        78506 
	* owner_name      Philippe Stoop
	* owner_url       http://www.panoramio.com/user/78506


$ll

	* Top left and bottom right coordinates for the rectangle. The coordinates should be the latitudes/longitudes decimal form and formatted like this: minx:miny:maxx:maxy. 


$centercoord

	* Single coordinate. The coordinates should be the latitudes/longitudes decimal form and formatted as this: x:y

$radius

	* It defines the length in km of the sides of the box created in pam_showfromcenter


== EXAMPLES ==


1: Show the five first thumbnails from coordinates given in a posts custom field called "panoramio".

        * pam_show(0,5, get_post_meta($post->ID, "panoramio", true), "thumbnail");


2: Retrieving a specific variable from the five first thumbnails and placing it into an array.


        * pam_get(0, 5, 17.872631549835205:59.317929544812046:17.889862060546875:59.322965844339194, "thumbnail", "owner_name")

3: Show six thumbnails in an area of 500x500m around a coordinate


	* pam_showfromcenter(0, 6, "17.881622314453125:59.320666756687736", 0.5, "square");

4: Show six thumbnails. If two points are given then it retrieves the images from that rectangle. If only a single point is given then it creates a 500x500m rectangle and checks for images.


	* pam_display(0, 6, 17.872631549835205:59.317929544812046, "square", 0.5);


== MISC ==

All coordinates should be given in the decimal form of latitude/longitude. I recommend using http://mapki.com/getLonLat.php.
