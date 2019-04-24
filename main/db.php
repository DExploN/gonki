<?class db{	private static $_instance;	private $mysqli;	public $lastQuery;		private $mysql_in_pat=array();	private $mysql_in_sub=array();	private $mysql_out_pat=array();	private $mysql_out_sub=array();	private $mysql_filter_array=array("select","update","table","delete","where","insert","BENCHMARK","db","database","char","information_schema","ascii","CONCAT","group","count","sum","ORD","CONV","BIN","OCT","HEX","OUTFILE","load_file","\*","\/","#","--","user");	private function __construct(){	}	private function __clone(){	}		public static function getDb($host='',$user='',$password='',$db=''){		if(!self::$_instance){			$mysqli= new mysqli($host,$user,$password);			if ($mysqli->connect_errno) {				die("Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);			}else{				if($mysqli->select_db($db)){					$mysqli->query("SET CHARACTER SET utf8") or die($mysqli->error);					$mysqli->query("SET NAMES utf8") or die($mysqli->error);					$mysqli->query("SET character_set_client='utf8'") or die($mysqli->error);					$mysqli->query("SET character_set_results='utf8'") or die($mysqli->error);					$mysqli->query("SET collation_connection='utf8_general_ci'") or die($mysqli->error);					$obj=new self();					$obj->mysqli=$mysqli;					$obj->addFilter(array());					$obj::$_instance=$obj;					return $obj;				}				die($mysqli->error);			}		}else{			return self::$_instance;		}	}		public function addFilter($var){		if(is_array($var)){			$var=array_diff($var,$this->mysql_filter_array);			$this->mysql_filter_array=array_merge($this->mysql_filter_array,$var);		}else{			$var=explode(",",$var);			if(count($var)){				$var=array_diff($var,$this->mysql_filter_array);				$this->mysql_filter_array=array_merge($this->mysql_filter_array,$var);			}		}		$this->mysql_in_pat=array();		$this->mysql_in_sub=array();		$this->mysql_out_pat=array();		$this->mysql_out_sub=array();		foreach($this->mysql_filter_array as $value){			$this->mysql_in_pat[]="/".$value."/i";			$this->mysql_in_sub[]="___$0___";			$this->mysql_out_pat[]="/___(".$value.")___/i";			$this->mysql_out_sub[]="$1";		}	}			public function mysql_in($str){		$mysql_in_pat=$this->mysql_in_pat;		$mysql_in_sub=$this->mysql_in_sub;		if(is_array($str)){			foreach($str as $key=>$value){				$str[$key]=$this->mysql_in($value);			}			return($str);		}else{			$str=preg_replace($mysql_in_pat,$mysql_in_sub,$str);			$str=$this->mysqli->real_escape_string($str);			$str=trim($str);			return($str);		}	}	public function mysql_out($str){		$mysql_out_pat=$this->mysql_out_pat;		$mysql_out_sub=$this->mysql_out_sub;		if(is_array($str)){			foreach($str as $key=>$value){				$str[$key]=$this->mysql_out($value);			}			return($str);		}else{			$str=preg_replace($mysql_out_pat,$mysql_out_sub,$str);			return($str);			return($str);		}	}		public function query($query,$params=array()){		$query=$this->screening($query,$params);		$result=$this->mysqli->query($query) or print($this->mysqli->error);		$this->lastQuery=$query;		if(!$result) return false;		return  $result;	}		public function getByQuery($query,$params=array()){		$data=$this->getAllByQuery($query,$params);		if(!$data=array_shift($data)) return array();		return $data;	}		public function getAllByQuery($query,$params=array()){		$result=$this->query($query,$params);		if(!$result) return array();		$num=$result->num_rows;		$data=array();		for($i=0;$i<$num;$i++){			$data[]=$result->fetch_assoc();		}		return $this->mysql_out($data);	}		public function screening($str,$params){		if(is_array($params)){			foreach($params as $key=>$value){				$str=str_replace($key,$this->mysql_in($value),$str);			}		}		return $str;	}	public function getMysqli(){		return $this->mysqli;	}}?>