<?php 

class pageList {

	var $pageNavi = "";
	var $pageInfo = "";
	var $has_entries = false;

	/**
	* Set Param
	*
	* @param array $text Labels for (page, of, start, next, back, end, seperator)
	* @param int $count Amount of entries
	* @param int $pos Actual position = pagenumber * rows
	* @param int $rows Max rows per page 
	* @param string $file this name links to a file 
	* @param string $getParam to add parameters on links 
	* @param int $startEndLimit by this value start and end links are show
	* @param int $showShortLinks enables short links 
	* 
	* @return void
	*/
	function setParam(	$text = array(	"page" 		=> "Seite", 
										"of" 		=> "von", 
										"start" 	=> "|&lt;&lt;", 
										"next" 		=> "Weiter", 
										"back" 		=> "Zur&uuml;ck", 
										"end" 		=> "&gt;&gt;|", 
										"seperator" => "| "), 
						$count = 0, 
						$pos = 0, 
						$rows = 0, 
						$selname = "/pos", 
						$file = "", 
						$getParam = "", 
						$startEndLimit = 10, 
						$showShortLinks = 1){

		// amount of number links 
		$numbers = 5;

		$pages = 1;

		if($count > $rows){

			$pages = intval($count / $rows);

			if($count % $rows){

				$pages++;

			}

		}

		if($pos > 0) {

			$back = $pos - $rows;

			if($back < 0){

				$back = 0;

			}

			$this->pageNavi .= $pages > $startEndLimit ? "<td width=\"20\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/0" . $getParam . "\" class=\"page-link\">" . $text['start'] . "</a></li></ul></nav></td>" : "";

			$this->pageNavi .= "<td width=\"73\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . $back . $getParam . "\" class=\"page-link\">" . $text['back'] . "</a></li></ul></nav></td>";

			$this->pageNavi .= 	($pos / $rows) < ($pages - 10) && $pos > ($rows * 10) && $showShortLinks == 1 ? 
								"<td width=\"20\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . ($pos - (10 * $rows)) . "" . $getParam . "\" class=\"page-link\">" . ((($pos - (10 * $rows)) / $rows) + 1) . "</a></li></ul></nav></td>" : 
								(($pos > ($rows * 10) && $showShortLinks == 1 ? 
								"<td width=\"20\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . ($pos - (10 * $rows)) . "" . $getParam . "\" class=\"page-link\">" . ((($pos - (10 * $rows)) / $rows) + 1) . "</a></li></ul></nav></td>" : 
								(
									($pos/$rows) < ($pages - 10) && $showShortLinks == 1 ?
										"<td width=\"20\">&nbsp;</td>" : 
										""
								
									))
								);

		}else{

			$this->pageNavi .= $pages > $startEndLimit ? "<td width=\"20\">&nbsp;</td>" : "";

			$this->pageNavi .= "<td width=\"73\">&nbsp;</td>";

			$this->pageNavi .= ($pos / $rows) < ($pages - 10) && $showShortLinks == 1 ? "<td width=\"20\">&nbsp;</td>" : "";

		}


		if($pages > 1){

			$anz = $pos >= $rows ? (1 + $pos / $rows) : 1;

			$this->pageInfo = "" . $text['page'] . " " . $anz . " " . $text['of'] . " " . $pages;

			$this->pageNavi .= "<td align=\"center\" style=\"text-align: center\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\">";

			$step = 0;

			$start = 0;
			$end = $pages;

			for($i = 1; $i <= $pages; $i++){

				$fwd = ($i - 1) * $rows;

				if($anz >= round($numbers/2)){
					if($anz <= $pages - round($numbers/2)){
						$start = $anz - round($numbers/2);
					}else{
						$start = $pages - $numbers;
					}
				}

				if($anz - round($numbers/2) <= $pages){
					if($anz >= round($numbers/2)){
						$end = $anz + round($numbers/2);
					}else{
						$end = $numbers + 1;
					}
				}


				if($i > $start && $i < $end){

					//if($step > 0){$this->pageNavi .= $text['seperator'];}

					if($pos == $fwd){

						$this->pageNavi .= "<li class=\"page-item active\"><a href=\"#\" class=\"page-link\">" . $i . "</a></li>";

					}else{

						$this->pageNavi .= "<li class=\"page-item\"><a href=\"" . $file . $selname . "/" . $fwd . $getParam . "\" class=\"page-link\">" . $i . "</a></li>";

					}

					$step++;

				}

				$this->has_entries = true;

			}

			$this->pageNavi .= "</ul></nav></td>";

		}

		$this->pageNavi .= 	($pos / $rows) < ($pages - 10) && $pos > ($rows * 10) && $showShortLinks == 1  ? 
							"<td width=\"20\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . ($pos + (10 * $rows)) . "" . $getParam . "\" class=\"page-link\">" . ((($pos + (10 * $rows)) / $rows) + 1) . "</a></li></ul></nav></td>" : 
							($pos > ($rows * 10) && $showShortLinks == 1 ? 
							"<td width=\"20\">&nbsp;</td>" : 
							(($pos / $rows) < ($pages - 10) && $showShortLinks == 1 ? 
							"<td width=\"20\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . ($pos + (10 * $rows)) . "" . $getParam . "\" class=\"page-link\">" . ((($pos + (10 * $rows)) / $rows) + 1) . "</a></li></ul></nav></td>" : 
							""));

		if($pos < $count - $rows) {

			$fwd = $pos + $rows;

			$this->pageNavi .= "<td width=\"73\" align=\"right\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . $fwd . $getParam . "\" class=\"page-link\">" . $text['next'] . "</a></li></ul></nav></td>";

			$this->pageNavi .= $pages > $startEndLimit ? "<td width=\"20\" align=\"right\"><nav aria-label=\"Page navigation\"><ul class=\"pagination pagination-sm justify-content-center\"><li class=\"page-item\"><a href=\"" . $file . $selname . "/" . (($pages * $rows) - $rows) . $getParam . "\" class=\"page-link\">" . $text['end'] . "</a></li></ul></nav></td>" : "";

		}else{

			$this->pageNavi .= "<td width=\"73\" align=\"right\">&nbsp;</td>";

			$this->pageNavi .= $pages > $startEndLimit ? "<td width=\"20\" align=\"right\">&nbsp;</td>" : "";

		}

	}

	function getNavi(){

		return 	$this->pageNavi != "" && $this->has_entries == true ? 
				"<style>.pageNumber {padding: 2px;}</style>\n" . 
				"<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\"><tr>" . $this->pageNavi . "</tr></table><br />\n" : 
				"";

	}
	
	function getInfo(){

		return $this->pageInfo != "" && $this->has_entries == true ? "<small class=\"text-muted\">" . $this->pageInfo . "</small><br />\n" : "";

	}

}

?>
