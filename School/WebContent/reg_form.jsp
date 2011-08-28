<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Регистрация нового студента</title>
</head>
<body>
<%
	if(request.getAttribute("registrate")!=null){
		int reg_state = (Integer)(request.getAttribute("registrate"));
		switch(reg_state){
		case 1 : 
			out.print("<h2><p><font color='green'>Регистрация прошла успешно!</font></p></h2>");
			out.print("<p><a href='index.jsp'>Вернуться на главную страницу</a></p>");
			break;
		case 0:
			out.print("<h2><p><font color='red'>Пользователь с такой почтой уже есть!</font></p></h2>");
			break;
		case -1:
			out.print("<h2><p><font color='blue'>Во время регистрации возникли неполадки. Повторите регистрацию через некоторое время.</font></p></h2>");
			out.print("<h2><p><font color='red'>Пользователь с такой почтой уже есть!</font></p></h2>");
			break;
		}	
	}
	
%>





	
	<form class="myform" name="form_reg" action="RegForm" method="post" onsubmit="return validate();">
	<p align="center" style="color:white; font-weight: 900; font-size: 25px; padding: 10px;">Регистрация</p>
   <table align="center" >
   <tr><td align="right">*Имя</td><td ><input name="name" type="text" maxlength="30" size="20"  /><span></span></td></tr>
   <tr><td align="right">*Фамилия</td><td ><input name="surname" type="text" maxlength="30" size="20"  /><span></span></td></tr>
   <tr><td align="right">*Дата рождения</td><td ><input name="birthday" type="text" maxlength="10" size="20"  /><span></span></td></tr>
   <tr><td align="right">Skype</td><td ><input name="skype" type="text" maxlength="20" size="20"  /><span></span></td></tr>
   <tr><td align="right">Мобильный(1)</td><td ><input name="phone_1" type="text" maxlength="10" size="20"  /><span></span></td></tr>
   <tr><td align="right">Мобильный(2)</td><td ><input name="phone_2" type="text" maxlength="10" size="20"  /><span></span></td></tr>
   <tr><td align="right">*Почта</td><td ><input name="mail" type="text" maxlength="20" size="20"  /><span></span></td></tr>
   <tr><td align="right">Vkontakte.ru</td><td ><input name="vkontakte" type="text" maxlength="40" size="20"  /><span></span></td></tr>
   <tr><td align="right">Facebook.com</td><td ><input name="facebook" type="text" maxlength="40" size="20"  /><span></span></td></tr>
   <tr><td align="right">*Пароль:</td><td ><input name="pass" type="password"  maxlength="20" size="20" /><span></span></td></tr>
   <tr><td align="right">*Пароль (повтор):</td><td ><input name="pass_re" type="password"  maxlength="20" size="20" /><span></span></td></tr>
   <tr><td></td><td align="right"><button><h3>Отправить</h3></button></td></tr>
   <tr><td colspan="2" style="font-size: 13px; color: red;">(*) отмечены обязательные поля для заполнения</td></tr>   
   </table>
  </form>


  
<script language="javascript">

  
	function validate() {
		valid = true;
		if ((document.form_reg.name.value == "")
				|| (document.form_reg.surname.value == "")
				|| (document.form_reg.birthday.value == "")
				/* 
				|| (document.form_reg.skype.value == "")
				|| (document.form_reg.phone_1.value == "")
				|| (document.form_reg.phone_2.value == "") */
				|| (document.form_reg.mail.value == "")
				/* || (document.form_reg.vkontakte.value == "")
				|| (document.form_reg.facebook.value == "") */
				|| (document.form_reg.pass.value == "")
				|| (document.form_reg.pass_re.value == "")

		) {
			alert("Пожалуйста, заполните все поля помеченные (*) !");
			valid = false;
		} else {
			var birthday_test = /^\s*([0-9]{2})(['.']{1})([0-9]{2})(['.']{1})([0-9]{4})\s*$/;
			if(!birthday_test.test(document.form_reg.birthday.value)){
				alert("Дата рождения должна соответствовать формату dd.mm.yyyy, например, 17.10.1987");
				return false;
			}
			
			var mail_test = /^\s*([a-zA-Z0-9_\-\.])+([@]{1})([a-zA-Z0-9_\-\.])+\.([A-Za-z]{2,4})\s*$/;
			if(!mail_test.test(document.form_reg.mail.value)){
				alert("Почта введена неверно!(например, myname@mymail.com)");
				return false;
			}
			
			var name_test = /^\s*([A-Za-zА-Яа-я])+\s*$/;
			if(!name_test.test(document.form_reg.name.value)){
				alert("Имя введено не корректно! (например, Иван)");
				return false;
			}
			
			var surname_test = /^\s*([A-Za-zА-Яа-я])+\s*$/;
			if(!surname_test.test(document.form_reg.surname.value)){
				alert("Фамилия введена не корректно! (например, Петров)");
				return false;
			}
			var phone_test = /^\s*([0-9]{10})\s*$/;
			if((document.form_reg.phone_1.value != "") && (!phone_test.test(document.form_reg.phone_1.value))){
				alert("Номер телефона(1) введен не верно! (например, 0637813645)");
				return false;
			}
			if((document.form_reg.phone_2.value != "") && (!phone_test.test(document.form_reg.phone_2.value))){
				alert("Номер телефона(2) введен не верно! (например, 0637813645)");
				return false;
			}
			
			if (document.form_reg.pass.value != document.form_reg.pass_re.value) {
				alert("Пароль не совпадает!");
				valid = false;
			}
		}

		return valid;
	}
</script>
</body>
</html>