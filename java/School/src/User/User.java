package User;

public class User {
	protected String login;
	protected String pass;
	protected int id, privilege;
	public User(){
		login = "";
		pass = "";
		id = 0;
		privilege = 0;
	}
	public User(User user){
		setLogin(user.login);
		setPass(user.pass);
		id = user.id;
		privilege = user.privilege;
	}
	public User(String Login, String Pass){
		login = new String(Login);
		pass = new String(Pass);
	}
	public void setLogin(String Login){
		login = new String(Login);
	}
	public void setPass(String Pass){
		pass = new String(Pass);
	}
	public void setId(int Id){
		id = Id;
	}
	public void setPrivilege(int Privilege){
		privilege = Privilege;
	}
	public String getLogin(){
		return login;
	}
	public String getPass(){
		return pass;
	}
	public int getId(){
		return id;
	}
	public int getPrivilege(){
		return privilege;
	}
}
