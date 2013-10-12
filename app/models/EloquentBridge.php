<?php

class EloquentBridge extends Eloquent
{
	public $timestamps = false;

	public function getTable(){
		return $this->table;
	}

	public function getAttributes(){
		return $this->attributes;
	}

	public function findAll()
	{
		$model_atts = $this->getAttributes();
		$table = explode('_',$this->getTable());
		array_walk($table,function(&$item,$index){ $item = ucfirst($item); });
		$table = implode('',$table);
		if($table == 'Users'){
			$result = new User();
		}else{
			$result = new $table();
		}
		foreach($model_atts as $traitname => $trait){
			$result = $result->where($traitname,$trait);
		}
		$result = $result->get();
		if(count($result) == 0){
			$result = array();
		}else if(count($result) == 1){
			$result = $result[0];
		}else{}
		return $result;
	}
}

