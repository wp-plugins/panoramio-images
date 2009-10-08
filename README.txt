=== Panoramio Images ===
Contributors: Rambash
Donate link: -
Tags: panoramio, api, images, widget, sidebar
Requires at least: -
Tested up to: -
Stable tag: trunk

A wordpress plugin for retrieving images and values through the Panoramio API.

== Description ==

A wordpress widget that retrieve images from Panoramio API.

HOW TO

To display the widget, add a custom field to a post called "panoramio". The value of panoramio should be the coordinate to the area that you want to display pictures from.
The value should be formatted like this: X:Y

It is also possible to supply the script with two coordinates, for a more precise area. Use this format: minx:miny:maxx:maxy  

All coordinates should be given in the decimal form of latitude/longitude. I recommend using http://mapki.com/getLonLat.php.

CHANGELOG
1.3:
-Added AJAX support
-Converted the script into a widget
-Reduced the code
-Fixed some bugs

== Installation ==
1. Unzip panoramio-images.zip
2. Place the panoramio-images folder into /wp-content/plugins/
3. Activate the plugin in the admin panel
4. Navigate to widget settings page, drag the widget into your sidebar and set your preferences

== Screenshots ==

1. The output from pam_display