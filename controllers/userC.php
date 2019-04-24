<?
class userC extends controller{
	static function login(){
	
		if(!user::login($_POST['login'],$_POST['password'])){
			msg::set('error','Логин и пароль не воспадают');
		}
		_siteC::backpage();

	}
	static function logout(){
		user::logout();
		_siteC::backpage();
	}
	static function captchaRules(){
		return array('login');
	}
	
	
}
?>