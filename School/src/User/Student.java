package User;

import java.sql.Date;

public class Student {
	protected String name, surname, mail, phone_1, phone_2, vkontakte, facebook, skype;
	protected Date birthday;
	protected int id, privilege;
	public Student(){
		name = "";
		surname = "";
		mail = "";
		phone_1 = "";
		phone_2 = "";
		vkontakte = "";
		facebook = "";
		skype = "";
		id = 0;
		privilege = 0;
		birthday = new Date(0);
	}
	public Student(Student student){
		name = new String(student.name);
		surname = new String(student.surname);
		mail = new String(student.mail);
		phone_1 = new String(student.phone_1);
		phone_2 = new String(student.phone_2);
		vkontakte = new String(student.vkontakte);
		facebook = new String(student.facebook);
		skype = new String(student.skype);
		id = student.id;
		privilege = student.privilege;
		birthday = student.birthday;

	}
	public Student(String Name, String Surname, String Mail, String Phone_1, String Phone_2, String Vkontakte, String Facebook, String Skype, Date Birthday){
		name = new String(Name);
		surname = new String(Surname);
		mail = new String(Mail);
		phone_1 = new String(Phone_1);
		phone_2 = new String(Phone_2);
		vkontakte = new String(Vkontakte);
		facebook = new String(Facebook);
		skype = new String(Skype);
		birthday = Birthday;
	}
	public void setId(int Id){
		id = Id;
	}
	public void setPrivilege(int Privilege){
		privilege = Privilege;
	}
	public String getName(){
		return name;
	}
	public String getSurname(){
		return surname;
	}
	public String getPhone_1(){
		return phone_1;
	}
	public String getPhone_2(){
		return phone_2;
	}
	public String getSkype(){
		return skype;
	}
	public Date getBirthday(){
		return birthday;
	}
	public String getVkontakte(){
		return vkontakte;
	}
	public String getFacebook(){
		return facebook;
	}
}
