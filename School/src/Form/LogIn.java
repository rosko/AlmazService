package Form;

import java.io.IOException;
import java.sql.SQLException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import sun.awt.windows.ThemeReader;

import DAO.DAOstudent;
import DAO.DAOuser;
import User.Student;
import User.User;

public class LogIn extends HttpServlet {
	private static final long serialVersionUID = 1L;
    public LogIn() {
        super();
    }
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		try {
			toDo(request, response);
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		try {
			toDo(request, response);
		} catch (SQLException e) {
			e.printStackTrace();
		}
	}
	public void toDo(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException, SQLException{
	/*	System.out.println("LogIn");*/
		String pass, login;
		try{
			req.setAttribute("student", null);
			
			resp.setContentType("text/html; charset=utf-8");
			login = (String)req.getParameterValues("login")[0].trim();
			pass = (String)req.getParameterValues("pass")[0].trim();
			/*System.out.println("login: " + login);
			System.out.println("pass: " + pass);*/
			
			User user = new User(login, pass);
			DAOuser dao_user = new DAOuser(user);
			if(dao_user.LogIn()!=null){
				user = dao_user.LogIn();
				//System.out.println("id: " +user.getId() );
				if(user!=null){
					//System.out.println("user!=null");
					DAOstudent dao_student = new DAOstudent();
					dao_student.setId(user.getId());
					Student student = dao_student.SELECTbyID();
					student.setPrivilege(user.getPrivilege());
					
					
					req.setAttribute("student", student);
					RequestDispatcher send = req.getRequestDispatcher("index.jsp");
					send.forward(req, resp);
				}
			
			}else{
				System.out.println("Неверный логин/пароль");
				req.setAttribute("message", "Неверный логин/пароль");
				RequestDispatcher send = req.getRequestDispatcher("index.jsp");
				send.forward(req, resp);
			}
				
			
		}catch(SQLException e){
			e.printStackTrace();
		}
		/*req.setAttribute("student", null);
		RequestDispatcher send = req.getRequestDispatcher("index.jsp");
		send.forward(req, resp);*/
	}

}
