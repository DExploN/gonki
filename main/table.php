<?
class table{
	private $tableName;
	private $db;
	private $relations=array();
	private $rules=array();
	private $clear=true;
	private $page;
	private $with;
	
	public function __construct($tableName){
		$this->tableName=$tableName;
		$this->db=db::getDb();
		if(is_array($rel=config::get('tablesRelations'))){
			foreach($rel as $key=>$value){
				if(preg_match("/".$tableName."\-([a-z0-9\_]+)/i",$key,$match)){
					$this->relations[$match[1]]=$value;
				}
				if(preg_match("/([a-z0-9\_]+)\-".$tableName."/i",$key,$match)){
					$this->relations[$match[1]]=$value;
				}
			}
		}
	}
	public function clear(){
		$this->rules=array();
		$this->with=NULL;
		$this->page=NULL;
		return $this;
	}
	
		
	public function get(){
		$data=array_shift($this->getAll(1));
		if($data)return $data;
		return array();
	}
	
	public function getAll($count=0){
		$count=(int)$count;
		if($count>0)$this->limit($count);
		if($this->page){
			$this->limit(($this->page['numPage']-1)*$this->page['countPerPage'],$this->page['countPerPage']);
		}
				
		$query="select ";
		if(!$this->rules['select']){
			$query.="* ";
		}else{
			$query.=$this->rules['select'];
		}
		$query.=' from `'.$this->tableName.'` ';
		$query.=' '.$this->rules['join'].' ';
		$query.=' '.$this->rules['where'].' ';
		$query.=' '.$this->rules['groupBy'].' ';
		$query.=' '.$this->rules['having'].' ';
		$query.=' '.$this->rules['orderBy'].' ';
		$query.=' '.$this->rules['limit'].' ';
		
	
		
		$data=$this->db->getAllByQuery($query);
		
		if(is_array($this->with)){
			$data=$this->doWith($data);
		}
		
		
		
		
		if($this->page && $this->page['n']!==false){
			if($this->rules['groupBy']){
				$query="select `".$this->tableName."`.`id` as `id` ";
				$query.=' from `'.$this->tableName.'` ';
				$query.=' '.$this->rules['join'].' ';
				$query.=' '.$this->rules['where'].' ';
				$query.=' '.$this->rules['groupBy'].' ';
				$query.=' '.$this->rules['having'].' ';
				$query.=' '.$this->rules['orderBy'].' ';
				$query="select count(`id`) as `num` from (".$query.")`t`";
			}else{
				$query="select count(`id`) as `num` ";
				$query.=' from `'.$this->tableName.'` ';
				$query.=' '.$this->rules['join'].' ';
				$query.=' '.$this->rules['where'].' ';
				$query.=' '.$this->rules['groupBy'].' ';
				$query.=' '.$this->rules['having'].' ';
				$query.=' '.$this->rules['orderBy'].' ';
			}			
			$num=$this->db->getByQuery($query);
			$this->page['n']=$num['num'];
		}
		
		if($this->clear===true){
			$this->clear();
		}else{
			$this->clear=true;
		}
		return $data;
		
	}
	public function delete($id=NULL){
		if($id){
			$this->where(array('id'=>$id));
		}
	
		$query=' delete from `'.$this->tableName.'` '.$this->rules['where'];
		$data=$this->db->query($query);
		
		if($id){
			foreach($this->relations as $reltb){
				$obj= new self($reltb);
				$obj->where(array($this->tableName.'_id'=>$id))->delete();
			}
		}
		
		if($this->clear===true){
			$this->clear();
		}else{
			$this->clear=true;
		}
	}	
	public function update($data,$id=NULL){
		
		if(count($data)){
			$this->serpRelData($data,$relData);
		
			if($id)$this->where(array('id'=>$id));
			foreach($data as $col=>$value){
				$update[]="`".$col."`='".$this->db->mysql_in($value)."'";
			}
			$query=' update `'.$this->tableName.'` set '.implode(",",$update)." ";
			$query.=$this->rules['where'];
			$this->db->query($query);
			
			if($id){
				$relf=$this->getRelationFields($id,$relData);
				
				if($relf){
					foreach($this->relations as $reltb){
						$obj= new self($reltb);
						$obj->where(array($this->tableName.'_id'=>$id))->delete();
					}
					foreach($relf as $rel=>$value){
						$obj= new self($this->relations[$rel]);
						$obj->inserts($relf[$rel]['columns'],$relf[$rel]['values']);
					}
				}
			}
		}
	
	
		if($this->clear===true){
			$this->clear();
		}else{
			$this->clear=true;
		}
	}
	public function insert($data,$dubkey=false){
	
		if(count($data)){
		
			$this->serpRelData($data,$relData);
			foreach($data as $col=>$value){
				$value=$this->db->mysql_in($value);
				$cols[]="`".$col."`";
				$values[]="'".$value."'";
				if($dubkey)$update[]="`".$col."`='".$value."'";
			}
			$query="insert into `".$this->tableName."`(".implode(",",$cols).") values(".implode(",",$values).")";
			if($dubkey)$query.="ON DUPLICATE KEY UPDATE ".implode(",",$update)."";
			$this->db->query($query);
			$insert_id=$this->db->getMysqli()->insert_id;
			
			
			if($insert_id){
				
				foreach($relf=$this->getRelationFields($insert_id,$relData) as $rel=>$value){
					$obj= new self($this->relations[$rel]);
					$obj->inserts($relf[$rel]['columns'],$relf[$rel]['values']);
				}
			}
		}
		
		
		
		if($this->clear===true){
			$this->clear();
		}else{
			$this->clear=true;
		}
		
		return $insert_id;
	}
	
	public function inserts($columns,$values){
	
		$valuesArr=array();
		foreach($values as $row){
			$temp=array();
			foreach($columns as $col){
				$temp[]="'".$this->db->mysql_in($row[$col])."'";
			}
			$valuesArr[]="(".implode(",",$temp).")";
		}
		
		$valuesStr=implode(",",$valuesArr);
		
		$query="insert into `".$this->tableName."`(".$this->tbCol(implode(',',$columns)).") values ".$valuesStr;
		
		$this->db->query($query);
		
		if($this->clear===true){
			$this->clear();
		}else{
			$this->clear=true;
		}
	}
	
	public function select($str){
		if($this->rules['select'])$this->rules['select'].=', ';
		$this->rules['select'].=$this->tbCol($str);
		return $this;
	}
	
	public function where($data,$params=array(),$or=false){
		if($or===false){
			$or=" and " ;
		}else{
			$or=" or ";
		}		
		if($this->rules['where'])$this->rules['where'].=$or;
		if(!$this->rules['where'])$this->rules['where'].=' where ';
		if(is_array($data)){
			foreach($data as $col=>$row){
				$col=explode(" ",$col);
				$col[0]=$this->tbCol($col[0]);
				if(!$col[1]){
					$col[1]="=";
				}
				if(is_array($row)){
					if($col[1]=='!='){
						$col[1]='not in';
					}else{
						$col[1]='in';
					}					
					$arrow=array();
					foreach($row as $rowin){
						$arrow[]="'".$this->db->mysql_in($rowin)."'";
					}
					$row="(".implode(", ",$arrow).")";
				}else{
					$row="'".$this->db->mysql_in($row)."'";
				}
				$arr[]=$col[0]." ".$col[1]." ".$row."";			
			}
			
			$this->rules['where'].=implode($or,$arr);
		}else{
			$this->rules['where'].=$this->db->screening($data,$params);
		}
		return $this;
	}
	
	
	public function orderBy($data){
		$arr=array();
		foreach($data as $key=>$value){
			$arr[]=$this->TbCol($key)." ".$value;
		}
		$this->rules['orderBy']=" order by ". implode(", ",$arr);
		return $this;
	}
	
	
	public function limit($offset,$num=NULL){
		$this->rules['limit']=" limit ".(int)$offset;
		if($num)$this->rules['limit'].=",".(int)$num;
		return $this;
	}
	
	public function groupBy($data){
		$this->rules['groupBy']=" group by ". $this->TbCol($data);
		return $this;
	}
	
	public function having($data,$params=array(),$or=false){
		if($or===false){
			$or=" and " ;
		}else{
			$or=" or ";
		}		
		if($this->rules['having'])$this->rules['having'].=$or;
		if(!$this->rules['having'])$this->rules['having'].=' having ';
		if(is_array($data)){
			foreach($data as $col=>$row){
				$col=explode(" ",$col);
				$col[0]=$this->tbCol($col[0]);
				if(!$col[1]){
					$col[1]="=";
				}
				if(is_array($row)){
					if($col[1]=='!='){
						$col[1]='not in';
					}else{
						$col[1]='in';
					}					
					$arrow=array();
					foreach($row as $rowin){
						$arrow[]="'".$this->db->mysql_in($rowin)."'";
					}
					$row="(".implode(", ",$arrow).")";
				}else{
					$row="'".$this->db->mysql_in($row)."'";
				}
				$arr[]=$col[0]." ".$col[1]." ".$row."";			
			}
			
			$this->rules['having'].=implode($or,$arr);
		}else{
			$this->rules['having'].=$this->db->screening($data,$params);
		}
		return $this;
	}
	
	public function join($table,$cols,$flag=0){
		if($flag===0)$this->rules['join'].=" left join `$table` on ".$this->TbCol($cols);
		if($flag===1)$this->rules['join'].=" right join `$table` on ".$this->TbCol($cols);
		if($flag===2)$this->rules['join'].=" join `$table` on ".$this->TbCol($cols);
		return $this;
	}
	
	public function page($numPage,$countPerPage,&$n=false){
		if($numPage==0)$numPage=1;
		$this->page['numPage']=$numPage;
		$this->page['countPerPage']=$countPerPage;
		$this->page['n']=&$n;
		return $this;
	}
	
	
	public function getAllByRel($data,$groupById=true){
		foreach($data as $rel=>$id){
			if($relTable=$this->relations[$rel]){
				if($id!=='*')$this->join($relTable,$relTable.".".$this->tableName."_id = ".$this->tableName.".id")->where(array($relTable.".".$rel."_id"=>$id));
				if($id==='*')$this->join($relTable,$relTable.".".$this->tableName."_id = ".$this->tableName.".id")->where(array($relTable.".".$rel."_id >"=>'0'));
			}
		}
		if($groupById===true)$this->groupBy('id');
		return $this->getAll();
	}
	
	public function with($data){
		$this->with=$data;
		return $this;
	}
	
	public function doWith($data){
			$ids=array();
			foreach($data as $value){
				$ids[]=$value['id'];
			}
			if(count($ids)){
				foreach($this->with as $rel=>$cols){
					$obj= new self($rel);
					if($cols=="*")$cols=$rel.".*";
					$rels=$obj->select($this->relations[$rel].".".$this->tableName."_id, ".$cols)->getAllByRel(array($this->tableName=>$ids),false);
					$temp=array();
					foreach($rels as $value){
						$temp[array_shift($value)][]=$value;
					}
					foreach($data as $key =>$value){
						if($temp[$value['id']]){
							$value[$rel]=$temp[$value['id']];
						}else{
							$value[$rel]=array();
						}
						$data[$key]=$value;
					}
				}
			}
		return $data;	
	}
	
	public function perelink($id,$count,$revers=false){
		$rules=$this->rules;
		$with=$this->with;
		if(!$revers)$data=$this->where(array('id <'=>$id))->orderBy(array('id'=>'desc'))->getAll($count);
		if($revers)$data=$this->where(array('id >'=>$id))->orderBy(array('id'=>'desc'))->getAll($count);
		if(($c=count($data))<$count){
			$this->rules=$rules;
			$this->with=$with;
			if(!$revers)$data=array_merge($data,$this->where(array('id >'=>$id))->orderBy(array('id'=>'desc'))->getAll($count-$c));
			if($revers)$data=array_merge($data,$this->where(array('id <'=>$id))->orderBy(array('id'=>'desc'))->getAll($count-$c));
		}
		return $data;
	}
	
	
	public function perelinkByRel($id,$rels,$count,$perelink=true){
		//$rels as $rel=>$ids  rels- название связи, ids - массив id связи или все ids при *
		$rules=$this->rules;
		$with=$this->with;
		$noids=array();
		$data=array();
		
		foreach($rels as $rel=>$ids){
			$obj= new self($rel);
			$relIds=array();
			
			if($ids=="*"){
				$temp=$obj->select('id')->getAllByRel(array($this->tableName=>$id));
				foreach($temp as $row){
					$relIds[]=$row['id'];
				}
			}elseif(is_array($ids))$relIds=$ids;
			if(count($relIds)){
				if(count($noids))$this->where(array('id !='=>$noids));
				$data=array_merge($data,$this->where(array('id <'=>$id))->orderBy(array('id'=>'desc'))->limit($count)->getAllByRel(array($rel=>$relIds)));
				
				if(($c=count($data))<$count){
					$this->rules=$rules;
					$this->with=$with;
					if(count($noids))$this->where(array('id !='=>$noids));
					$data=array_merge($data,$this->where(array('id >'=>$id))->orderBy(array('id'=>'desc'))->limit($count-$c)->getAllByRel(array($rel=>$relIds)));
				}
			}

			if(count($data)==$count)return $data;
			
			foreach($data as $val){
				$noids[]=$val['id'];
			}
			
			
		}
		
		$this->rules=$rules;
		$this->with=$with;
		if(count($noids))$this->where(array('id !='=>$noids));
		
		if($perelink)$data=array_merge($data,$this->perelink($id,$count-count($data)));
		
		return $data;
	}
	
	public function getRels($id,$rels){
		$data=array();
		foreach($rels as $rel=>$cols ){
			$obj= new self($rel);
			$data[$rel]=$obj->select($cols)->getAllByRel(array($this->tableName=>$id));
		}
		return $data;
	}
	
	public function search($field,$search){
		$search=trim($search);
		$search=preg_replace('/[^a-zA-Zа-яА-Я0-9]+/iu','%',$search);
		$search="%".$search."%";
		$this->where(array($field.' LIKE'=>$search));
		return $this;
	}
	
	private function tbCol($str){
		$str=preg_replace("/([0-9a-z\_]+)/","`$1`",$str);
		return $str;
	}
	
	private function getRelationFields($id,$data){
				
		$result=array();
		if(is_array($data)){
			$rels=array_keys($data);
			foreach($rels as $rel){
				if($data[$rel][$rel."_id"]){
					$columns=array_keys($data[$rel]);
					$columns[]=$this->tableName."_id";
					$result[$rel]['columns']=$columns;
					foreach($data[$rel][$rel."_id"] as $key=>$val){
						if(!$result[$rel]['values'][$val]){
							foreach($columns as $col){
								if($col!=$this->tableName."_id"){
									$result[$rel]['values'][$val][$col]=$data[$rel][$col][$key];
								}else{
									$result[$rel]['values'][$val][$col]=$id;
								}								
								
							}
						}
					}
				}
			}
		}
		return $result;		
	}
	
	private function serpRelData(&$data,&$relData){
		$relData=array();
		
		$keys=array_keys($data);
		$rels=array_keys($this->relations);
		foreach($rels as $rel){
			foreach($keys as $key){
				if(preg_match("/^".$rel."_(.+)$/i",$key,$match)){
					$relData[$rel][$match[1]]=$data[$key];
					unset($data[$key]);
				}
				if(preg_match("/^".$rel."$/i",$key,$match)){
					$relData[$rel][$rel."_id"]=$data[$key];
					unset($data[$key]);
				}
			}
		}
	}	
}
?>