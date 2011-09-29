package Form;

import java.io.IOException;
import java.sql.Date;
import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import DAO.DAOstudent;
import DAO.DAOuser;
import User.Student;
import User.User;

public class RegForm extends HttpServlet {
	private static final long serialVersionUID = 1L;
    public RegForm() {
        super();
    }
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		toDo(request, response);
	}
	@SuppressWarnings("deprecation")
	public void toDo(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException{
		String name, surname, birthday, skype, vkontakte, facebook, phone_1, phone_2, mail, pass;
		int id;
		try{
			response.setContentType("text/html; charset=utf-8");
			name = (String)request.getParameterValues("name")[0].trim();
			surname = (String)request.getParameterValues("surname")[0].trim();
			birthday = (String)request.getParameterValues("birthday")[0].trim();
			skype = (String)request.getParameterValues("skype")[0].trim();
			phone_1 = (String)request.getParameterValues("phone_1")[0].trim();
			phone_2 = (String)request.getParameterValues("phone_2")[0].trim();
			mail = (String)request.getParameterValues("mail")[0].trim();
			vkontakte = (String)request.getParameterValues("vkontakte")[0].trim();
			facebook = (String)request.getParameterValues("facebook")[0].trim();
			pass = (String)request.getParameterValues("pass")[0].trim();
			
			User user = new User(mail, pass);
			user.setPrivilege(0);
			DAOuser dao_user = new DAOuser(user);
			dao_user.INSERT();
			id = dao_user.getIDbyLogin();
			if(id!=0){
				user.setId(id);
				Date birthday_date = new Date(0);
				int dd, mm, yy;
				dd = Integer.parseInt(birthday.substring(0, 2));
				mm = Integer.parseInt(birthday.substring(3, 5));
				yy = Integer.parseInt(birthday.substring(6));
				
				birthday_date.setDate(dd);
				birthday_date.setMonth(mm - 1);
				birthday_date.setYear(yy - 1900);
				
				Student student = new Student(name, surname, mail, phone_1, phone_2, vkontakte, facebook, skype, birthday_date);
				student.setId(id);
				student.setPrivilege(0);
				DAOstudent dao_student = new DAOstudent(student);
				dao_student.INSERT();
				request.setAttribute("registrate", 1);
				
				//response.sendRedirect("reg_form.jsp");
				
				RequestDispatcher send = request.getRequestDispatcher("reg_form.jsp");
				send.forward(request, response);
				
			}else{
				//ѕользователь с таким логином уже есть
				request.setAttribute("registrate", 0);
				//response.sendRedirect("reg_form.jsp");
				RequestDispatcher send = request.getRequestDispatcher("reg_form.jsp");
				send.forward(request, response);
				
			}
			
			
			
			
		}catch (Exception e){
			e.printStackTrace();
			request.setAttribute("registrate", -1);
			RequestDispatcher send = request.getRequestDispatcher("reg_form.jsp");
			send.forward(request, response);
		}
	}
}
