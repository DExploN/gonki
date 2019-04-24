<?
class adminC extends controller{
	static function index(){

		$view = new adminViewM();
		$view->finalRender("_site/text");
	}
	
	static function addnews(){

		$view = new adminViewM();
		
		$tbcat= new table('category');
		$data['catlist']=$tbcat->select('id,h1')->orderBy(array('h1'=>'asc'))->getall();
		$data['catlist']=array_merge(array(array('id'=>0,'h1'=>'-')),$data['catlist']);
		$view->finalRender("news/add",$data);
	}
	
	static function addnewsaction(){
		if(newsM::add($_POST)){
			cache::delete('/main/',true);
			cache::delete('/cat/',true);
			msg::set('success','Новость добавлена');
		}else{
			msg::set('error',newsM::getMessage());
		}		
		_siteC::backpage();
	}
	
	
	static function changenews(){
		if($_POST['delete'] && $_POST['id']){
			
			newsM::delete($_POST['id']);
			msg::set('success','Новость удалена');
			cache::delete('/main/',true);
			cache::delete('/cat/',true);
			if($id=(int)$_POST['id'])cache::delete('/detail/'.$id.'/',true);
			_siteC::backpage();
		}
		$view = new adminViewM();
		$tb=new table('news');
		$data['list']=$tb->select('id,h1')->orderBy(array('h1'=>'asc'))->getall();
		$data['update']=1;
		if($_POST['id']){
			$data['id']=(int)$_POST['id'];
			$data['item']=$tb->with(array('category'=>'id'))->where(array('id'=>$data['id']))->get();
			$tbcat= new table('category');
			$data['catlist']=$tbcat->select('id,h1')->orderBy(array('h1'=>'asc'))->getall();
			$data['catlist']=array_merge(array(array('id'=>0,'h1'=>'-')),$data['catlist']);

		}
		$view->finalRender("news/add",$data);
	}
	
	static function changenewsaction(){
		if(newsM::change($_POST)){
			cache::delete('/main/',true);
			cache::delete('/cat/',true);
			if($id=(int)$_POST['id'])cache::delete('/detail/'.$id.'/',true);
			msg::set('success','Новость изменена');
		}else{
			msg::set('error',newsM::getMessage());
		}		
		_siteC::backpage();
	}
	
	
	
	
	static function addCat(){

		$view = new adminViewM();
		$view->finalRender("category/add",$data);
	}
	
	static function addcataction(){
		if(categoryM::add($_POST)){
			msg::set('success','Категория добавлена');
		}else{
			msg::set('error',categoryM::getMessage());
		}		
		_siteC::backpage();
	}
	
	
	
	
	static function changecat(){
		if($_POST['delete'] && $_POST['id']){
			
			categoryM::delete($_POST['id']);
			msg::set('success','Категория удалена');
			if($id=(int)$_POST['id'])cache::delete('/cat/'.$id.'/',true);
			_siteC::backpage();
		}
		$view = new adminViewM();
		$tb=new table('category');
		$data['list']=$tb->select('id,h1')->orderBy(array('h1'=>'asc'))->getall();
		$data['update']=1;
		if($_POST['id']){
			$data['id']=(int)$_POST['id'];
			$data['item']=$tb->where(array('id'=>$data['id']))->get();
		}
		$view->finalRender("category/add",$data);
	}
	
	static function changecataction(){
		if(categoryM::change($_POST)){
			msg::set('success','Категория изменена');
			if($id=(int)$_POST['id'])cache::delete('/cat/'.$id.'/',true);
		}else{
			msg::set('error',categoryM::getMessage());
		}		
		_siteC::backpage();
	}
	
	
	static function brand(){
		$tb= new table('news');
		$data['games']=$tb->select('id,h1')->orderBy(array('h1'=>'asc'))->getall();
		
		$tb= new table('brand');
		$data['list']=$tb->select('news.id AS newid,url,brand.id,h1')->join('news','news.id=brand.gameid')->getAll();
		
		$view = new adminViewM();
		$view->finalRender("brand",$data);
	}
	static function brandaction(){
		if($_POST['add']){
			if($img=image::get('img',true)){
				if($img->imageType!='JPG'){
					msg::set('error','Изображение должно быть jpg');
				}else{
					$tb = new table('brand');
					$_POST['gameId']=(int)$_POST['gameId'];
					if($_POST['gameId']){
						$id=$tb->insert(array('gameId'=>$_POST['gameId']));
						$img->setname($id);
						$img->moveTo("/uploads/brand/");
						msg::set('success','Добавлено');
					}
				}	
			}else{
				msg::set('error','Не выбрано изображение');
			}
			
		}elseif($_POST['del']){
			$id=(int)$_POST['id'];
			if($id){
				$tb = new table('brand');
				$tb->delete($id);
				if($file=file::get('/uploads/brand/'.$id.'.jpg'))$file->delete();
				msg::set('success','Удалено');
			}	
		}
		
		_siteC::backpage();
	}
	
	static function gameckeck(){
		if($flash=newsM::checkgame($_POST['url'])){
			$md5=md5($flash->getContent());
			$tb= new table('news');
			$data=$tb->select('id,h1,url')->where(array('hash'=>$md5))->get();
			if($data){
				echo "<font color='red'>Игра присуствует: <a target='_blank' href='/g-".$data['id']."-".$data['url']."/'>".$data['h1']."</a></font>";
			}else{
				echo "<font color='green'>Игру можно загружать</font>";
			}
		}else{
			echo "<font color='red'>".newsM::getMessage()."</font>";
		}
		
	}
	
	static function resetorder(){
		//db::getDb()->query('UPDATE `news` SET `order`=FLOOR(10000*RAND())');
		/*
		db::getDb()->query('UPDATE `news` SET `order`=300+(FLOOR(100*RAND())) where CHARACTER_LENGTH(`text`)>=4000');
		db::getDb()->query('UPDATE `news` SET `order`=400+(FLOOR(100*RAND())) where CHARACTER_LENGTH(`text`)>=3000 and CHARACTER_LENGTH(`text`)<4000');
		db::getDb()->query('UPDATE `news` SET `order`=500+(FLOOR(100*RAND())) where CHARACTER_LENGTH(`text`)>=2000 and CHARACTER_LENGTH(`text`)<3000');
		db::getDb()->query('UPDATE `news` SET `order`=600+(FLOOR(100*RAND())) where CHARACTER_LENGTH(`text`)>=1000 and CHARACTER_LENGTH(`text`)<2000');
		db::getDb()->query('UPDATE `news` SET `order`=700+(FLOOR(100*RAND())) where CHARACTER_LENGTH(`text`)<1000');
		*/
	}
	static function mixorder(){
		/*
		db::getDb()->query('UPDATE `news` SET `order`=0+(FLOOR(100*RAND())) where `order`>=0 and `order`<100');
		db::getDb()->query('UPDATE `news` SET `order`=100+(FLOOR(100*RAND())) where `order`>=100 and `order`<200');
		db::getDb()->query('UPDATE `news` SET `order`=200+(FLOOR(100*RAND())) where `order`>=200 and `order`<300');
		db::getDb()->query('UPDATE `news` SET `order`=300+(FLOOR(100*RAND())) where `order`>=300 and `order`<400');
		db::getDb()->query('UPDATE `news` SET `order`=400+(FLOOR(100*RAND())) where `order`>=400 and `order`<500');
		db::getDb()->query('UPDATE `news` SET `order`=500+(FLOOR(100*RAND())) where `order`>=500 and `order`<600');
		db::getDb()->query('UPDATE `news` SET `order`=600+(FLOOR(100*RAND())) where `order`>=600 and `order`<700');
		db::getDb()->query('UPDATE `news` SET `order`=700+(FLOOR(100*RAND())) where `order`>=700 ');
		*/
	}
	
	static function accessRules(){
		return array(
			'addnews'=>user::isAuth(),
			'addnewsaction'=>user::isAuth(),
			'changenews'=>user::isAuth(),
			'changenewsaction'=>user::isAuth(),
			'addCat'=>user::isAuth(),
			'addcataction'=>user::isAuth(),
			'changecat'=>user::isAuth(),
			'changecataction'=>user::isAuth(),
			'gamecheck'=>user::isAuth(),
			'resetorder'=>user::isAuth(),
			'mixorder'=>user::isAuth()
		);
	}
	
	
}
?>