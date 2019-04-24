<?
class config{
	static private $data=array(
		'host'=>'localhost',
		'user'=>'dexplon',
		'password'=>'qwerty12345',
		'db'=>'gonki',
		'tablesRelations'=>array('news-category'=>'news_category'),
		'gridgamescount'=>32,

	);
	
	static function get($name){
		return self::$data[$name];
	}
}

?>
