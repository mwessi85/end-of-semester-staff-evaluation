<?php
	//require_once(LIB_PATH."database_object.php");
	class Branch{
		private static $array = array('1'=>'nkozi', '2'=>'rubaga', '3'=>'masaka', '4'=>'mbale', '8'=>'kabale');
		public static function getBranches() {
			return self::$array;
		}
	}
	//$branches = Branch::getBranches();

?>
