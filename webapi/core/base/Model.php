<?php
namespace Core;
class Model
{
	public function __construct(Array $properties=array()){
		$this->db = new DB();
		$this->db->table($this->table());

		foreach($properties as $key => $value){
      $this->{$key} = $value;
			$this->_def[$key]=$value;
    }
	}

	/* destroy database */
	public function destroy(){
		$this->db->drop();
	}


	/* delete from id */
	public function delete($id=0){
		$this->db->delete();
		if(is_array($id)){
			$this->db->where($id);
		}else if(is_numeric($id)){
			$this->db->where(array('id' => $id));
		}
		$this->db->run();
	}

	/* save/insert from this keys */
	public function save(){
		$this->db->insert($this->_def);
		$this->db->run();

		$this->find($this->db->getLastInsertedId());
	}

	/* find from id or this->keys */
	public function find($id){
		$this->db->select();
		$this->db->where(array('id' => $id));


		try{
			$this->db->query();
			foreach ($this->db->output->fetch() as $key => $val) {
				$this->{$key} = $val;
				$this->_def[$key] = $val;
			}
		}catch(Error $e){
			Error::show($e->getMessage());
		}
	}

	/* get from array to set keys */
	public function get($array){
		$this->db->select();
		if(is_array($array)){
			$this->db->where($array);
		}

		try{
			$this->db->query();
			foreach ($this->db->output->fetch() as $key => $val) {
				$this->{$key} = $val;
				$this->_def[$key] = $val;
			}
			$result = @$this->db->output ? $this->db->output->fetch() : false;
			return $result;
		}catch(Error $e){
			Error::show($e->getMessage());
		}
	}

	public function all($array){
		$this->db->select();
		if(is_array($array)){
			$this->db->where($array);
		}
		$this->db->query();
		$result = @$this->db->output ? $this->db->output->fetchAll() : false;
		return $result;
	}


	public function special($where=array(),$orderBy=array(),$limit=array(),$groupBy=array(),$extra=null){
		$this->db->select();
		if(is_array($where)) $this->db->where($where);
		if(isset($groupBy[0]) && is_bool($groupBy[1])) $this->db->groupBy($groupBy[0],$groupBy[1]);
		if(isset($orderBy[0]) && is_bool($orderBy[1])) $this->db->orderBy($orderBy[0],$orderBy[1]);
		if(isset($limit[0]) && is_numeric($limit[0]) && is_numeric($limit[1])) $this->db->limit($limit[0],$limit[1]);
		if(!is_null($extra)) $this->db->extra($exta);
		$this->db->query();

		$result = @$this->db->output ? $this->db->output->fetchAll() : false;
		return $result;
	}

	public function count($arr=null){
		$this->db->count();
		if(is_array($arr)) $this->db->where($arr);
		$this->db->query();
		$result = @$this->db->output ? $this->db->output->fetch() : false;
		$result = $result ? $result[0] : false;
		return $result;
	}


	/* update array2 from array1 */
	public function update($id=0){
		if($this->_def){
			$this->db->update($this->_def);

			if(is_int($id)) $this->db->where(array("id"=>$id));
			else if(is_array($id)) $this->db->where($id);

			return $this->db->run();
		}
	}


	public function getPrimaryKey(){
		$this->db->keys();
		$this->db->where(array('Key_name' => 'PRIMARY'));
		$this->db->query();
		$result = @$this->db->output ? $this->db->output->fetch() : false;
		$result = $result ? $result['Column_name'] : false;
		return $result;
	}

	public function searchQuery($query,$config){
		foreach ($this->search() as $key) {
			$sq[$key] = $query;
		}
		$this->db->search($sq,$config);
		$this->db->query();
		if($this->db->output){
			return $this->db->output->fetchAll();
		}else{
			return false;
		}
	}

	/*
	public function moveData($model2){
		return false;
	}
	*/
}
?>
