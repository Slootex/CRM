<?php 

class navigation {

	protected $authorization = "";

	protected $data = array();

	public $options = array(
		"color" => "success", 
		"main_href_link_normal" => "<a href=\"[href]\" title=\"[title]\" style=\"font-size: 1rem\" class=\"navbar-brand extra-hover text-[color] p-0\">[name]</a>\n", 
		"main_href_link_active" => "<a href=\"[href]\" title=\"[title]\" style=\"font-size: 1rem\" class=\"navbar-brand extra-link text-[color] p-0\">[name]</a>\n", 
		"main_hash_link_normal" => "	<li class=\"nav-item dropdown\">\n		<a href=\"[href]\" title=\"[title]\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class=\"dropdown-toggle nav-link text-[color] py-1\">[name]</a>\n[submenu]	</li>\n", 
		"main_hash_link_active" => "	<li class=\"nav-item dropdown\">\n		<a href=\"[href]\" title=\"[title]\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" class=\"dropdown-toggle nav-link text-[color] py-1\"><u>[name]</u></a>\n[submenu]	</li>\n", 
		"sub_container" => "		<ul class=\"dropdown-menu\" role=\"menu\">\n[submenu]		</ul>\n", 
		"sub_link_normal" => "			<li class=\"nav-item\"><a href=\"[href]\" title=\"[title]\" class=\"dropdown-item\">[name]</a></li>\n", 
		"sub_link_active" => "			<li class=\"nav-item\"><a href=\"[href]\" title=\"[title]\" class=\"dropdown-item bg-[color] active\">[name]</a></li>\n"
	);

	public function __construct($db, $menu_id, $authorization){

		$this->authorization = $authorization;

		$result = mysqli_query($db, "SELECT * FROM `navigation` WHERE `navigation`.`menu_id`='" . $menu_id . "' AND `navigation`.`enable`='1' ORDER BY CAST(`navigation`.`pos` AS UNSIGNED) ASC");

		while($row = $result->fetch_array(MYSQLI_ASSOC)){

			$this->data[] = $row;

		}

		$this->options['color'] = (isset($_SESSION["admin"]["color_link"]) ? $_SESSION["admin"]["color_link"] : "success");

	}

	public function show(){

		$menu = "";

		for($i = 0;$i < count($this->data);$i++){

			if($this->data[$i]['parent_id'] == 0){

				if($this->data[$i]['href'] == "#"){

					$active = false;

					$authorization = false;

					$submenu = "";

					for($j = 0;$j < count($this->data);$j++){

						if($this->data[$j]['parent_id'] == $this->data[$i]['id']){

							if(isset($_SESSION["admin"]["roles"][$this->data[$j]['authorization']]) && $_SESSION["admin"]["roles"][$this->data[$j]['authorization']] == 1){

								$active = true;

								if($this->data[$j]['authorization'] == $this->authorization || $this->data[$j]['authorization2'] == $this->authorization){

									$authorization = true;

									$submenu .= str_replace("[href]", $this->data[$j]['href'], str_replace("[title]", $this->data[$j]['title'], str_replace("[name]", $this->data[$j]['name'], str_replace("[color]", $this->options['color'], $this->options['sub_link_active']))));

								}else{

									$submenu .= str_replace("[href]", $this->data[$j]['href'], str_replace("[title]", $this->data[$j]['title'], str_replace("[name]", $this->data[$j]['name'], str_replace("[color]", $this->options['color'], $this->options['sub_link_normal']))));

								}
								
							}

						}

					}

					if($active == true){

						$submenu = str_replace("[submenu]", $submenu, $this->options['sub_container']);

						if($authorization == true){

							$menu .= str_replace("[href]", $this->data[$i]['href'], str_replace("[title]", $this->data[$i]['title'], str_replace("[name]", $this->data[$i]['name'], str_replace("[color]", $this->options['color'], str_replace("[submenu]", $submenu, $this->options['main_hash_link_active'])))));

						}else{

							$menu .= str_replace("[href]", $this->data[$i]['href'], str_replace("[title]", $this->data[$i]['title'], str_replace("[name]", $this->data[$i]['name'], str_replace("[color]", $this->options['color'], str_replace("[submenu]", $submenu, $this->options['main_hash_link_normal'])))));

						}

					}

				}else{

					if(isset($_SESSION["admin"]["roles"][$this->data[$i]['authorization']]) && $_SESSION["admin"]["roles"][$this->data[$i]['authorization']] == 1){

						if($this->data[$i]['authorization'] == $this->authorization || $this->data[$i]['authorization2'] == $this->authorization){

							$menu .= 	str_replace("[href]", $this->data[$i]['href'], str_replace("[title]", $this->data[$i]['title'], str_replace("[name]", $this->data[$i]['name'], str_replace("[color]", $this->options['color'], $this->options['main_href_link_active']))));

						}else{

							$menu .= 	str_replace("[href]", $this->data[$i]['href'], str_replace("[title]", $this->data[$i]['title'], str_replace("[name]", $this->data[$i]['name'], str_replace("[color]", $this->options['color'], $this->options['main_href_link_normal']))));

						}

					}

				}

			}

		}

		return $menu;

	}

}

?>