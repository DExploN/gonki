<?
function autoload_ns($class){
	$ar=explode("\\",$class);
	$ar=array_diff($ar,array('',NULL));
	$file=array_pop($ar);
	if(count($ar)){
		$path=ROOT."/".implode("/",$ar)."/".$file.".php";
	}else{
		if(preg_match("/.+C$/",$file)){
			$path=ROOT."/controllers/".$file.".php";
		}elseif(preg_match("/.+M$/",$file)){
			$path=ROOT."/models/".$file.".php";
		}else{
			$path=ROOT."/main/".$file.".php";
		}
	}
	$path=str_replace("//","/",$path);
	if(file_exists($path)){
		include_once($path);
	}
}
spl_autoload_register("autoload_ns");

?>