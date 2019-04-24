<?
class view{
	private $styles=array();
	private $scripts=array();
	public $header="_site/layout/header";
	public $footer="_site/layout/footer";
	public $controller="_siteC";
	public $method="layout";
	
	
	public function render($view,$data=array()){
		if($data && !is_array($data)){echo "В шаблон $view подан не массив";return false;}		
		$viewName=end(explode('/',$view));
		$style="/views/".$view."/".$viewName.".css";
		$script="/views/".$view."/".$viewName.".js";
		$viewPath=ROOT."/views/".$view."/".$viewName."V.php";
		$stylePath=ROOT.$style;
		$scriptPath=ROOT.$script;
		if(file_exists($viewPath)){
			if(file_exists($stylePath))$this->styles[$style]=$style;
			if(file_exists($scriptPath))$this->scripts[$script]=$script;
			if(is_array($data)){
				extract($data,EXTR_PREFIX_SAME,"data_");
			}
			ob_start();
			include($viewPath);
			$str=ob_get_contents();
			ob_end_clean();
			return $str;
		}else{
			echo "Шаблон $view не найден";
			return false;
		}
	}
	
	public function finalRender($view,$data=array(),$flag=true){
		if($data && !is_array($data)){echo  "В шаблон $view подан не массив";return; }	
		
		$layoutData=_siteC::launchController($this->controller,$this->method,array($data),false);
		
		if(is_array($layoutData)){
			$data=array_merge($layoutData,$data);
		}else{
			$data['_layoutData']=$layoutData;
		}
		$middle=$this->render($view,$data);
		$footer=$this->render($this->footer,$data);
		$header=$this->render($this->header,$data);
		$str=$header.$middle.$footer;
		if($flag){
			echo $str;
		}else{
			return $str;
		}
	}
	
	public function addStyle($style){
		if(file_exists(ROOT.$style)){
			$this->styles[$style]=$style;
		}
	}
	public function addScript($script){
		if(file_exists(ROOT.$script)){
			$this->scripts[$script]=$script;
		}
	}
	
	public function getStyles(){
		foreach($this->styles as $style){
			$str.="<link href='$style' rel='stylesheet' type='text/css' />\r\n";
		}
		return $str;
	}
	public function getScripts(){
		foreach($this->scripts as $script){
			$str.="<script src='$script' type='text/javascript' ></script>\r\n";
		}
		return $str;
	}
}
?>