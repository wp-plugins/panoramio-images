jQuery(document).ready(function() {
	 $("#pamore").click(function () { 
		$.getJSON("http://www.panoramio.com/map/get_panoramas.php?order=popularity&set=public&from=0&to=6&minx=17.872631549835205&miny=59.317929544812046&maxx=17.889862060546875&maxy=59.322965844339194&size=square&format=json&callback=?",
			function(data)
			{
				$("#pamdiv").replaceWith('<div id="pamdiv"></div>')
				$.each(data.photos, function(i,item)
					{
					$("#pamdiv").append('<a href="http://www.panoramio.com/photo' + $(this)[0].photo_id  + '"><img src=' + $(this)[0].photo_file_url + ' style="border:1px solid gray;margin-bottom:5px;margin:1px;"></a>');
			});
		});
	});
});
