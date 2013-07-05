<script language="JavaScript" type="text/javascript">
	$(document).ready(function(){		
		$("#view").click(function ()
		{
				var win1;
				win1 = window.open("", "view");
				win1.document.open();
				win1.document.writeln($("textarea[name='text']").val());
				win1.focus();
			return false;
		});
		
		$("form[name='add']").submit(function (){
						
			show_loader();
			var query = new Object();
			 $("form[name='add'] *[name]").each(function(){
				query[$(this).attr('name')] = $(this).val();
			  });
			
			var url = "/mail/ajax/add.php";
			
			$.post(url, query , function(data){
				if (data.result == 'ok')
				{
					alert('Рассылка завершена');
				}
				hide_loader();
			},"json");
			return false;
		});	
	});
</script>

<form name="add" action="" method="get" enctype="multipart/form-data" class="form">
	<label for="text">Адреса:</label>
	<textarea name="emails" rows="10" cols="17"><?
		if ($emails)
		{
			foreach ($emails as $email_id => $email_params)
			{
				echo $email_params['email'] . "\n";
			}
		}
	?>
	</textarea>
	<label for="title">Тема:</label>
	<input type="text" name="subject" value="Идеи и решения для бизнеса" maxlength="255" />
	<label for="text">Код:</label>
	<textarea name="text" rows="10" cols="17"><?=$message;?></textarea>
	<p><a href="#" id="view">Просмотреть</a></p>	
	<button name="submit" type="submit" class="submit">Разослать</button>
</form>