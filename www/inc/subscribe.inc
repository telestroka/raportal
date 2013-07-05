<!--form-->
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
<script language="JavaScript" type="text/javascript">
	$(document).ready(function(){			
		//add	
		$("form[name='add']").submit(function (){
			submit_form('add','<?=$module->NAME;?>',hide_form);		
			return false;
		});	
	});
</script>

<? 
	$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")); 	
	$dateMonthesOf = array(
						  		'',
								'января',
								'февраля',
								'марта',
								'апреля',
								'мая',
								'июня',
								'июля',
								'августа',
								'сентября',
								'октября',
								'ноября',
								'декабря'
								);
?>


Получая сводку публикаций НГС.БИЗНЕС, 
вы будете иметь удобный доступ к объявлениям 
и темам обсуждения новосибирского делового 
сообщества за прошедшую неделю.
<h2 style="margin-top: 20px; color: #598527;">ОФОРМИТЬ ПОДПИСКУ</h2>
Бесплатно. Сервис работает в тестовом режиме.
<form name="add" action="" method="get" class="form" style="display: block; margin: 15px 0 40px 0;">
	<input type="text" name="email" value="Укажите e-mail" maxlength="255" class="toggleval autowidth" style="color: #898989;"/>
	<button name="submit" type="submit">Подписаться</button>
	<div class="error"></div>
</form>
Чтобы оказаться от получения, перейдите по ссылке, расположенной в конце каждого выпуска.


<br/><br/><br/><br/><br/><br/><br/><br/>

<div style="padding-left: 30px;">
<a href="http://telestroka.ru">
<img src="logots.jpg"></a>
</div>

		<br/>
		<span style="font-size: 120%; color: #448cca">
			<b>Бегущая строка — реклама по-быстрому</b>
		</span><br/>


	<a href="http://telestroka.ru">
	Уже завтра, <?=date("j ", $tomorrow) . ' ' . $dateMonthesOf[date("n", $tomorrow)];?>, 
		ваше объявление может быть в эфире!
	</a><br>