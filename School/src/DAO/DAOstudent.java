package DAO;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;
import java.sql.Statement;

import Conection.MyConnect;
import User.Student;

public class DAOstudent extends Student{
	protected static String fields = "id, name, surname, birthday, skype, phone_1, phone_2, mail, vkontakte, facebook";
	protected static String insert_sql = "INSERT INTO user_info ("+fields+") VALUES (?,?,?, ?,?,?, ?,?,?, ?)";
	protected static String select_by_id = "SELECT * FROM user_info WHERE id=";
	public DAOstudent(){
		super();
	}
	public DAOstudent(Student student){
		super(student);
	}
	public Student SELECTbyID() throws SQLException{
		Student student = null;
		ResultSet rs = null;
		Connection conect = MyConnect.getConnect();
		if(conect!=null){
			Statement st = null;
			st = conect.createStatement();
			rs = st.executeQuery(select_by_id + id);
			while(rs.next()){
				name = (String)rs.getString(2);
				surname = (String)rs.getString(3);
				birthday = (Date)rs.getDate(4);
				skype = (String)rs.getString(5);
				phone_1 = (String)rs.getString(6);
				phone_2 = (String)rs.getString(7);
				mail = (String)rs.getString(8);
				vkontakte = (String)rs.getString(9);
				facebook = (String)rs.getString(10);		
			}
			st.close();
			rs.close();
			conect.close();
			student = new Student(name, surname, mail, phone_1, phone_2, vkontakte, facebook, skype, birthday);
			student.setId(id);
		}
		return student;
	}
	public void INSERT() throws SQLException{
		Connection conect = MyConnect.getConnect();
		if(conect!=null){
			PreparedStatement ps = null;
			ps = conect.prepareStatement(insert_sql);
			RecStudent.insert(ps, id, name, surname, birthday, skype, phone_1, phone_2, mail, vkontakte, facebook);
			conect.close();
		}
	}
	static class RecStudent{
		static void insert(PreparedStatement ps, int id, String name, String surname, Date birthday, String skype, String phone_1, String phone_2, String mail, String vkontakte, String facebook) throws SQLException{
			ps.setInt(1, id);
			ps.setString(2, name);
			ps.setString(3, surname);
			ps.setDate(4, birthday);
			ps.setString(5, skype);
			ps.setString(6, phone_1);
			ps.setString(7, phone_2);
			ps.setString(8, mail);
			ps.setString(9, vkontakte);
			ps.setString(10, facebook);
			ps.executeUpdate();
		}
	}
}
