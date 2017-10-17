<?php
	require_once(LIB_PATH."database_object.php");
	class Input {	
		
		public static function get($item){
			if(!empty($_POST[$item])){
				return trim($_POST[$item]);
			}elseif(!empty($_GET[$item])){
				return trim($_GET[$item]);
			}
			return "";
		}
		
		public static function sanitize_integer($item){
			$item = trim($item);
			$item = filter_var($item, FILTER_SANITIZE_NUMBER_INT);
			return $item;	
		}
		
		public static function sanitize_string($item){
			$item = trim($item);
			echo $item;
			$item = filter_input($item, FILTER_SANITIZE_STRING);
			return $item;	
		}
		
		public static function sanitize_email($item){
			$item = trim($item);
			$item = filter_input($item, FILTER_SANITIZE_EMAIL);
			return $item;	
		}
		
		public static function sanitize_url($item){
			$item = trim($item);
			$item = filter_input($item, FILTER_SANITIZE_URL);
			return $item;	
		}
		
		public static function sanitize_float($item){
			$item = trim($item);
			$item = filter_input($item, FILTER_SANITIZE_NUMBER_FLOAT);
			return $item;	
		}
		
		public static function sanitize_magic_quotes($item){
			$item = trim($item);
			$item = filter_input($item, FILTER_SANITIZE_MAGIC_QUOTES);
			return $item;	
		}
		
		public static function exists($type='post'){
			switch($type){
				case 'post':
					return (!empty($_POST)) ? true: false;
				break;
				case 'get':
					return (!empty($_GET)) ? true: false;
				break;
				default:
					return false;
				break; 	
			}
		}
		
	}

?>
