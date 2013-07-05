function change_news(id)
{
	url='/ajax/news.php?id=' + id;
	request.open("GET", url, true);
	request.setRequestHeader("X-Requested-With","XMLHttpRequest");
	request.onreadystatechange =  function ()
	{
		if (request.readyState == 4 && request.status == 200)
			if (request.responseText && request.responseText != '')
			{
				//prev|||next|||id|||title|||text|||date
				result = request.responseText.split('|||');
				prev = result[0];
				next = result[1];
				id = result[2];
				title = result[3];
				text = result[4];
				date = result[5];
				
				document.getElementById('news_prev').href = "javascript:change_news(" + prev + ")";
				document.getElementById('news_next').href = "javascript:change_news(" + next + ")";
				document.getElementById('news_title').innerHTML = title;
				document.getElementById('news_text').innerHTML = text;
				document.getElementById('news_date').innerHTML = date;
				
				if (next != '') document.getElementById('news_next').style.display = 'inline';
				else document.getElementById('news_next').style.display = 'none';
				if (prev != '') document.getElementById('news_prev').style.display = 'inline';
				else document.getElementById('news_prev').style.display = 'none';
			}
	}
	request.send(null);
}