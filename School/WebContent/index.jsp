<%@page import="User.Student"%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Церковная Библейская Школа</title>
</head>
<body>
<%
	Student student = null;
	
	if(request.getAttribute("student")!=null){
		student = new Student((Student)request.getAttribute("student"));
	}else{
%>
  <form class="form_login" name="form_login" action="LogIn" method="post" onsubmit="return validate();">
   <table  >
   <tr><td align="right">логин:</td><td ><input name="login" type="text" maxlength="20" size="15"  /><span></span></td></tr>
   <tr><td align="right">пароль:</td><td ><input name="pass" type="password"  maxlength="20" size="15" /><span></span></td></tr>
   <tr><td align="right" style="font-size: 13px;"><a href="reg_form.jsp">Регистрация</a><br><a href="forget.jsp">Забыл пароль</a></td><td align="right"><button><h3>Вход</h3></button></td></tr>   
   </table>
  </form>	
<%	
	}
%>
 
  
<%
	if(student!=null){
		out.print("<p>Добро пожаловать, " + student.getName() + "!</p>");
	}
	if((String)request.getAttribute("message")!=null){
		out.print("<p>" + (String)request.getAttribute("message") + "</p>");
	}
%>
  
<script language="javascript">
  function validate (){
	valid = true;
    if ((document.form_login.login.value == "")||(document.form_login.pass.value == ""))
		{
                alert ("Пожалуйста, заполните все поля!");
                valid = false;
        }
        return valid;
}
</script>
</body>
</html>