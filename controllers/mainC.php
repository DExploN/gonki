<?
class mainC extends controller{
	static function index($page=1){
		$view = new view();
			
		
		
		$data=cache::read("/main/".$page,function($page){
			$tb= new table('news');
			$data['list']=$tb->page($page,config::get('gridgamescount'),$n)->select('h1,text,url,id,gamevid')->orderby(array('order'=>'asc','id'=>'desc'))->getall();
			$paginator= new paginator($page,config::get('gridgamescount'),$n);
			$data['paginator']=$paginator->build();
			$data['page']=$page;
			return $data;
		},array($page));
	
		if(!count($data['list']))_siteC::code404();
		
		if($file=file::get('/uploads/texts/main.txt')){
			$data['text']=$file->getContent();
		}

		
		
		$view->addScript("/soclikes/social-likes.min.js");
		$view->addStyle("/soclikes/social-likes_classic.css");
		
		
		$data['h1']='Игры гонки';
		$data['title']='Игры гонки для мальчиков играть онлайн бесплатно';
		$data['description']=str::crop(strip_tags($data['text']),150,'...');
		$data['keywords']='Игры гонки, гонки для мальчиков, играть, онлайн, бесплатно, мини флеш игры';
		
		if($page>1){
			$data['title'].=". Страница ".$page;
			$data['description'].=". Страница ".$page;
			$data['keywords'].=". Страница ".$page;
		}
		
		preg_match("/[0-9a-z\/]*\.jpg/i",$data['text'],$matches);
		if($matches[0]){
			$data['og_image']='http://gonki-games.ru'.$matches[0];
		}
		
		
		$view->finalRender("news/gamesgrid",$data);
	}
	
	static function game($id,$url){
		$view = new view();
		
		
		$data=cache::read("/detail/".$id."/",function($id){
			$tb= new table('news');
			$data=$tb->with(array('category'=>'h1,url,id'))->where(array('id'=>$id))->get();
			if($data['gamevid']){
			$data['perelink']=$tb->select('id,h1,url,gamevid')->perelinkByrel($id,array('category'=>'*'),4);
			}else{
				$data['perelink']=$tb->select('id,h1,url,gamevid')->perelinkByrel($id,array('category'=>'*'),8);
			}
			
			if(mb_strlen($data['text'])>5000){
				$contright=14;
			}if(mb_strlen($data['text'])>4000){
				$contright=12;
			}elseif(mb_strlen($data['text'])>3000){
				$contright=10;
			}elseif(mb_strlen($data['text'])>2000){
				$contright=8;
			}else{
				$contright=6;
			}
			$data['right']=db::getDb()->getAllByQuery("select `id`,`h1`,`url`,`gamevid` from `news` where `id`!='".$id."' order by rand() limit ".$contright);

			return $data;
		},array($id));
		
		if(!$data['h1'])_siteC::code404();
		if($data['url']!=$url)_siteC::code404();
				
		
		if(file::get('/uploads/news/'.$id.'.swf')){
			$data['swf']='/uploads/news/'.$id.'.swf';
		}
		$view->addScript("/soclikes/social-likes.min.js");
		$view->addStyle("/soclikes/social-likes_classic.css");
		
		
		
		

		
		$data['og_image']='http://gonki-games.ru/uploads/news/'.$id.'.jpg';
		
		if(!$data['title']){
			$data['title']="Игра ".$data['h1'].' играть онлайн бесплатно';
			if($data['category']){
				$data['title'].=' в '.$data['category'][0]['h1'];
			}else{
				$data['title'].=' в гонки';
			}
			
		}
		
		$data['breadcrumb']="<div id='bread' xmlns:v='http://rdf.data-vocabulary.org/#'><span typeof='v:Breadcrumb'><a href='/' rel='v:url' property='v:title'>Игры гонки</a></span>";
		if($data['category'])$data['breadcrumb'].=" &rarr;  <span typeof='v:Breadcrumb'><a href='/c-".$data['category'][0]['id']."-".$data['category'][0]['url']."/'  rel='v:url' property='v:title'>игры ".$data['category'][0]['h1']."</a></span>";
		$data['breadcrumb'].="</div>";
				
		$data['description']=str::crop(strip_tags($data['text']),150,'...');
		$data['keywords']=$data['h1'].', играть, онлайн, бесплатно, гонки, мини флеш игра';
		
		$view->finalRender("news/game",$data);
		
	}
	
		
	static function games($id,$url,$page=1){
	
		$view = new view();
		
		$data=cache::read("/cat/".$id."/".$page,function($id,$page){
				$tb= new table('category');
				$data=$tb->where(array('id'=>$id))->get();
				$tb= new table('news');
				$data['list']=$tb->page($page,config::get('gridgamescount'),$n)->select('h1,text,url,id,gamevid')->orderby(array('order'=>'asc','id'=>'desc'))->getAllByRel(array('category'=>$id));
				$paginator= new paginator($page,config::get('gridgamescount'),$n);
				$data['paginator']=$paginator->build();
				$data['page']=$page;
				return $data;
		},array($id,$page));
	
		if(!$data['h1'])_siteC::code404();
		if(!$data['list'])_siteC::code404();
		if($data['url']!=$url)_siteC::code404();
		
		if($page>1)$data['noindex']=true;
		
		$view->addScript("/soclikes/social-likes.min.js");
		$view->addStyle("/soclikes/social-likes_classic.css");
		
		$data['h1']='Игры '.$data['h1'];
		if(!$data['title']){
			$data['title']=$data['h1'].' играть онлайн бесплатно';
		}
				
		$data['description']=str::crop(strip_tags($data['text']),150,'...');
		$data['keywords']=$data['h1'].', играть, онлайн, бесплатно, мини флеш игры';
		
		
		if($page>1){
			$data['title'].=". Страница ".$page;
			$data['description'].=". Страница ".$page;
			$data['keywords'].=". Страница ".$page;
		}
		
		preg_match("/[0-9a-z\/]*\.jpg/i",$data['text'],$matches);
		if($matches[0]){
			$data['og_image']='http://gonki-games.ru'.$matches[0];
		}
		
		$view->finalRender("news/gamesgrid",$data);
	}
	
	
	static function search(){
		$page=(int)$_GET['page'];
		$tb= new table('news');
		if($_GET['text']){
		$data['list']=$tb->page($page,config::get('gridgamescount'),$n)->select('h1,text,url,id,gamevid')->orderby(array('h1'=>'asc'))->search("h1",$_GET['text'])->getAll();
		$paginator= new paginator($page,config::get('gridgamescount'),$n);
		$paginator->get=1;
		$data['paginator']=$paginator->build();
		$data['page']=$page;
		}else{
			$data['list']=array();
			
		}
		
		$data['h1']='Поиск: '.htmlspecialchars($_GET['text']);
		$data['title']=$data['h1'];
		$data['noindex']=1;
		$data['noadsense']=1;
		
		$view = new view();
		$view->addScript("/soclikes/social-likes.min.js");
		$view->addStyle("/soclikes/social-likes_classic.css");
		$view->finalRender("news/gamesgrid",$data);
	}
	

	
}
?>