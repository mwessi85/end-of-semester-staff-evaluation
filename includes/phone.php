<?php
	require_once(LIB_PATH."database_object.php");
	class Phone extends DatabaseObject{
		protected static $_table_name = "phones";
		public $id; 
		public $user_id; 
		public $number;
		public $country_code;
		public $errors = array(); 
		public function phone_number(){
			if(isset($this->country_code) && isset($this->number)){
				$number = trim(substr($this->number, 0));
				return "+".$this->country_code."-".$number;
			}else{
				return "";	
			}	
		}
		public function verify_phone($user_id=0){
			//gives error when updating with the same number as one that already exists for that user;
			global $session;
			$sql = "SELECT * FROM ".static::$_table_name." WHERE number = '".$this->number."'";
			$found_phone = static::item_exists($sql);
			//echo "<pre>".print_r($found_phone, true)."</pre>";
			
			if(!empty($found_phone) ){
				if($found_phone->user_id != $user_id){
					$user = User::find_by_id($found_phone->user_id);
					$session->message("error: The Phone number ".$this->number." already exists for ".$user->full_name());
					return false;
				}
				return $this->number;
			}
			return $this->number;	
		}
	}
?>
