jQuery(document).ready(function() {
	 $("#pamore").click(function () { 
		start = start * 1;
		end = end * 1;

		start = start+6;
		end = end+6;
		$.getJSON("http://www.panoramio.com/map/get_panoramas.php?order=popularity&set=public&from=" + start + "&to=" + end + "&minx=" + minx + "&miny=" + miny + "&maxx=" + maxx + "&maxy=" + maxy + "&size=square&format=json&callback=?",
			function(data)
			{
				$("#pamdiv").replaceWith('<div id="pamdiv"></div>')
				$.each(data.photos, function(i,item)
					{
					$("#pamdiv").append('<a href="http://www.panoramio.com/photo/' + $(this)[0].photo_id  + '"><img src="' + $(this)[0].photo_file_url + '" title="' + $(this)[0].photo_title + '" alt="' + $(this)[0].photo_title  + '" style="border:1px solid gray;margin-bottom:5px;margin:1px;"></a>');
			});
		});
	});
});
