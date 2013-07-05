var path = document.location.href.split('/');
var module = path[path.length-2];

function submit_form(form_name, module, result_function)
{			
	show_loader();
	var query = $("form[name='"+form_name+"']").serialize();	
	var url = "/"+module+"/ajax/"+form_name+".php";
	if (module == '') url = "/ajax/"+form_name+".php";
	
	$.getJSON(url, query , function(data){
		if (data.result == 'ok')
		{
			result_function(form_name);
		}
		else
		{
			 $.each(data.errors, function(field,error){
				$("div.error").html(error);
			  });
		}
		hide_loader();
	});
}

function hide_form(form_name)
{
	var form = $("form[name='"+form_name+"']");
	$(".error").html('');
	form.hide();
	form.after('<p class="red">Спасибо, ваши данные приняты.<br/><a href="#" onclick="show_form(\''+form_name+'\'); return false;">Подписать еще один адрес</a></p>');
	return true;
}

function show_form(form_name)
{
	var form = $("form[name='"+form_name+"']");
	document.forms[form_name].reset()
	form.next().remove();	
	form.show();
	return true;
}

function show_back(form_name)
{
	var form = $("form[name='"+form_name+"']");
	form.hide();
	form.after('<p>Спасибо, данные изменены.<br/><br/><input type="button" value="Вернуться назад" onclick="history.back()"/></p>');
	return true;
}

function show_loader()
{
	$("body").append('<div id="loader">Пожалуйста, подождите...</div>');
	return true;
}

function hide_loader()
{
	$("body #loader").remove();	
	return true;
}

function back()
{
	history.back();
	return true;
}

function reload()
{
	location.reload();
	return true;
}