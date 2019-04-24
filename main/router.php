<?
namespace main;
class router{
	private $routes=array();
	public function __construct(){
	}
	public function addRoute($path,$target){
		$route= new route($path,$target);
		$this->routes[]=$route;
		return $route;
	}

	public function getRoute($path=NULL){
		if($path===NULL)$path="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$temp=parse_url($path);
		$host=$temp['host'];
		$url=$temp['path'];
		if($temp['query'])$url.='?'.$temp['query'];
		
		foreach($this->routes as $route){
			$pattern="/^".addcslashes($route->path,"/")."$/i";
			if(preg_match($pattern,($route->host)?$host.$url:$url,$matches)){
				unset($matches[0]);
				$route->vars=$matches;
				
				foreach($matches as $key=>$value){
					$route->target=str_replace("$".$key,$value,$route->target);
				}
				foreach($route->query as $key=>$value){
					if($matches[$value]){
						$route->query[$key]=$matches[$value];
					}else{
						$route->query[$key]=false;
					}					
				}
				if(!$route->code)$route->code=200;
				return $route;
			}
		}
		
		$route= new route();
		$route->code=404;
		return $route; 
		 
	}
	
}
class route{
	public $path;
	public $target;
	public $host;
	public $code;
	public $vars;
	public $query=array();
	public $controller;
	public $method;
	public function __construct($path=NULL,$target=NULL){
		$this->path=$path;
		$this->target=$target;
	}
	public function host(){
		$this->host=1;
		return $this;
	}
	public function query($array){
		if(is_array($array))$this->query=$array;
		return $this;
	}
	public function code($code){
		$this->code=$code;
		return $this;
	}
}

?>