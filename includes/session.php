<?php
	require_once(SITE_ROOT.DS."initialize.php");
	class Session{
		private $logged_in = false;
		public $user_id;
		public $username;
		public $message;
		public $session_no;
		public $id;
		
		//**************************************************************************************	
		
		function __construct(){
			session_start();
			ob_start();
			$this->check_login();
			$this->check_message();
		}
		public function is_logged_in(){
			return $this->logged_in;	
		}
		function check_login(){
			if(isset($_SESSION['st_user_id'])){
				$this->user_id = $_SESSION['st_user_id'];
				$this->username = $_SESSION['username'];
				$this->session_no = Session::session_no($this->user_id);
				$this->logged_in = true;
			}else{
				unset($this->user_id);
				$this->logged_in = false;	
			}
		}
		
		public static function session_no($user_id){
			if(isset($_SESSION['username'])){
				$session =$_SESSION['username'].$user_id.SALT;
				return sha1($session);
			}
			return false;
		}
		
		//**************************************************************************************	
		
		public function login($user){
			$_SESSION['st_user_id'] = $user->id;
			$_SESSION['username'] = $user->username;
			$this->check_login();
		}
		public function logout(){
			unset($_SESSION['st_user_id']);
			unset($this->user_id);	
			$this->logged_in = false;
		}
		
		//**************************************************************************************	
		
		private function check_message(){
			if(isset($_SESSION['message'])){
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
			}else{
				$this->message = "";	
			}
		}
		public function message($msg=""){
			if(!empty($msg)){
				$_SESSION['message'] = $msg;
			}else{
				return $this->message;	
			}
		}
		
		//**************************************************************************************	
		
		public function is_admin(){
			if(isset($this->session_no)){
				if($this->session_no == self::session_no(1)){
					return true;
				}
			}
			return false;
		}
		public static function user_permission($id){
			global $session;
			if($session->session_no == self::session_no($id) || $session->session_no == self::session_no(1)){
				return true;
			}
			return false;	
		}
		
		public static function confirm_pass($password_1, $password_2){
		if($password_1 == $password_2){
			return true;
		}
		return false;	
	}	
	}
	
	//**************************************************************************************

	$session = new Session();
	$message = $session->message();
?>
