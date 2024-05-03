<?php 

class condition {

	protected $php_file = "";

	protected $true = false;

	protected $parameter = array();

	protected $post = array();

	protected $option = array();

	public function __construct(){

	}

	public function parse($condition){

		$this->true = true;

		$d = explode("|", $condition);

		$this->php_file = str_replace("[theme_id]", intval($_SESSION["admin"]["theme_id"]), $d[1]);

		$p = explode(",", $d[2]);

		for($i = 0;$i < count($p);$i++){

			$key_val = explode(":", $p[$i]);

			if(count($key_val) == 2){

				$this->parameter[$key_val[0]] = $key_val[1];

			}

		}

		$this->post = explode(",", $d[3]);

		$option = explode(",", $d[4]);

		for($i = 0;$i < count($option);$i++){

			$key_val = explode(":", $option[$i]);

			if(count($key_val) == 2){

				$this->option[$key_val[0]] = $key_val[1];

			}

		}

		$ands = explode("&&", $d[0]);

		for($i = 0;$i < count($ands);$i++){

			if($this->true == true){

				$this->true = $this->check($ands[$i]);

			}else{

				return false;

			}

		}

		return $this->true;

	}

	protected function check($condition){

		$parameter = explode("[", $condition);

		$options = explode(":", str_replace("]", "", $parameter[1]));

		switch($parameter[0]){

			case "isset": 
				if($options[0] == "post"){
					if(isset($_POST[$options[1]])){return true;}
				}
				if($options[0] == "get"){
					if(isset($_GET[$options[1]])){return true;}
				}
				break;

			case "equal": 
				if($options[0] == "post"){
					if($_POST[$options[1]] == $options[2]){return true;}
				}
				if($options[0] == "get"){
					if($_GET[$options[1]] == $options[2]){return true;}
				}
				break;

			case "greater": 
				if($options[0] == "post"){
					if(intval($_POST[$options[1]]) > intval($options[2])){return true;}
				}
				if($options[0] == "get"){
					if(intval($_GET[$options[1]]) > intval($options[2])){return true;}
				}
				break;

			case "lessequal": 
				if($options[0] == "post"){
					if(intval($_POST[$options[1]]) <= intval($options[2])){return true;}
				}
				if($options[0] == "get"){
					if(intval($_GET[$options[1]]) <= intval($options[2])){return true;}
				}
				break;

			case "notisset": 
				if($options[0] == "post"){
					if(!isset($_POST[$options[1]])){return true;}
				}
				if($options[0] == "get"){
					if(!isset($_GET[$options[1]])){return true;}
				}
				break;

			case "session": 
				if($_SESSION[$options[0]][$options[1]][$options[2]] == intval($options[3])){return true;}
				break;

		}

		return false;

	}

	public function parameter(){

		return $this->parameter;

	}

	public function option(){

		return $this->option;

	}

	public function phpFile(){

		if(isset($this->option['set_get_id_to_post_id'])){

			$_POST['id'] = intval($_GET['id']);

		}

		for($i = 0;$i < count($this->post);$i++){

			$key_val = explode(":", $this->post[$i]);

			if($key_val[0] != ""){

				$_POST[$key_val[0]] = $key_val[1];

			}

		}

		return $this->php_file;

	}

}

?>