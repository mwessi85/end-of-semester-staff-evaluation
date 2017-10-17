<?php
	require_once(SITE_ROOT.DS."initialize.php");
	Abstract class DatabaseObject{
		protected static $_table_name;
		protected static $db_fields = array();
		
		//**************************************************************************************	
		
		protected static function table_fields(){
			global $database;
			$sql= "SHOW FIELDS FROM ".static::$_table_name;
			$query = $database->query($sql);
			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				self::$db_fields[] = $row["Field"]; 
			}
		}
		
		protected function attributes(){
			$attributes = array();
			static::table_fields();
			foreach(static::$db_fields as $field){
				if(property_exists($this, $field)){
					$attributes[$field] = $this->$field;	
				}	
			}	
			return $attributes;
		}
		
		private function has_attribute($attribute){
			 $object_vars = get_object_vars($this);
			 return array_key_exists($attribute, $object_vars);	
		}
		
		private static function instantiate($record){
			$class_name = get_called_class();
			$object = new $class_name;
			foreach($record as $attribute=>$value){
				if($object->has_attribute($attribute)){
					$object->$attribute = $value;
				}
			}
			return $object;
		}
		
		//**************************************************************************************		
		
		public static function find_by_sql($sql=""){
			global $database;			
			$query = $database->query($sql);
			$object_array = array();
			while($row = $query->fetch(PDO::FETCH_ASSOC)){
				$object_array[] = static::instantiate($row);
			}
			return $object_array;
		}
		
		public static function query_object($sql=""){
			global $database;			
			$query = $database->query($sql);
			return $query;
		}
		
		public static function find_all($condition=""){
			global $database;
			$sql = "SELECT * FROM ".static::$_table_name.$condition;
			$object_array = static::find_by_sql($sql);
			return $object_array;
		}
		
		//**************************************************************************************	
		
		//returns an object
		public function item_exists($sql){
			$found_object = static::find_by_sql($sql);
			$found_item = array_shift($found_object);
			return $found_item;
		}
		
		public static function count_all($condition=""){
			global $database;
			$sql = "SELECT COUNT(*) FROM ".static::$_table_name.$condition;
			$query = $database->query($sql);
			return  $query->fetchColumn();
		}
		
		public static function find_all_by_user_id($id=0){
			global $database;
			$sql = "SELECT * FROM ".static::$_table_name." WHERE user_id = ".$id." ORDER by id DESC";
			$object_array = static::find_by_sql($sql);
			return !empty($object_array) ? $object_array : false;	
		}
		
		public static function find_by_user_id($id=0){
			global $database;
			$sql = "SELECT * FROM ".static::$_table_name." WHERE user_id = ".$id." LIMIT 1";
			$object_array = static::find_by_sql($sql);
			return !empty($object_array) ? array_shift($object_array) : false;	
		}
		
		public static function find_by_id($id=0){
			global $database;
			
			$sql ="SELECT * FROM ".static::$_table_name." WHERE id = ".$id." LIMIT 1";
			$object_array = static::find_by_sql($sql);
			return !empty($object_array) ? array_shift($object_array) : false;	
		}
			
		public function create(){
			global $database;
			$attributes = $this->attributes();
			unset($attributes['id']);
			$attribute_pairs = array();
			$sql = "SELECT * FROM ".static::$_table_name." WHERE ";
			$i = 0;
			//echo "<p>".sizeof($attributes)."</p>";
			foreach ($attributes as $key => $value){
				$sql .= $key."='".$value."'";
				if($i < sizeof($attributes)-1){
					$sql .= " AND ";
					$i++;
				}
			}
			//echo "<p>".$i."</p>";
			//echo $sql;
			///exit;
			$result = $database->query($sql);
			$results = $result->fetchColumn();
			//echo $results;
			//exit;
			if(!empty($results)){
				return "duplicate";	
			}
			
			$attributes = $this->attributes();
			foreach ($attributes as $key => $value){
				$attribute_pairs[] = $key." = :".$key;
				$key_values[":".$key] = $value;
			}
			$sql = "INSERT INTO ".static::$_table_name."(";
			$sql .= join(", ", array_keys($attributes));
			$sql .= ") VALUES(";
			$sql .=join(", ", array_keys($key_values));
			$sql .= ")";
			$query = $database->query_prepare($sql);
			//echo "<pre>".print_r($query, true)."</pre>";
			//exit;
			$key_values[':id']="";
			$query->execute($key_values);
			$errorInfo = $query->errorInfo();
			if (isset($errorInfo[2])) {
				$error = $errorInfo[2];
				return false;	
			}else{
				return $database->lastInsertId();	
			}
		}
		
		public function update(){
			global $database;
			$attributes = $this->attributes();
			unset($attributes['id']);
			$attribute_pairs = array();
			foreach ($attributes as $key => $value){
				$attribute_pairs[] = $key." = :".$key;
				$key_values[":".$key] = $value;
			}	
			$sql = "UPDATE ".static::$_table_name." SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE id = ".$this->id;		
			$query = $database->query_prepare($sql);
			//echo "<pre>".print_r($query, true)."</pre>";
			//exit;
			$query->execute($key_values);
			return($query->rowCount() == 1) ? true : false; 	
		}
		
		public function save(){
			return !empty($this->id) ? $this->update() : $this->create();	
		}
		
		public function delete(){
			global $database;
			$sql = "DELETE FROM ".static::$_table_name." ";
			$sql .= "WHERE id = ".$this->id;
			$sql .= " LIMIT 1";	
			$query = $database->query($sql);
			return($query->rowCount() == 1) ? true : false;
		}
		
		public function delete_all_where($field, $value){
			global $database;
			$sql = "DELETE FROM ".static::$_table_name." ";
			$sql .= "WHERE ".$field." = ".$value;
			//$sql .= " LIMIT 1";	
			$query = $database->query($sql);
			return($query->rowCount() == 1) ? true : false;
		}
		public static function return_user_id($id){
			global $database;
			global $session;
			$sql = "SELECT * FROM ".static::$_table_name." WHERE user_id = ".$session->user_id;
			$object_array = static::find_by_sql($sql);
			$available_items = array();
			foreach($object_array as $item){	
				$available_items[] = $item->id;	
			}
			if (in_array($id, $available_items, true) || $session->session_no == Session::session_no(1)) {
				return true;	
			}else{
				$session->message("error: You are not allowed to perform this action");
				redirect_to("index.php?p=main");
				return false;	
			}
		}
	}
?>