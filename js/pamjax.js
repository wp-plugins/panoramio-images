if (window.attachEvent) {window.attachEvent('onload', retrieve);}
else if (window.addEventListener) {window.addEventListener('load', retrieve, false);}
else {document.addEventListener('load', retrieve, false);}

function retrieve(){
start = start * 1;
end = end * 1;
inc = end;

$.getJSON("http://www.panoramio.com/map/get_panoramas.php?order=popularity&set=public&from=" + start + "&to=" + end + "&minx=" + minx + "&miny=" + miny + "&maxx=" + maxx + "&maxy=" + maxy + "&size=" + size + "&format=json&callback=?",
			function(data)
			{
				$("#pamdiv").replaceWith('<div id="pamdiv"></div>')
				$.each(data.photos, function(i,item)
					{
					$("#pamdiv").append('<a href="http://www.panoramio.com/photo/' + $(this)[0].photo_id  + '"><img src="' + $(this)[0].photo_file_url + '" title="' + $(this)[0].photo_title + '" alt="' + $(this)[0].photo_title  + '" style="border:1px solid gray;margin-bottom:5px;margin:1px;"></a>');
			});
		});
		
} 

jQuery(document).ready(function() {
	 $("#pamore").click(function () { 


		start = start+inc;
		end = end+inc;
		$.getJSON("http://www.panoramio.com/map/get_panoramas.php?order=popularity&set=public&from=" + start + "&to=" + end + "&minx=" + minx + "&miny=" + miny + "&maxx=" + maxx + "&maxy=" + maxy + "&size=" + size + "&format=json&callback=?",
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
