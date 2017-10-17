<?php
	require_once(LIB_PATH."database_object.php");
	class User extends DatabaseObject{
		protected static $_table_name = "users";
		public $id; 
		public $username;
		public $password;
		public $first_name;
		public $last_name;
		public $other_name;
		public $email;
		public $user_type;
		public $status;
		public $errors = array(); 
		
		//**************************************************************************************
		
		public static function authenticate($username="", $password=""){
			global $database;
			$sql = "SELECT * 
			FROM ".self::$_table_name." 
			WHERE username = '".$username."' AND password = '".sha1(trim($password))."' LIMIT 1";
			$object_array = self::find_by_sql($sql);
			return !empty($object_array) ? array_shift($object_array) : false;
		}
		
		//**************************************************************************************
		
		public function change_pass($current_password="", $password_1="", $password_2=""){
			global $database;
			global $session;
			if(Session::confirm_pass($password_1, $password_2)){
				$sql = "SELECT * FROM ".self::$_table_name." WHERE id = '".$this->id."' AND password = '".sha1(trim($current_password))."' LIMIT 1";
				$object_array = self::find_by_sql($sql);
				if(!empty($object_array)){
					$sql = "UPDATE ".static::$_table_name." SET password = '".sha1(trim($password_1))."' WHERE id = ".$this->id;
					$query = $database->query($sql);
					if($query){
							return true;
					}else{
						$session->message("error: The password update failed");
						if($this->user_type == "student"){
							redirect_to("index.php?p=student&user_id=".urlencode(base64_encode($this->id)));
						}
						redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($this->id)));	
						return false;	
					}
				} else{
					$session->message("error: The current password given is wrong");
					if($this->user_type == "student"){
						redirect_to("index.php?p=student&user_id=".urlencode(base64_encode($this->id)));
					}
					redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($this->id)));	
					return false;
				}
				return !empty($object_array) ? array_shift($object_array) : false;
			}else{
				$session->message("error: New password and its confirmation do not match");
				//redirect_to("index.php?p=password&c=password&id=".urlencode(base64_encode($this->id)));
				if($this->user_type == "student"){
						redirect_to("index.php?p=student&user_id=".urlencode(base64_encode($this->id)));
					}
				redirect_to("index.php?p=staff&user_id=".urlencode(base64_encode($this->id)));
				return false;	
			}
		}
		
		
		/*public function change_pass($current_password="", $password_1="", $password_2=""){
			global $database;
			global $session;
			if(Session::confirm_pass($password_1, $password_2)){
				$sql = "SELECT * FROM ".self::$_table_name." WHERE id = '".$this->id."' AND password = '".sha1(trim($current_password))."' LIMIT 1";
				$object_array = self::find_by_sql($sql);
				if(!empty($object_array)){
					$sql = "UPDATE ".static::$_table_name." SET password = '".sha1(trim($password_1))."' WHERE id = ".$this->id;
					$query = $database->query($sql);
					if($query){
							return true;
					}else{
						$session->message("error: The password update failed");
						redirect_to("index.php?p=password&c=password&id=".urlencode(base64_encode($this->id)));
						return false;	
					}
				} else{
					$session->message("error: The current password given is wrong");
					redirect_to("index.php?p=password&c=password&id=".urlencode(base64_encode($this->id)));
					return false;
				}
				return !empty($object_array) ? array_shift($object_array) : false;
			}else{
				$session->message("error: New password and its confirmation do not match");
				redirect_to("index.php?p=password&c=password&id=".urlencode(base64_encode($this->id)));
				return false;	
			}
		}*/
		
		//**************************************************************************************
		
		public function full_name(){
			if(isset($this->first_name) && isset($this->last_name)){
				if($this->other_name){
					$other_name = $this->other_name;	
				}else{
					$other_name = "";	
				}
				return ucfirst($this->last_name)." ".ucfirst($this->first_name)." ".ucfirst($other_name);
			}else{
				return "";	
			}	
		}
		
		public function full_name_lower(){
			if(isset($this->first_name) && isset($this->last_name)){
				if($this->other_name){
					$other_name = $this->other_name;	
				}else{
					$other_name = "";	
				}
				return strtolower($this->last_name)." ".strtolower($this->first_name)." ".strtolower($other_name);
			}else{
				return "";	
			}	
		}
		
		public function full_name_upper_firstname(){
			if(isset($this->first_name) && isset($this->last_name)){
				if($this->other_name){
					$other_name = $this->other_name;	
				}else{
					$other_name = "";	
				}
				return strtoupper($this->first_name)." ".ucfirst($this->last_name)." ".ucfirst($other_name);
			}else{
				return "";	
			}	
		}
		
		public function full_name_title(){
			if(isset($this->first_name) && isset($this->last_name)){
				if($this->other_name){
					$other_name = $this->other_name;	
				}else{
					$other_name = "";	
				}
				$staff_object = Staff::find_by_user_id($this->id);
				//echo "<pre>".print_r($staff_object, true)."</pre>";
				if($staff_object){
					$title_object = Title::find_by_id($staff_object->title);
					if(!empty($title_object->title)){
						$title = $title_object->title.". ";
					}else{
						$title="";	
					}
				}else{
					$title = "";	
				}
				return $title.ucfirst($this->last_name)." ".ucfirst($this->first_name)." ".ucfirst($other_name);
			}else{
				return "";	
			}	
		}
		
		//**************************************************************************************
		
		public function verify_umu_email_staff($email, $user_id){
			global $session;
			global $database;
			$domain= explode('@', $email);
			if($domain[1] == "umu.ac.ug"){
				$sql = "SELECT * FROM ".static::$_table_name." WHERE email = '".$email."' AND status = 1 AND id !=".$user_id;
				$found_user = static::item_exists($sql);
				if(!empty($found_user)){
					$session->message("error: Email ".$email." already exists for ".$found_user->full_name());
					redirect_to("index.php?p=users");
					//return false;
				}
				$this->email = $email;
				return true;
			}else{
				$session->message("error: Wrong email address, use the email assigned by the University ending in @umu.ac.ug");
				redirect_to("index.php?p=users");
				//return false;	
			}	
		}	
		public function verify_umu_email_student($email, $user_id){
			global $session;
			global $database;
			$domain= explode('@', $email);
			if($domain[1] == "stud.umu.ac.ug"){
				$sql = "SELECT * FROM ".static::$_table_name." WHERE email = '".$email."' AND status = 1 AND id !=".$user_id;
				$found_user = static::item_exists($sql);
				if(!empty($found_user)){
					$session->message("error: Email ".$email." already exists for ".$found_user->full_name());
					redirect_to("index.php?c=users&p=users&add=true");
					//return false;
				}
				$this->email = $email;
				return true;
			}else{
				$session->message("error: Wrong email address, use the email assigned by the University ending in '@stud.umu.ac.ug' If you dont remember your student email address, simply put your 'firstname.surname@stud.umu.ac.ug'");
				redirect_to("index.php?c=users&p=users&add=true");
				//return false;	
			}	
		}			
	}

?>
