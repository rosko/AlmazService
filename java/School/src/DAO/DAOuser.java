package DAO;

import java.sql.*;



import Conection.MyConnect;
import User.User;

public class DAOuser extends User{
	
	protected static String fields = "login, pass, privilege";
	protected static String insert_sql = "INSERT INTO user ("+fields+") VALUES (?,?,?)";
	protected static String test_sql = "SELECT * FROM user WHERE login LIKE ";
	protected static String login_sql = "SELECT * FROM user WHERE login LIKE '";
	public DAOuser(){
		super();
	}
	public DAOuser(User user){
		super(user);
	}
	public boolean TESTlogin() throws SQLException{
		boolean available = false;
		ResultSet rs = null;
		Connection conect = MyConnect.getConnect();
		if(conect!=null){
			Statement st = null;
			st = conect.createStatement();
			rs = st.executeQuery(test_sql + "'" + login + "'");
			int i=0;
			while(rs.next()){++i;}
			if(i==0){
				available = true;
			}
			st.close();
			rs.close();
			conect.close();
		}
		return available;
	}
	public void INSERT() throws SQLException{
		if(TESTlogin()){
			Connection conect = MyConnect.getConnect();
			if(conect!=null){
				PreparedStatement ps = null;
				ps = conect.prepareStatement(insert_sql);
				RecUser.insert(ps, login, pass, privilege);
				conect.close();
			}
		}
	}
	public int getIDbyLogin() throws SQLException{
		int id = 0;
		ResultSet rs = null;
		Connection conect = MyConnect.getConnect();
		if(conect!=null){
			Statement st = null;
			st = conect.createStatement();
			rs = st.executeQuery(test_sql +"'" +  login + "'");
			while(rs.next()){
				id = Integer.parseInt(rs.getString(1));
			}
			st.close();
			rs.close();
			conect.close();
		}
		return id;
	}
	public User LogIn() throws SQLException{
		int id = 0, privilege = 0;
		User user = null;
		ResultSet rs = null;
		Connection conect = MyConnect.getConnect();
		if(conect!=null){
			Statement st = null;
			st = conect.createStatement();
			String query = login_sql + login +"' AND pass LIKE '" + pass + "'"; 
			rs = st.executeQuery(query);
			System.out.println(query);
			while(rs.next()){
				id = Integer.parseInt(rs.getString(1));
				privilege = Integer.parseInt(rs.getString(4));
			}
			st.close();
			rs.close();
			conect.close();
			if(id!=0){
				user = new User(login, pass);
				user.setId(id);
				user.setPrivilege(privilege);
			}
		}
		return user;
	}
	static class RecUser{
		static void insert(PreparedStatement ps, String Login, String Pass, int Privilege) throws SQLException{
			ps.setString(1, Login);
			ps.setString(2, Pass);
			ps.setInt(3, Privilege);
			ps.executeUpdate();
		}
	}
}
