<?php
	require_once(SITE_ROOT.DS."initialize.php");
	//require_once("session.php");
	class Photograph extends DatabaseObject{
		protected static $_table_name = "photographs";
		public $id; 
		public $filename;
		public $type;
		public $size;
		public $caption;
		public $user_id;
		private $temp_path;
		protected $upload_dir="uploads";
		protected $upload_errors = array(
		UPLOAD_ERR_OK => "No errors",
		UPLOAD_ERR_INI_SIZE => "Larger than php upload_max_size",
		UPLOAD_ERR_FORM_SIZE => "Larger that MAX_FILE_SIZE",
		UPLOAD_ERR_PARTIAL => "Partial upload",
		UPLOAD_ERR_NO_FILE => "No file",
		UPLOAD_ERR_NO_TMP_DIR => "No temporary directory",
		UPLOAD_ERR_CANT_WRITE => "Can't write to disk",
		UPLOAD_ERR_EXTENSION  => "File upload stopped by extension"
		);
		public $errors = array(); 
		public function attach_file($file){
			global $session;
			if(!$file || empty($file) || !is_array($file)){
				$session->message("No file was uploaded");
				return false;
			}else if($file["error"] != 0){
				$session->message($this->upload_errors[$file["error"]]);
				return false;
			}else{ 
				//echo "Mike<br>";
				//echo $file["tmp_name"]."<br>";
				//echo $file["type"]."<br>";
				//echo $file["size"]."<br>";
				$this->filename = basename($file["name"]);
				$this->type = $file["type"];
				$this->size = $file["size"]; 
				$this->temp_path = $file["tmp_name"];
				return true;
			}
		}
		public function save(){
			global $session;
			$user = User::find_by_id($this->user_id);
			
			$file_name = $user->last_name."_".$user->first_name."_".$this->user_id;
			$this->filename = $file_name;
			$this->caption = $user->full_name();
			//echo "<p>".$this->user_id."</p>";
			echo "<p>Filename: ".$this->filename."</p>";
			echo "<p>Filename: ".$this->temp_path."</p>";
			
			if(empty($this->filename) || empty($this->temp_path)){
				$session->message("error: No image was selected, Browse for the image to upload");
				redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($this->user_id)));
				return false;
			}
			
			$target_path = SITE_ROOT.DS."public".DS."uploads".DS.$this->filename.".jpg";
			
			if(isset($this->id) && $this->filename != "change_photo"){
				//chmod($target_path, 0644);
				
				chmod($target_path, 0777);
				unlink($target_path);
			}
			
			
			//echo $this->temp_path;
			////echo "<pre>".print_r($user, true)."</pre>";
			//exit;
			//echo $target_path ;
			if(move_uploaded_file($this->temp_path, $target_path)){
				
				if($this->id){
					//echo $target_path;
					//exit;
					$this->update();
				}else{
					$this->create();
					unset($this->temp_path);
					return true;	
				}						
			}else{
				//echo "<p>index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($user_id))."</p>";
			//exit;
				$session->message("The file upload failed, possibly due to incorrect permissions on the upload folder");
				redirect_to("index.php?c=staff&p=staff&user_id=".urlencode(base64_encode($this->user_id)));
				return false;	
			}	
		}
		public function destroy(){
			if($this->delete()){
				$target_path = SITE_ROOT.DS."public".DS."uploads".DS.$this->filename;
				chmod($target_path, 0777);
				return unlink($target_path) ? true : false;
			}else{
				return false;	
			}	
		}
		public function image_path(){
			return $this->upload_dir."/".$this->filename.".jpg";	
		}
		public function size_as_text(){
			if($this->size < 1024){
				return $this->size." bytes";
			}elseif($this->size < 1048576){
				$size_kb = round($this->size/1024)." KB";
				return $size_kb;
				}else{
					$size_MB = round($this->size/1048576, 1);
					return $size_MB;	
				}
		}
		public function comments(){
			return Comment::find_comments_on($this->id);
		}
		public function update_caption($caption){
			global $database;
			$sql = "UPDATE ".self::$_table_name." SET caption = '".$caption;
			$sql .= "' WHERE id = ".$this->id;
			//echo $sql;
			//exit;
			$result = $database->query($sql);
			return($database->affected_rows($result) == 1) ? true : false; 	
		}
		public function update(){
			global $database;
			$attributes = $this->attributes();
			$attribute_pairs = array();
			foreach ($attributes as $key => $value){
				$attribute_pairs[] = $key." = '".$value."'";
			}
			$sql = "UPDATE ".static::$_table_name." SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE id = ".$this->id;
			//echo $sql;
			//exit;
			$query = $database->query($sql);
			//echo $query->rowCount();
			//exit;
			return($query->rowCount() == 1) ? true : false; 	
		}
	}
?>
