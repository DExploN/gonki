<?

class _siteC extends controller{
	static $route;
	static function launchSite($route){
		self::$route=$route;
		msg::init();
		$_POST=str::recursiveTrim($_POST);
		$_GET=str::recursiveTrim($_GET);
		mb_internal_encoding("UTF-8");
		if(config::get('host') && config::get('user') && config::get('db'))db::getDb(config::get('host'),config::get('user'), config::get('password'), config::get('db'));
		
		switch($route->code){
			
			case 200:
				$CA=explode('/',$route->target);
				$route->controller=$CA[0]."C";
				$route->method=($CA[1])?$CA[1]:'index';
				self::launchController($route->controller,$route->method,$route->vars);
				break;
			case 404:
				self::launchController('_siteC','code404');
				break;				
			case 301:
				self::launchController('_siteC','code301',array($route->target));		
		}
		
	}
	static function launchController($controller,$method,$data=array(),$flag=true){
		
		if(class_exists($controller)){
			if(method_exists($controller,$method)){
				$access=call_user_func_array(array($controller,'gAccess'),array($method));
				if($access){
					if(call_user_func_array(array($controller,'gCaptcha'),array($method))!==false){
						if(!form::checkCaptcha()){
							msg::set('error','Ошибка каптчи');
							self::backpage();
						}	
					}
					$data=call_user_func_array(array($controller,$method),$data);
					return $data;
				}else{
					//echo "Нет доступа к $controller/$method";
					self::code404("Нет доступа");
				}				
			}else{
				//echo "Метод ".$method." Контроллера ".$controller.' не найден';
				
				if($flag)self::code404("Страница не найдена. Error method");
			}
		}else{
			//echo "Контроллер ".$controller.' не найден';
			
			if($flag)self::code404("Страница не найдена. Error controller");
			
		}
	}
	
	
	
	
	static function code404($message='Страница не найдена'){
		header("HTTP/1.0 404 Not Found");
		$data=array('message'=>$message);
		$data['noindex']=true;
		$data['title']=$message;
		$view= new view();
		$view->finalRender("_site/code404",$data);
		exit();	
	}
	static function code301($url){
		header("HTTP/1.1 301 Moved Permanently");
		header("Location:".$url);
		exit();
	}
	
	public function backpage(){
		header("Location:".$_SERVER['HTTP_REFERER']);
		exit();	
	}
	
	static function redirect($url){
		header("Location:".$url);
		exit();
	}
	
	static function ckeditor(){
		$callback = $_REQUEST['CKEditorFuncNum'];
		$message='';
		$path='';
		if($file=file::get("upload",true)){
			$tm=time();
			$name=mb_substr(md5($file->name.$tm),16);
			$name.=$tm;
			$file->name=$name.".".$file->ext;
			$file->moveTo("/uploads/ckeditor/".date('Y/m/d')."/");
			$path=$file->cropPath;
		}else{
			$message="Ошибка загрузки файла";
		}
		echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$path.'", "'.$message.'" );</script>';
	}
	
	
	static function layout($datain){
		
		$row=db::getDb()->getByQuery("select `news`.`id` AS `newid`,`url`,`brand`.`id` from `brand` join `news` on `news`.`id`=`brand`.`gameid` order by rand() limit 1");
		
		if(($file=file::get('/uploads/brand/'.$row['id'].'.jpg')) && $row['id'] && $row['newid']){
			$data['brand']['img']=$file->cropPath;
			$data['brand']['link']="/g-".$row['newid'].'-'.$row['url'].'/';
		}
		return $data;
	}
	
	static function accessRules(){
		return array(
			'ckeditor'=>user::isAuth(),
		);
	}
}
?>