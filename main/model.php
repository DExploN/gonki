<?
class model{
	protected static $message=NULL;

	protected function setMessage($mess){
		static::$message=$mess;
	}
	static function getMessage(){
		$mess=static::$message;
		static::$message=NULL;
		return $mess;
	}

	public function filt($arrin,$arrfilt){
		return array_intersect_key($arrin,array_flip($arrfilt));
	}
}

?>