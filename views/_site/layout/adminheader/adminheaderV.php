<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta name="description" content=""  />
<meta name="keywords" content=""  />
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name="robots" content="noindex,nofollow" />
<script src="/js/jquery.js"  type="text/javascript" ></script>
<script src="/js/plugins/ckeditor/ckeditor.js"  type="text/javascript" ></script>
<script src="/js/plugins/copyCont.js"  type="text/javascript" ></script>
<?
echo $this->getScripts();
echo $this->getStyles();
?>

<meta name="revisit-after" content="1 days" />
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon" />




</head>
<body>

<div id='container'>
	<div id='left'>
		<?
		if(user::isAuth()){
		?>
		<a class='menu' href='/admin/addnews/' >Добавить новость</a>
		<a class='menu' href='/admin/changenews/' >Изменить/удалить новость</a>
		<a class='menu' href='/admin/addcat/' >Добавить категорию</a>
		<a class='menu' href='/admin/changecat/' >Изменить/удалить категорию</a>
		<a class='menu' href='/admin/brand/' >Брендирование</a>
		
		<a class='menu' href='/action/user/logout/' >Выход</a>
		
		<?
		}else{
		?>
		<form method='post' action='/action/user/login/'>
			<input type='text' placeholder='Логин' name='login' /><br />
			<input type='password' placeholder='Пароль' name='password' /><br />
			<?$captcha=form::getCaptcha()?>
			<?=$captcha->img?><br />
			<?=$captcha->form?><br />
			<input type='submit' />
		</form>
		<?
		}
		?>
	</div>
	<div id='right'>
		<?if($error=msg::get('error')){
		?>
			<center><font color='red'><?=$error;?></font></center>
		<?
		}?>
		<?if($error=msg::get('success')){
		?>
			<center><font color='green'><?=$error;?></font></center>
		<?
		}?>
	
