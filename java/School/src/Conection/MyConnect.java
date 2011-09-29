package Conection;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class MyConnect {
	protected static String driver = "org.gjt.mm.mysql.Driver";
	protected static String login = "root";
	protected static String pass = "12345";
	protected static String base_address = "jdbc:mysql://localhost/cbsh?useUnicode=true&characterEncoding=utf8";

	public static Connection getConnect() throws SQLException{
		Connection cn = null;
		try{
			Class.forName(driver);
			try{
				cn = DriverManager.getConnection(base_address, login, pass);
				return cn;
			}finally{
				
			}
		}catch(ClassNotFoundException e){
			e.printStackTrace();
		}
		return cn;
	}
}
