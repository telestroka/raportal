errors = new Array();
errors = {'system_error':'Произошла внутренняя ошибка','wrong':'Неверное значение поля','empty':'Поле должно быть заполнено','0-255':'Длина поля должна быть от 0 до 255 символов','1-255':'Длина поля должна быть от 1 до 255 символов','6-255':'Длина поля должна быть от 6 до 255 символов','0-2000':'Длина поля должна быть от 0 до 2000 символов','1-2000':'Длина поля должна быть от 1 до 2000 символов','damn':'Поля не должны содержать нецензурных выражений','exist':'Поле с таким именем уже существует','exist_file':'Файл с указанным именем уже существует. Попробуйте его переименовать','upload_error':'Ошибка закачки файла','upload_image':'Можно закачать файл только в формате jpg, gif или png','upload_file':'Указанный объект не явлется файлом','email':'Введен несуществующий адрес e-mail','login_error':'Не верный логин или пароль','password_confirm':'Пароль и подтверждение должны совпадать','num':'Поле должно состоять только из цифр','icq':'Введен несуществующий адрес icq','url':'Введен несуществующий адрес сайта','ip':'Введен несуществующий ip','date':'Введена несуществующая дата','code':'Введен неверный код подтверждения','cat':'Выберите категорию','login':'Логин должен состоять из символов A-Za-z0-9_','login_length':'Длина логина должна быть от 1 до 255 символов','nic':'Длина ника должна быть от 1 до 255 символов','password':'Длина пароля должна быть от 6 до 255 символов','name':'Слишком короткое имя','gender':'Введен несуществующий пол','birthday':'Введена несуществующая дата','city':'Слишком короткое название города','company':'Слишком короткое название компании','occupation':'Слишком короткое название рода занятий','is_user':'Пользователь с таким логином уже существует, придумайте другой логин','search':'Строка поиска должна быть от 1 до 255 символов'};

function is_system(string)
{
	   re = /\W/;
	   if (re.test(string)) return(false);
	   return(true);
}

function is_right_length(string,min,max)
{
	   if ( string.length>max ) return(false);
	   if ( string.length<min ) return(false);
	   return(true);
}

function is_empty(string)
{
	   if ( string.length>0 ) return(false);
	   return(true);
}

function is_email(string)
{
	if ( string.length<6 ) return(false);
	if (string.indexOf('@') == -1) return(false);
	if (string.indexOf('.') == -1) return(false);
	return(true);
}

function is_url(string)
{
	if ( string.length<4 ) return(false);
	if (string.indexOf('.') == -1) return(false);
	return(true);
}

function is_icq(string)
{
   if ( string.length>9 ) return(false);
   if ( string.length<5 ) return(false);
   re = /\d/;
   if (re.test(string)) return(true);
   return(false);
}

function is_digital(string)
{
	   re = /\d/;
	   if (re.test(string)) return(true);
	   return(false);
}

function is_ip(string)
{
	   if ( string.length>15 ) return(false);
	   if ( string.length<7 ) return(false);
	   re = /\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/;
	   if (re.test(string)) return(true);
	   return(false);
}

function is_image(string)
{
	string = string.toLowerCase();	
	if (string.indexOf('.jpg') != -1) return(true);
	if (string.indexOf('.jpeg') != -1) return(true);
	if (string.indexOf('.gif') != -1) return(true);
	if (string.indexOf('.png') != -1) return(true);
	return(false);
}

//other
function set_error(field, error)
{
	alert(error);
	field.style.background="#EE9D9A";
	return(false);
}