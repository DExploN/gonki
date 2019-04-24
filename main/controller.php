<?
class controller{
	private function __constoller(){}
	
	static function filt($arr){
		$data=func_get_args();
		array_shift($data);
		return array_intersect_key($arr,array_flip($data));
	}
	
	static function accessRules(){
		return array();
	}
	
	static function gAccess($action){
		$array=static::accessRules();
		if(isset($array[$action])){
			if($array[$action]===0 || $array[$action]===false){
				return false;
			}else{
				return true;
			}			
		}else{
			return true;
		}		
	}
	
	static function captchaRules(){
		return array();
	}
	
	static function gCaptcha($action){
		return array_search($action,static::captchaRules());
	}
}
?>