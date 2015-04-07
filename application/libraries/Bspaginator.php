<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bspaginator {

	/* Base URL  */
	var $base_url = '';

	/* Table Headers */
	var $headers = array();

	/* Pagination */
	var $per_page = 15;
	var $cur_page =  1;
	var $total_rows	= 0;
	var $offset = 0;

	/* Sorting and Ordering */
	var $order_by_field = '';
	var $order_by_direction = 'ASC';

	/* Search */
	var $search = '';
	var $date_from = '';
	var $date_to = '';
	var $diagnosis = '';

	public function config($options = array()){
		if (count($options) > 0) {
			foreach ($options as $key => $val) {
				if (isset($this->$key)) {
					$this->$key = $val;
				}
			}
		}

		$this->offset = ($this->cur_page - 1) * $this->per_page;
	}

	public function table_header(){

		$html = "<thead>";
		$html .= "<tr>";

		foreach($this->headers as $key => $val) {

			$direction = ($this->order_by_direction == 'ASC' ? 'DESC' : 'ASC');

			$html .= "<th>";
			if($this->search != '') {
				$html .= "<a href='$this->base_url/?page=".$this->cur_page."&order_by_field=".$val."&order_by_direction=".$direction."&search=".$this->search;
			}
			if($this->search == '') {
				$html .= "<a href='$this->base_url/?page=".$this->cur_page."&order_by_field=".$val."&order_by_direction=".$direction;
			}

			if($this->date_from != '') {
				$html .= "&date_from=".$this->date_from;;
			}

			if($this->date_to != '') {
				$html .= "&date_to=".$this->date_to;;
			}

			if($this->diagnosis != '') {
				$html .= "&diagnosis=".$this->diagnosis;
			}

			$html .= "'>$key";

			if($this->order_by_field == $val){
				if($this->order_by_direction == 'ASC') {
					$html .="<span style='margin-left:5px;'><i class='icon-chevron-up'></i></span>";
				} else {
					$html .="<span style='margin-left:5px;'><i class='icon-chevron-down'></i></span>";
				}
			}
			$html .= "</a>";
			$html .= "</th>";
		}

		$html .= "<th></th>";

		$html .= "</tr>";
		$html .= "</thead>";

		return $html;
	}

	public function pagination_links(){

		if($this->total_rows < $this->per_page){
			return "
			<div class='pagination'>
				<ul>
					<li class='active'><a href='#'>First</a></li>
					".$this->generate_link(1, '1')."
					<li class='active'><a href='#'>Last</a></li>
				</ul>
			</div>";
		}

		$total_pages = ceil($this->total_rows / $this->per_page) + 1;

		$show_first = ($this->cur_page > 2);
		$show_prev = ($this->cur_page > 1 && $total_pages > 2);
		$show_next = ($this->cur_page < ($total_pages - 1)  && $total_pages > 3);
		$show_last = $this->cur_page < (($total_pages - 1) - 1);

		$html = "";
		$html .= "<div class='pagination'>";

		$html .= "<ul>";

		if($show_first){
			$html .= $this->generate_link(1, 'First');
		}

		if($show_prev){
			$prev = $this->cur_page - 1;
			$html .= $this->generate_link($prev, 'Prev');
		}

		$start = ($this->cur_page > 2) ? ($this->cur_page - 2) : 1 ;
		$end = ($this->cur_page < ($total_pages - 2)) ? ($this->cur_page + 3) : $total_pages;

		for($i = $start; $i < $end; $i++){
			if($this->cur_page == $i){
				$html .= $this->generate_link($i, $i, 1);
			} else{
				$html .= $this->generate_link($i, $i);
			}
		}

		if($show_next){
			$next = $this->cur_page + 1;
			$html .= $this->generate_link($next, 'Next');
		}

		if($show_last){
			$html .= $this->generate_link($total_pages - 1, 'Last');
		}

		$html .= "</ul>";
		$html .= "</div>";
		$html .= "";

		return $html;
	}

	private function generate_link($page_num, $link_text = null, $active = false){

		if(is_null($link_text)){
			$link_text = $page_num;
		}

		$link = "<li>";
		if($active){
			$link = "<li class='active'>";
		}

		if($this->search != '') {
			$link .= "<a href='".$this->base_url."/?page=".$page_num."&order_by_field=".$this->order_by_field."&order_by_direction=".$this->order_by_direction."&search=".$this->search;
		}
		if($this->search == '') {
			$link .= "<a href='".$this->base_url."/?page=".$page_num."&order_by_field=".$this->order_by_field."&order_by_direction=".$this->order_by_direction;
		}

		if($this->date_from != '') {
			$link .= "&date_from=".$this->date_from;
		}

		if($this->date_to != '') {
			$link .= "&date_to=".$this->date_to;
		}

		if($this->diagnosis != '') {
			$link .= "&diagnosis=".$this->diagnosis;
		}

		$link .= "'>".$link_text."</a>";

		$link .= "</li>";

		return $link;
	}
}

/* End of file Someclass.php */