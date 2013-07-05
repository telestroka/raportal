$().ready(function(){
		
	//auth	
	$("form[name='auth-form']").submit(function (){		
		show_loader();
		var title = $("form[name='auth-form'] input[name='title']").val();
		var password = $("form[name='auth-form'] input[name='password']").val();
					
		$.get("/users/ajax/login.php", {title:title,password:password} , function(data){
			if (data == 'ok')
			{
				window.location.reload();
			}
			else
			{
				alert('Введен неверный логин или пароль.');
			}
			hide_loader();
		});			
		
		return false;
	});	
		
	$("#logout").click(function ()
	{
		$.get("/users/ajax/logout.php", function(data) { if (data == 'ok') window.location.reload(); });
		return false;
	});	
});